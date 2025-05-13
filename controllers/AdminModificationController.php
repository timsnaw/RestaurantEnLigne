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
// gere demande pour les deffairent page 
    public function gererDemande() {
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
                $_SESSION['error'] = "Invalid action requested.";
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
                throw new Exception("View file not found: $view_file");
            }
            require_once $view_file;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            $view_file = BASE_PATH . 'view/admin/admin_info.php';
            if (file_exists($view_file)) {
                require_once $view_file;
            } else {
                die("Error dans le controller gererDemande: " . $e->getMessage());
            }
        }
    }
// Affiche les details d'un administrateur a partir de son ID
    private function gererAdminDetails() {
        $admin_id = $this->validerAdminId();
        $adminInfo = $this->getAdminInfo($admin_id);
        $view_file = BASE_PATH . 'view/admin/admin_details.php';
        if (!file_exists($view_file)) {
            throw new Exception("Error dans le controller gererAdminDetails: $view_file");
        }
        require_once $view_file;
    }
// permet de modifier les information d'un admin
    private function gererAdminEdit() {
        $admin_id = $this->validerAdminId();
        $adminInfo = $this->getAdminInfo($admin_id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->modifierForm($admin_id);
        }

        $view_file = BASE_PATH . 'view/admin/admin_edit.php';
        if (!file_exists($view_file)) {
            throw new Exception("Error dans le controller gererAdminEdit: $view_file");
        }
        require_once $view_file;
    }
// permet de supprimer un admin
    private function gererAdminDelete() {
        $admin_id = $this->validerAdminId();
        try {
            if ($this->model->deleteAdmin($admin_id)) {
                $_SESSION['success'] = "L'administrateur a été supprimé avec succès.";
            } else {
                $_SESSION['error'] = "Echec de la suppression de l'administrateur.";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Error de suppression admin: " . $e->getMessage();
        }
        header("Location: index.php?page=admin_info");
        exit;
    }
// permet de valider admin
    private function validerAdminId() {
        $admin_id = isset($_GET['admin_id']) ? (int)$_GET['admin_id'] : 0;
        if ($admin_id <= 0) {
            $_SESSION['error'] = "ID administrateur non valide.";
            header("Location: index.php?page=admin_info");
            exit;
        }
        return $admin_id;
    }
// Recupere les informations d’un administrateur par son ID.
    private function getAdminInfo($admin_id) {
        try {
            $adminInfo = $this->model->getAdminById($admin_id);
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
// Traite le formulaire de modification d’un administrateur : vérifie les champs, les conflits et met à jour les données si tout est valide.

    private function modifierForm($admin_id) {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($username) || empty($email)) {
            $_SESSION['error'] = "Username et email sont obligatoires.";
        } elseif ($this->model->usernameExiste($username, $admin_id)) {
            $_SESSION['error'] = "Username deja existe.";
        } elseif ($this->model->emailExiste($email, $admin_id)) {
            $_SESSION['error'] = "Email deja existe.";
        } elseif ($password && $password !== $confirm_password) {
            $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
        } elseif ($password && strlen($password) < 6) {
            $_SESSION['error'] = "Le mot de passe doit comporter au moins 6 caractères.";
        } else {
            try {
                if ($this->model->modifierAdmin($admin_id, $username, $email, $password ?: null)) {
                    $_SESSION['success'] = "L'administrateur a été mis à jour avec succès.";
                    header("Location: index.php?page=admin_details&admin_id=$admin_id");
                    exit;
                }
                $_SESSION['error'] = "Echec de la mise à jour de l'administrateur.";
            } catch (Exception $e) {
                $_SESSION['error'] = "Erreur lors de la mise a jour de l'administrateur: " . $e->getMessage();
            }
        }
    }
}
?>