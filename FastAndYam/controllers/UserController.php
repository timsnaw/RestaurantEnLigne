<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

// Inclusion des fichiers necessaires
require_once BASE_PATH . 'config/connexion.php';
require_once BASE_PATH . 'models/UserModel.php';

class UserController {
    private $model;
// Constructeur 
    public function __construct($pdo) {
        $this->model = new UserModel($pdo);
    }
    // gerer les pages
    public function gererDemande($page = 'userPage') {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id']) && !in_array($page, ['login_user', 'register_user'])) {
            header('Location: index.php?page=login_user');
            exit;
        }

        switch ($page) {
            case 'utilisateur_info':
                $this->userInfo();
                break;
            case 'utilisateur_edit':
                $this->userEdit();
                break;
            case 'userPage':
                include BASE_PATH . 'view/user/userPage.php';
                break;
            case 'commande_user_info':
                $this->commandesInfo();
                break;
            case 'update_user':
                $this->updateUser();
                break;
            case 'update_password':
                $this->modifierPassword();
                break;
            case 'delete_account':
                $this->SupprimeCompte();
                break;
            case 'cancel_order':
                $this->AnnuleCommande();
                break;
            case 'login_user':
                $this->login_user();
                break;
            case 'register_user':
                $this->register();
                break;
            case 'logout_user':
                $this->logout();
                break;
            default:
                include BASE_PATH . 'view/user/userPage.php';
                break;
        }
    }

    // Affiche les informations de l'utilisateur
    private function userInfo() {
        // verification de session
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login_user');
            exit;
        }
        // recuperation des donnee et inclusion de la vue
        $user = $this->model->getUserInfo($_SESSION['user_id']);
        include BASE_PATH . 'view/user/utilisateur_info.php';
    }

    // Affiche le formulaire d'édition du profil
    private function userEdit() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login_user');
            exit;
        }
        $user = $this->model->getUserInfo($_SESSION['user_id']);
        include BASE_PATH . 'view/user/utilisateur_edit.php';
    }

//  Affiche les commandes de l'utilisateur
    private function commandesInfo() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login_user');
            exit;
        }
        $orders = $this->model->getUserOrders($_SESSION['user_id']);
        include BASE_PATH . 'view/user/commande_user_info.php';
    }

 // Met a jour les informations de l'utilisateur
    private function updateUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? '';
            if (empty($csrf_token) || !isset($_SESSION['csrf_token']) || $csrf_token !== $_SESSION['csrf_token']) {
                $_SESSION['error'] = "Erreur de validation du formulaire.";
                header('Location: index.php?page=utilisateur_edit');
                exit;
            }

            // Preparation des donnees avec sanitisation
            $data = [
                'username' => filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS) ?: '',
                'prenom' => filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS) ?: null,
                'nom' => filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS) ?: null,
                'email' => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL) ?: '',
                'telephone' => filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_SPECIAL_CHARS) ?: null,
                'adresse' => filter_input(INPUT_POST, 'adresse', FILTER_SANITIZE_SPECIAL_CHARS) ?: null,
                'image_client' => null
            ];

            // Gestion de l'upload d'image
            if (!empty($_FILES['image_client']['name']) && $_FILES['image_client']['error'] === UPLOAD_ERR_OK) {
                $upload_img = 'public/images/';
                if (!is_dir($upload_img)) {
                    mkdir($upload_img, 0755, true);
                }

                // Configuration des restrictions
                $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                $max_size = 5 * 1024 * 1024; // 5MB
                $file = $_FILES['image_client'];

                // Verification de la taille
                if ($file['size'] > $max_size) {
                    $_SESSION['error'] = "L'image ne doit pas dépasser 5 Mo.";
                    header('Location: index.php?page=utilisateur_edit');
                    exit;
                }

                // Verification de l'extension
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                if (!in_array($ext, $allowed_extensions)) {
                    $_SESSION['error'] = "Seuls les formats JPEG, PNG et GIF sont autorisés.";
                    header('Location: index.php?page=utilisateur_edit');
                    exit;
                }

                // Generation d'un nom unique
                $filename = uniqid('client_') . '.' . $ext;
                $destination = $upload_img . $filename;

                // Delete old image if it exists
                $current_image = $this->model->getCurrentImage($_SESSION['user_id']);
                if ($current_image && file_exists($upload_img . $current_image)) {
                    unlink($upload_img . $current_image);
                }

                // Suppression de l'ancienne image si elle existe
                if (!move_uploaded_file($file['tmp_name'], $destination)) {
                    $_SESSION['error'] = "Erreur lors du téléchargement de l'image.";
                    header('Location: index.php?page=utilisateur_edit');
                    exit;
                }

                $data['image_client'] = $filename;
            }

            // Validation des champs obligatoire
            if (empty($data['username']) || empty($data['email'])) {
                $_SESSION['error'] = "Nom d'utilisateur et email sont obligatoires.";
                header('Location: index.php?page=utilisateur_edit');
                exit;
            }

            // Mise a jour en base de données
            if ($this->model->modifierUserInfo($_SESSION['user_id'], $data)) {
                $_SESSION['message'] = "Informations mises à jour avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la mise à jour.";
            }
            header('Location: index.php?page=utilisateur_info');
            exit;
        }
    }

    // Met a jour le mot de passe de l'utilisateur
    private function modifierPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? '';
            if (empty($csrf_token) || !isset($_SESSION['csrf_token']) || $csrf_token !== $_SESSION['csrf_token']) {
                $_SESSION['error'] = "Erreur de validation du formulaire.";
                header('Location: index.php?page=utilisateur_edit');
                exit;
            }

            // recuperation des mots de passe
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            // Validation des champs
            if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
                $_SESSION['error'] = "Tous les champs de mot de passe sont obligatoires.";
                header('Location: index.php?page=utilisateur_edit');
                exit;
            }

            // Verification de la correspondance
            if ($new_password !== $confirm_password) {
                $_SESSION['error'] = "Les nouveaux mots de passe ne correspondent pas.";
                header('Location: index.php?page=utilisateur_edit');
                exit;
            }

            // Verification de la longueur
            if (strlen($new_password) < 6) {
                $_SESSION['error'] = "Le nouveau mot de passe doit contenir au moins 6 caractères.";
                header('Location: index.php?page=utilisateur_edit');
                exit;
            }

            // Verification de l'ancien mot de passe
            if (!$this->model->verifiePassword($_SESSION['user_id'], $current_password)) {
                $_SESSION['error'] = "Mot de passe actuel incorrect.";
                header('Location: index.php?page=utilisateur_edit');
                exit;
            }

            // Mise à jour du mot de passe
            if ($this->model->modifierPassword($_SESSION['user_id'], $new_password)) {
                $_SESSION['message'] = "Mot de passe mis à jour avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la mise à jour du mot de passe.";
            }
            header('Location: index.php?page=utilisateur_edit');
            exit;
        }
    }

    // Supprime le compte utilisateur
    private function SupprimeCompte() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? '';
            if (empty($csrf_token) || !isset($_SESSION['csrf_token']) || $csrf_token !== $_SESSION['csrf_token']) {
                $_SESSION['error'] = "Erreur de validation du formulaire.";
                header('Location: index.php?page=login_user');
                exit;
            }

            if ($this->model->deleteUser($_SESSION['user_id'])) {
                session_destroy();
                header('Location: index.php?page=login_user');
                exit;
            } else {
                $_SESSION['error'] = "Erreur lors de la suppression du compte.";
                header('Location: index.php?page=utilisateur_edit');
                exit;
            }
        }
    }

    // Annule une commande
    private function AnnuleCommande() {
        if (isset($_GET['commande_id'])) {
            $commande_id = filter_input(INPUT_GET, 'commande_id', FILTER_SANITIZE_NUMBER_INT);
            $order = $this->model->getOrderStatus($commande_id, $_SESSION['user_id']);
            
            if ($order && $order['etat_commande'] == 1) {
                if ($this->model->cancelOrder($commande_id)) {
                    $_SESSION['message'] = "Commande annulée avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de l'annulation de la commande.";
                }
            } else {
                $_SESSION['error'] = "La commande ne peut pas être annulée.";
            }
            header('Location: index.php?page=commande_user_info');
            exit;
        }
    }

    // Gere la connexion de l'utilisateur
    private function login_user() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? '';
            if (empty($csrf_token) || !isset($_SESSION['csrf_token']) || $csrf_token !== $_SESSION['csrf_token']) {
                $_SESSION['error'] = "Erreur de validation du formulaire.";
                error_log("CSRF validation failed: Sent=$csrf_token, Expected=" . ($_SESSION['csrf_token'] ?? 'none'));
                header('Location: index.php?page=login_user');
                exit;
            }

            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'] ?? '';

            if (!$email) {
                $_SESSION['error'] = "Adresse email invalide.";
                header('Location: index.php?page=login_user');
                exit;
            }

            if (empty($password)) {
                $_SESSION['error'] = "Le mot de passe est requis.";
                header('Location: index.php?page=login_user');
                exit;
            }

            $user_id = $this->model->login($email, $password);
            if ($user_id) {
                $_SESSION['user_id'] = $user_id;
                unset($_SESSION['csrf_token']);
                header('Location: index.php?page=userPage');
                exit;
            } else {
                $_SESSION['error'] = "Email ou mot de passe incorrect.";
                error_log("Login failed for email: $email");
                header('Location: index.php?page=login_user');
                exit;
            }
        }
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        include BASE_PATH . 'view/user/login_user.php';
    }

    // Gere l'inscription d'un nouvel utilisateur
    private function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? '';
            if (empty($csrf_token) || !isset($_SESSION['csrf_token']) || $csrf_token !== $_SESSION['csrf_token']) {
                $_SESSION['error'] = "Erreur de validation du formulaire.";
                error_log("CSRF validation failed: Sent=$csrf_token, Expected=" . ($_SESSION['csrf_token'] ?? 'none'));
                header('Location: index.php?page=register_user');
                exit;
            }

             // Préparation des données
            $data = [
                'username' => filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS) ?: '',
                'prenom' => filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS) ?: null,
                'nom' => filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS) ?: null,
                'email' => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL) ?: '',
                'telephone' => filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_SPECIAL_CHARS) ?: null,
                'adresse' => filter_input(INPUT_POST, 'adresse', FILTER_SANITIZE_SPECIAL_CHARS) ?: null,
                'password' => $_POST['password'] ?? '',
                'password_confirm' => $_POST['password_confirm'] ?? ''
            ];

            // Validation des champs obligatoires
            if (empty($data['username']) || empty($data['email']) || empty($data['password']) || empty($data['password_confirm'])) {
                $_SESSION['error'] = "Tous les champs obligatoires doivent être remplis.";
                header('Location: index.php?page=register_user');
                exit;
            }

            // Vérification de la correspondance des mots de passe
            if ($data['password'] !== $data['password_confirm']) {
                $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
                header('Location: index.php?page=register_user');
                exit;
            }
            // verification de la longueur du mot de passe
            if (strlen($data['password']) < 6) {
                $_SESSION['error'] = "Le mot de passe doit contenir au moins 6 caractères.";
                header('Location: index.php?page=register_user');
                exit;
            }

            // Tentative d'inscription
            if ($this->model->register($data)) {
                $_SESSION['message'] = "Inscription réussie ! Veuillez vous connecter.";
                unset($_SESSION['csrf_token']);
                header('Location: index.php?page=login_user');
                exit;
            } else {
                $_SESSION['error'] = "Erreur lors de l'inscription. L'email ou le nom d'utilisateur existe déjà.";
                header('Location: index.php?page=register_user');
                exit;
            }
        }
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        include BASE_PATH . 'view/user/register_user.php';
    }
    
// Déconnecte l'utilisateur
    private function logout() {
        session_destroy();
        header('Location: index.php?page=login_user');
        exit;
    }
}
?>