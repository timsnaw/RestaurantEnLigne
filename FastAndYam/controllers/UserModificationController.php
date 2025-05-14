<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

require_once BASE_PATH . 'config/connexion.php';
require_once BASE_PATH . 'models/UserModificationModel.php';

class UserModificationController {
    private $model;

    public function __construct($pdo) {
        $this->model = new UserModificationModel($pdo);
    }

    // Gere les actions selon la page demandée
    public function gererDemande() {
        $page = $_GET['page'] ?? '';
        switch ($page) {
            case 'user_info':
                $this->afficherClientList();
                break;
            case 'user_details':
                $this->afficherClientDetils();
                break;
            case 'user_edit':
                $this->modifierClient();
                break;
            case 'user_delete':
                $this->supprimerClient();
                break;
            default:
                $_SESSION['error'] = "Page invalide.";
                header("Location: index.php?page=admin");
                exit;
        }
    }

    // Affiche la liste de tous les clients
    private function afficherClientList() {
        $users = $this->model->getToutClient();
        include BASE_PATH . 'view/admin/user_info.php';
    }

    // Affiche les détails d'un client
    private function afficherClientDetils() {
        $client_id = (int)($_GET['client_id'] ?? 0);
        if ($client_id <= 0) {
            $_SESSION['error'] = "Identifiant utilisateur invalide.";
            header("Location: index.php?page=user_info");
            exit;
        }

        $userInfo = $this->model->getClientId($client_id);
        $avis = $userInfo ? $this->model->getClientAvis($client_id) : [];
        if (!$userInfo) {
            $_SESSION['error'] = "Utilisateur introuvable.";
        }
        include BASE_PATH . 'view/admin/user_details.php';
    }

    // Permet de modifier les informations d'un client
    private function modifierClient() {
        $client_id = (int)($_GET['client_id'] ?? 0);
        if ($client_id <= 0) {
            $_SESSION['error'] = "Identifiant utilisateur invalide.";
            header("Location: index.php?page=user_info");
            exit;
        }

        $userInfo = $this->model->getClientId($client_id);
        if (!$userInfo) {
            $_SESSION['error'] = "Utilisateur introuvable.";
            header("Location: index.php?page=user_info");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $prenom = trim($_POST['prenom'] ?? '');
            $nom = trim($_POST['nom'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $telephone = trim($_POST['telephone'] ?? '');
            $adresse = trim($_POST['adresse'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            try {
                if (empty($username) || empty($prenom) || empty($nom) || empty($email) || empty($telephone) || empty($adresse)) {
                    throw new Exception("Tous les champs sont obligatoires.");
                }
                if ($this->model->usernameExiste($username, $client_id)) {
                    throw new Exception("Nom d'utilisateur déjà utilisé.");
                }
                if ($this->model->emailExiste($email, $client_id)) {
                    throw new Exception("Adresse e-mail déjà utilisée.");
                }
                if ($password && $password !== $confirm_password) {
                    throw new Exception("Les mots de passe ne correspondent pas.");
                }

                $this->model->ModifierClient($client_id, $username, $prenom, $nom, $email, $telephone, $adresse, $password ?: null);
                $_SESSION['success'] = "Utilisateur modifié avec succes.";
                header("Location: index.php?page=user_details&client_id=$client_id");
                exit;
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
            }
        }

        include BASE_PATH . 'view/admin/user_edit.php';
    }

    // Supprime un client
    private function supprimerClient() {
        $client_id = $this->validateClientId();
        try {
            if ($this->model->SupprimerClient($client_id)) {
                $_SESSION['success'] = "Client supprimé avec succes.";
            } else {
                $_SESSION['error'] = "Échec de la suppression du client.";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            error_log("Erreur dans supprimerClient : " . $e->getMessage());
        }
        header("Location: index.php?page=user_info");
        exit;
    }

    // Valider l'ID du client
    private function validateClientId() {
        $client_id = isset($_GET['client_id']) ? (int)$_GET['client_id'] : 0;
        if ($client_id <= 0) {
            $_SESSION['error'] = "Identifiant client invalide.";
            header("Location: index.php?page=user_info");
            exit;
        }
        return $client_id;
    }
}
?>
