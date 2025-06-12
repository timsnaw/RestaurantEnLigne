<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__, 2) . '/');
}

require_once BASE_PATH . 'config/connexion.php';
require_once BASE_PATH . 'models/AdminModificationModel.php';

class AdminModificationController {
    private $model;

    public function __construct($pdo) {
        $this->model = new AdminModificationModel($pdo);
    }

    // Gere les demandes pour les differentes pages
    public function gererDemande() {
        if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?page=admin_login");
            exit;
        }
        
        $action = isset($_GET['page']) ? $_GET['page'] : 'admin_info';

        switch ($action) {
            case 'admin_info':
                $this->gererAdminInfo();
                break;
            case 'admin_details':
                $this->gererAdminDetails();
                break;
            case 'admin_edit':
                $this->gererAdminEdit();
                break;
            case 'admin_delete':
                $this->gererAdminDelete();
                break;
            default:
                $_SESSION['error'] = "Action invalide demandée.";
                header("Location: index.php?page=admin_info");
                exit;
        }
    }

    // Affiche la liste de tous les administrateurs
    private function gererAdminInfo() {
        try {
            $admins = $this->model->getToutAdmin();
            $view_file = BASE_PATH . 'view/admin/admin_info.php';
            if (!file_exists($view_file)) {
                throw new Exception("Fichier de vue introuvable: $view_file");
            }
            require_once $view_file;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            $view_file = BASE_PATH . 'view/admin/admin_info.php';
            if (file_exists($view_file)) {
                require_once $view_file;
            } else {
                die("Erreur dans le contrôleur gererDemande: " . $e->getMessage());
            }
        }
    }

    // Affiche les détails d'un administrateur à partir de son ID
    private function gererAdminDetails() {
        $user_id = $this->validerUserId();
        $adminInfo = $this->getAdminInfo($user_id);
        $view_file = BASE_PATH . 'view/admin/admin_details.php';
        if (!file_exists($view_file)) {
            throw new Exception("Erreur dans le contrôleur gererAdminDetails: $view_file");
        }
        require_once $view_file;
    }

    // Permet de modifier les informations d'un admin
    private function gererAdminEdit() {
        $user_id = $this->validerUserId();
        $adminInfo = $this->getAdminInfo($user_id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->modifierForm($user_id);
        }

        $view_file = BASE_PATH . 'view/admin/admin_edit.php';
        if (!file_exists($view_file)) {
            throw new Exception("Erreur dans le contrôleur gererAdminEdit: $view_file");
        }
        require_once $view_file;
    }

    // Permet de supprimer un admin
    private function gererAdminDelete() {
        $user_id = $this->validerUserId();
        try {
            if ($this->model->deleteAdmin($user_id)) {
                $_SESSION['success'] = "L'administrateur a été supprimé avec succès.";
            } else {
                $_SESSION['error'] = "Échec de la suppression de l'administrateur.";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur de suppression admin: " . $e->getMessage();
        }
        header("Location: index.php?page=admin_info");
        exit;
    }

    // Valide l'ID de l'utilisateur
    private function validerUserId() {
        $user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
        if ($user_id <= 0) {
            $_SESSION['error'] = "ID utilisateur non valide.";
            header("Location: index.php?page=admin_info");
            exit;
        }
        return $user_id;
    }

    // Récupère les informations d’un administrateur par son ID
    private function getAdminInfo($user_id) {
        try {
            $adminInfo = $this->model->getAdminById($user_id);
            if (!$adminInfo) {
                $_SESSION['error'] = "Administrateur non trouvé.";
                header("Location: index.php?page=admin_info");
                exit;
            }
            return $adminInfo;
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors de la récupération de l'administrateur: " . $e->getMessage();
            header("Location: index.php?page=admin_info");
            exit;
        }
    }

    // Traite le formulaire de modification d’un administrateur
    private function modifierForm($user_id) {
        $username = trim($_POST['username'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $nom = trim($_POST['nom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($username) || empty($prenom) || empty($nom) || empty($email)) {
            $_SESSION['error'] = "Tous les champs sont obligatoires.";
        } elseif ($this->model->usernameExiste($username, $user_id)) {
            $_SESSION['error'] = "Username déjà existant.";
        } elseif ($this->model->emailExiste($email, $user_id)) {
            $_SESSION['error'] = "Email déjà existant.";
        } elseif ($password && $password !== $confirm_password) {
            $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
        } elseif ($password && strlen($password) < 6) {
            $_SESSION['error'] = "Le mot de passe doit comporter au moins 6 caractères.";
        } else {
            try {
                if ($this->model->modifierAdmin($user_id, $username, $prenom, $nom, $email, $password ?: null)) {
                    $_SESSION['success'] = "L'administrateur a été mis à jour avec succès.";
                    header("Location: index.php?page=admin_details&user_id=$user_id");
                    exit;
                }
                $_SESSION['error'] = "Échec de la mise à jour de l'administrateur.";
            } catch (Exception $e) {
                $_SESSION['error'] = "Erreur lors de la mise à jour de l'administrateur: " . $e->getMessage();
            }
        }
    }
}
?>