<?php
require_once BASE_PATH . 'models/AdminModel.php';

class AdminController {
    private $model;
    //creation d'un constrator
    public function __construct($pdo) {
        $this->model = new AdminModel($pdo);
    }
    // test email et le mot de passe 
    public function adminLogin() {
        if (isset($_POST['connexion'])) {
            
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            if (empty($email) || empty($password)) {
                $_SESSION['error'] = "Email et mot de passe requis.";
            } else {
                $adminId = $this->model->verifieAdmin($email, $password);
                if ($adminId) {
                    $_SESSION['admin_id'] = $adminId;
                    header("Location: index.php?page=admin");
                    exit;
                } else {
                    $_SESSION['error'] = "Email ou mot de passe incorrect.";
                }
            }
        }
        require_once BASE_PATH . 'view/admin/login.php';
    }

    //permet d'ajouter un utilisateurs
    public function adminRegister() {
        if (isset($_POST['inscrire']) ){
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (empty($username) || empty($email) || empty($password)) {
                $_SESSION['error'] = "Tous les champs sont requis.";
            } elseif ($password !== $confirm_password) {
                $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
            } elseif ($this->model->emailExiste($email)) {
                $_SESSION['error'] = "Email deja utilise.";
            } elseif ($this->model->usernameExiste($username)) {
                $_SESSION['error'] = "Nom d'utilisateur dejà pris.";
            } else {
                if ($this->model->creerAdmin($username, $email, $password)) {
                    header("Location: index.php?page=admin_login");
                    exit;
                } else {
                    $_SESSION['error'] = "echec de l'inscription.";
                }
            }
        }
        require_once BASE_PATH . 'view/admin/register.php';
    }

    //permet de voir les deffairent statistique
    public function adminStatistique() {
    if (!isset($_SESSION['admin_id'])) {
        header("Location: index.php?page=admin_login");
        exit;
    }
    $date = isset($_GET['date']) ? $_GET['date'] : null;
    $data = [
        'stats' => $this->model->getStatistique($date),
        'availableMonths' => $this->model->getMoisDisponible()
    ];
    require_once BASE_PATH . 'view/admin/statistique.php';
}
}
?>