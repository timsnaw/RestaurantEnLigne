<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__, 2) . '/');
}

require_once BASE_PATH . 'config/connexion.php';
require_once BASE_PATH . 'models/AdminModel.php';

class AdminController {
    private $model;

    // Constructeur
    public function __construct($pdo) {
        $this->model = new AdminModel($pdo);
    }

    // Gere les demandes pour les differentes pages
    public function gereDemande() {
        $page = isset($_GET['page']) ? $_GET['page'] : 'admin_login';

        switch ($page) {
            case 'admin_login':
                $this->adminLogin();
                break;
            case 'register':
                $this->adminRegister();
                break;
            case 'admin':
                $this->admin();
                break;
            case 'export_pdf':
                $this->exportPDF();
                break;
            case 'logout':
                $this->logout();
                break;
            case 'statistique':
                $this->adminStatistique();
                break;
            default:
                header("Location: index.php?page=statistique");
                exit;
        }
    }

    // Rediriger si non connecte ou si le role n'est pas admin
    public function admin() {
        if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?page=admin_login");
            exit;
        }

        require_once BASE_PATH . 'view/admin/adminPage.php';
    }


    // Test email et mot de passe 
    public function adminLogin() {
        if (isset($_POST['connexion'])) {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $_SESSION['error'] = "Email et mot de passe requis.";
            } else {
                $admin = $this->model->verifieAdmin($email, $password);
                if ($admin) {
                    $_SESSION['admin_id'] = $admin['user_id'];
                    $_SESSION['role'] = $admin['role'];
                    header("Location: index.php?page=admin");
                    exit;
                } else {
                    $_SESSION['error'] = "Email ou mot de passe incorrect.";
                }
            }
        }

        require_once BASE_PATH . 'view/admin/login.php';
    }


    // Permet d'ajouter un utilisateur
    public function adminRegister() {
    if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: index.php?page=admin_login");
        exit;
    }

    if (isset($_POST['inscrire'])) {
        $username = trim($_POST['username'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $nom = trim($_POST['nom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($username) || empty($prenom) || empty($nom) || empty($email) || empty($password)) {
            $_SESSION['error'] = "Tous les champs sont requis.";
        } elseif ($password !== $confirm_password) {
            $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
        } elseif ($this->model->emailExiste($email)) {
            $_SESSION['error'] = "Email déjà utilisé.";
        } elseif ($this->model->usernameExiste($username)) {
            $_SESSION['error'] = "Nom d'utilisateur déjà pris.";
        } else {
            if ($this->model->creerAdmin($username, $email, $password, $prenom, $nom)) {
                $_SESSION['success'] = "Inscription réussie. Veuillez vous connecter.";
                header("Location: index.php?page=register");
                exit;
            } else {
                $_SESSION['error'] = "Échec de l'inscription.";
            }
        }
    }

    require_once BASE_PATH . 'view/admin/register.php';
}


    // Permet de voir les differentes statistiques
    public function adminStatistique() {
    if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: index.php?page=admin_login");
        exit;
    }
    
    $date = isset($_GET['date']) ? $_GET['date'] : null;
    $data = [
        'stats' => $this->model->getStatistique(),
        'availableMonths' => $this->model->getMoisDisponible()
    ];
    require_once BASE_PATH . 'view/admin/statistique.php';
}


    // Gere l'exportation du PDF
    public function exportPDF() {
    if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: index.php?page=admin_login");
        exit;
    }

    $month = isset($_GET['month']) ? $_GET['month'] : null;
    $day = isset($_GET['day']) ? $_GET['day'] : null;

    $data = [
        'stats' => $this->model->getPDFStats($month, $day),
        'dailyRevenue' => $this->model->getDailyRevenue($month, $day),
        'debugDetails' => $this->model->getDebugDetails($month, $day),
        'month' => $month,
        'day' => $day,
        'hasDataForSelection' => !empty($this->model->getDailyRevenue($month, $day))
    ];

    require_once BASE_PATH . 'view/admin/export_pdf.php';
}


    // Gere la deconnexion
    public function logout() {
        session_unset();
        session_destroy();
        header("Location: index.php?page=admin_login");
        exit;
    }
}
?>