<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

// Inclusion des fichiers nécessaires
require_once BASE_PATH . 'config/connexion.php';
require_once BASE_PATH . 'models/UserModel.php';


class UserController {
    private $model;

    // Constructeur
    public function __construct($pdo) {
        $this->model = new UserModel($pdo);
    }

    // Gérer les pages
    public function gererDemande($page = 'userPage') {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id']) && !in_array($page, ['connexion', 'register_user'])) {
            header('Location: index.php?page=connexion');
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
            case 'connexion':
                $this->connexion();
                break;
            case 'register_user':
                $this->register();
                break;
            case 'logout_user':
                $this->logout();
                break;
            case 'export_facture': 
                $this->exportFacture();
                break;
            default:
                include BASE_PATH . 'view/user/userPage.php';
                break;
        }
    }

    // Affiche les informations de l'utilisateur
    private function userInfo() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=connexion');
            exit;
        }
        $user = $this->model->getUserInfo($_SESSION['user_id']);
        include BASE_PATH . 'view/user/utilisateur_info.php';
    }

    // Affiche le formulaire d'édition du profil
    private function userEdit() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=connexion');
            exit;
        }
        $user = $this->model->getUserInfo($_SESSION['user_id']);
        include BASE_PATH . 'view/user/utilisateur_edit.php';
    }

    // Affiche les commandes de l'utilisateur
    private function commandesInfo() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=connexion');
            exit;
        }
        $orders = $this->model->getUserOrders($_SESSION['user_id']);
        include BASE_PATH . 'view/user/commande_user_info.php';
    }

    // Met à jour les informations de l'utilisateur
    private function updateUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? '';
            if (empty($csrf_token) || !isset($_SESSION['csrf_token']) || $csrf_token !== $_SESSION['csrf_token']) {
                $_SESSION['error'] = "Erreur de validation du formulaire.";
                header('Location: index.php?page=utilisateur_edit');
                exit;
            }

            $data = [
                'username' => filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS) ?: '',
                'prenom' => filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS) ?: null,
                'nom' => filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS) ?: null,
                'email' => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL) ?: '',
                'telephone' => filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_SPECIAL_CHARS) ?: null,
                'adresse' => filter_input(INPUT_POST, 'adresse', FILTER_SANITIZE_SPECIAL_CHARS) ?: null,
                'image_client' => null
            ];

            if (!empty($_FILES['image_client']['name']) && $_FILES['image_client']['error'] === UPLOAD_ERR_OK) {
                $upload_img = BASE_PATH . 'public/img/';
                if (!is_dir($upload_img)) {
                    mkdir($upload_img, 0755, true);
                }

                $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                $max_size = 5 * 1024 * 1024; // 5MB
                $file = $_FILES['image_client'];

                if ($file['size'] > $max_size) {
                    $_SESSION['error'] = "L'image ne doit pas dépasser 5 Mo.";
                    header('Location: index.php?page=utilisateur_edit');
                    exit;
                }

                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                if (!in_array($ext, $allowed_extensions)) {
                    $_SESSION['error'] = "Seuls les formats JPEG, PNG et GIF sont autorisés.";
                    header('Location: index.php?page=utilisateur_edit');
                    exit;
                }

                $filename = uniqid('client_') . '.' . $ext;
                $destination = $upload_img . $filename;

                $current_image = $this->model->getCurrentImage($_SESSION['user_id']);
                if ($current_image && file_exists($upload_img . $current_image)) {
                    unlink($upload_img . $current_image);
                }

                if (!move_uploaded_file($file['tmp_name'], $destination)) {
                    $_SESSION['error'] = "Erreur lors du téléchargement de l'image.";
                    header('Location: index.php?page=utilisateur_edit');
                    exit;
                }

                $data['image_client'] = $filename;
            }

            if (empty($data['username']) || empty($data['email'])) {
                $_SESSION['error'] = "Nom d'utilisateur et email sont obligatoires.";
                header('Location: index.php?page=utilisateur_edit');
                exit;
            }

            if ($this->model->modifierUserInfo($_SESSION['user_id'], $data)) {
                $_SESSION['message'] = "Informations mises à jour avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la mise à jour.";
            }
            header('Location: index.php?page=utilisateur_info');
            exit;
        }
    }

    // Met à jour le mot de passe de l'utilisateur
    private function modifierPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? '';
            if (empty($csrf_token) || !isset($_SESSION['csrf_token']) || $csrf_token !== $_SESSION['csrf_token']) {
                $_SESSION['error'] = "Erreur de validation du formulaire.";
                header('Location: index.php?page=utilisateur_edit');
                exit;
            }

            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
                $_SESSION['error'] = "Tous les champs de mot de passe sont obligatoires.";
                header('Location: index.php?page=utilisateur_edit');
                exit;
            }

            if ($new_password !== $confirm_password) {
                $_SESSION['error'] = "Les nouveaux mots de passe ne correspondent pas.";
                header('Location: index.php?page=utilisateur_edit');
                exit;
            }

            if (strlen($new_password) < 6) {
                $_SESSION['error'] = "Le nouveau mot de passe doit contenir au moins 6 caractères.";
                header('Location: index.php?page=utilisateur_edit');
                exit;
            }

            if (!$this->model->verifiePassword($_SESSION['user_id'], $current_password)) {
                $_SESSION['error'] = "Mot de passe actuel incorrect.";
                header('Location: index.php?page=utilisateur_edit');
                exit;
            }

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
                header('Location: index.php?page=connexion');
                exit;
            }

            if ($this->model->deleteUser($_SESSION['user_id'])) {
                session_destroy();
                header('Location: index.php?page=connexion');
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

    // Gère la connexion de l'utilisateur
    private function connexion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? '';
            if (empty($csrf_token) || !isset($_SESSION['csrf_token']) || $csrf_token !== $_SESSION['csrf_token']) {
                $_SESSION['error'] = "Erreur de validation du formulaire.";
                error_log("CSRF validation failed: Sent=$csrf_token, Expected=" . ($_SESSION['csrf_token'] ?? 'none'));
                header('Location: index.php?page=connexion');
                exit;
            }

            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'] ?? '';

            if (!$email) {
                $_SESSION['error'] = "Adresse email invalide.";
                header('Location: index.php?page=connexion');
                exit;
            }

            if (empty($password)) {
                $_SESSION['error'] = "Le mot de passe est requis.";
                header('Location: index.php?page=connexion');
                exit;
            }

            $user_id = $this->model->login($email, $password);
            if ($user_id) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['message'] = "connexion avec succès.";
                unset($_SESSION['csrf_token']);
                header('Location: index.php?page=connexion');
                exit;
            } else {
                $_SESSION['error'] = "Email ou mot de passe incorrect.";
                error_log("Login failed for email: $email");
                header('Location: index.php?page=connexion');
                exit;
            }
        }
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
         //pour nav menu
            $categories = $this->model->getCategories();
            $data = [
                'categories' => $categories,
            ];

        include BASE_PATH . 'view/user/connexion.php';
    }

    // Gère l'inscription d'un nouvel utilisateur
    private function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? '';
            if (empty($csrf_token) || !isset($_SESSION['csrf_token']) || $csrf_token !== $_SESSION['csrf_token']) {
                $_SESSION['error'] = "Erreur de validation du formulaire.";
                error_log("CSRF validation failed: Sent=$csrf_token, Expected=" . ($_SESSION['csrf_token'] ?? 'none'));
                header('Location: index.php?page=register_user');
                exit;
            }

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

            if (empty($data['username']) || empty($data['email']) || empty($data['password']) || empty($data['password_confirm'])) {
                $_SESSION['error'] = "Tous les champs obligatoires doivent être remplis.";
                header('Location: index.php?page=register_user');
                exit;
            }

            if ($data['password'] !== $data['password_confirm']) {
                $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
                header('Location: index.php?page=register_user');
                exit;
            }

            if (strlen($data['password']) < 6) {
                $_SESSION['error'] = "Le mot de passe doit contenir au moins 6 caractères.";
                header('Location: index.php?page=register_user');
                exit;
            }

            if ($this->model->register($data)) {
                $_SESSION['message'] = "Inscription réussie ! Veuillez vous connecter.";
                unset($_SESSION['csrf_token']);
                header('Location: index.php?page=connexion');
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
                 //pour nav menu
            $categories = $this->model->getCategories();
            $data = [
                'categories' => $categories,
            ];
        include BASE_PATH . 'view/user/register_user.php';
    }

    // Gère la génération du fichier facture PDF
    private function exportFacture() {
        $commande_id = filter_input(INPUT_GET, 'commande_id', FILTER_SANITIZE_NUMBER_INT);
            if (!$commande_id) {
                    $_SESSION['error'] = "Commande ID invalide.";
                    header('Location: index.php?page=commande_user_info');
                    exit;
                }        $order_check = $this->model->getOrderStatus($commande_id, $_SESSION['user_id']);
        if (!$order_check) {
            $_SESSION['error'] = "Commande non trouvée ou accès non autorisé.";
            header('Location: index.php?page=commande_user_info');
            exit;
        }

        $data = $this->model->exportFactureInfo($commande_id);
        if (!$data['order'] || empty($data['order_lines'])) {
            $_SESSION['error'] = "Aucune donnée trouvée pour la commande.";
            header('Location: index.php?page=commande_user_info');
            exit;
        }

        include BASE_PATH . 'view/user/export_facture.php';
    }

    // Déconnecte l'utilisateur
    private function logout() {
        session_destroy();
        header('Location: index.php?page=connexion');
        exit;
    }
}
?>