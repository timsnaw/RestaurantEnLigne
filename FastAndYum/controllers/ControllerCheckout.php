<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

require_once BASE_PATH . 'config/connexion.php';
require_once BASE_PATH . 'models/ModelCheckout.php';

class ControllerCheckout {
    private $pdo;
    private $model;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->model = new ModelCheckout($pdo);
    }

    public function gererDemande($page, $action = null) {
        if (!isset($_SESSION['user_id'])) {
            error_log("User not logged in, redirecting to login");
            header('Location: index.php?page=connexion');
            exit;
        }

        error_log("gererDemande: page=$page, action=" . ($action ?? 'none'));

        switch ($page) {
            case 'checkout':
                if ($action === 'place_order') {
                    $this->handlePlaceOrder();
                } elseif ($action === 'paypal_success') {
                    $this->handlePaypalSuccess();
                } elseif ($action === 'paypal_cancel') {
                    $this->handlePaypalCancel();
                } else {
                    $this->displayCheckout();
                }
                break;
            default:
                error_log("Invalid page: $page, redirecting to home");
                header('Location: index.php?page=home');
                exit;
        }
    }

    private function displayCheckout($successMessage = null) {
        $userId = $_SESSION['user_id'];
        $data = [];

        error_log("Session panier: " . json_encode($_SESSION['panier'] ?? []));

        $panierItems = $this->model->getCartItems($userId);
        $categories = $this->model->getCategories();
        $data = [
            'categories' => $categories,
            'panierItems' => $panierItems
        ];

        if (empty($data['panierItems']) && !$successMessage) {
            error_log("Cart is empty for user $userId");
            $data['error'] = "Votre panier est vide.";
            header('Location: index.php?page=panier&error=' . urlencode("Votre panier est vide."));
            exit;
        }

        $data['total'] = $this->model->calculateTotal($data['panierItems']);
        error_log("Cart total: " . $data['total']);

        try {
            $query = "SELECT adresse FROM utilisateur WHERE user_id = :user_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['user_id' => $userId]);
            $data['adresse'] = $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error fetching address: " . $e->getMessage());
            $data['adresse'] = '';
        }

        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            error_log("Generated CSRF token: " . $_SESSION['csrf_token']);
        }

        if ($successMessage) {
            $data['success'] = $successMessage;
        }

        include BASE_PATH . 'view/checkout.php';
    }

    private function sanitizeString($input) {
        $sanitized = strip_tags($input);
        $sanitized = htmlspecialchars($sanitized, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        return trim($sanitized);
    }

    private function handlePaypalSuccess() {
        $userId = $_SESSION['user_id'];
        $data = [
            'categories' => $this->model->getCategories()
        ];

        if (!isset($_SESSION['pending_order'])) {
            error_log("No pending order found for PayPal success");
            $data['error'] = "Erreur lors du traitement du paiement PayPal.";
            $data['panierItems'] = $this->model->getCartItems($userId);
            $data['total'] = $this->model->calculateTotal($data['panierItems']);
            $data['adresse'] = '';
            include BASE_PATH . 'view/checkout.php';
            return;
        }

        $adresse = $this->sanitizeString($_SESSION['pending_order']['adresse'] ?? '');
        $cartItems = $this->model->getCartItems($userId);
        $total = $this->model->calculateTotal($cartItems);
        $modePaiement = 'paypal';

        $commandeId = $this->model->saveOrder($userId, $adresse, $modePaiement, $total);

        if ($commandeId) {
            error_log("PayPal order saved successfully, commande_id: $commandeId");
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            $_SESSION['panier'] = [];
            unset($_SESSION['pending_order']);
            $successMessage = "Votre commande #$commandeId a été enregistrée avec succès via PayPal.";
            $this->displayCheckout($successMessage);
        } else {
            error_log("Failed to save PayPal order");
            $data['error'] = "Erreur lors de l'enregistrement de la commande. Veuillez contacter le support.";
            $data['panierItems'] = $cartItems;
            $data['total'] = $total;
            $data['adresse'] = $adresse;
            include BASE_PATH . 'view/checkout.php';
        }
    }

    private function handlePaypalCancel() {
        $userId = $_SESSION['user_id'];
        $data = [
            'categories' => $this->model->getCategories()
        ];

        error_log("PayPal payment cancelled by user $userId");
        $data['error'] = "Le paiement PayPal a été annulé.";
        $data['panierItems'] = $this->model->getCartItems($userId);
        $data['total'] = $this->model->calculateTotal($data['panierItems']);
        $data['adresse'] = $_SESSION['pending_order']['adresse'] ?? '';
        include BASE_PATH . 'view/checkout.php';
    }

    private function handlePlaceOrder() {
        error_log("handlePlaceOrder called, method: {$_SERVER['REQUEST_METHOD']}, POST: " . json_encode($_POST));

        $categories = $this->model->getCategories();
        $data = [
            'categories' => $categories
        ];

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            error_log("Invalid request method");
            $data['error'] = "Requête invalide. Veuillez soumettre le formulaire.";
            $data['panierItems'] = $this->model->getCartItems($_SESSION['user_id']);
            $data['total'] = $this->model->calculateTotal($data['panierItems']);
            $data['adresse'] = '';
            include BASE_PATH . 'view/checkout.php';
            return;
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            error_log("CSRF token validation failed. Posted: " . ($_POST['csrf_token'] ?? 'none') . ", Expected: " . ($_SESSION['csrf_token'] ?? 'none'));
            $data['error'] = "Erreur de validation du formulaire (CSRF). Veuillez réessayer.";
            $data['panierItems'] = $this->model->getCartItems($_SESSION['user_id']);
            $data['total'] = $this->model->calculateTotal($data['panierItems']);
            $data['adresse'] = $this->sanitizeString(filter_input(INPUT_POST, 'adresse') ?? '');
            include BASE_PATH . 'view/checkout.php';
            return;
        }

        $userId = $_SESSION['user_id'];
        $adresse = $this->sanitizeString(filter_input(INPUT_POST, 'adresse') ?? '');
        $modePaiement = $this->sanitizeString(filter_input(INPUT_POST, 'mode_paiement') ?? '');

        error_log("Order details - UserID: $userId, Adresse: $adresse, ModePaiement: $modePaiement");

        if (empty($adresse)) {
            error_log("Address is empty");
            $data['error'] = "L'adresse de livraison est requise.";
            $data['panierItems'] = $this->model->getCartItems($userId);
            $data['total'] = $this->model->calculateTotal($data['panierItems']);
            $data['adresse'] = $adresse;
            include BASE_PATH . 'view/checkout.php';
            return;
        }

        if (!in_array($modePaiement, ['paypal', 'especes'])) {
            error_log("Invalid payment method: $modePaiement");
            $data['error'] = "Méthode de paiement invalide.";
            $data['panierItems'] = $this->model->getCartItems($userId);
            $data['total'] = $this->model->calculateTotal($data['panierItems']);
            $data['adresse'] = $adresse;
            include BASE_PATH . 'view/checkout.php';
            return;
        }

        $cartItems = $this->model->getCartItems($userId);
        $total = $this->model->calculateTotal($cartItems);
        error_log("Calculated total for order: $total");

        if ($modePaiement === 'paypal') {
            $_SESSION['pending_order'] = ['adresse' => $adresse];

            $paypal_email = "FastAndYamPaypal.com"; 
            $item_name = "Commande FastAndYum (#$userId)"; 
            $amount = number_format($total, 2, '.', ''); 
            $currency_code = 'MAD'; 

            $paypal_url = "https://www.paypal.com/cgi-bin/webscr?" . http_build_query([
                'cmd' => '_xclick',
                'business' => $paypal_email,
                'item_name' => $item_name,
                'amount' => $amount,
                'currency_code' => $currency_code,
                'return' => 'http://localhost/FastAndYumProject/FastAndYum/index.php?page=checkout&action=paypal_success', 
                'cancel_return' => 'http://localhost/FastAndYumProject/FastAndYum/index.php?page=checkout&action=paypal_cancel' 
            ]);

            error_log("Redirecting to PayPal: $paypal_url");
            header("Location: $paypal_url");
            exit;
        } else {
            $commandeId = $this->model->saveOrder($userId, $adresse, $modePaiement, $total);

            if ($commandeId) {
                error_log("Order saved successfully, commande_id: $commandeId");
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                $_SESSION['panier'] = [];
                $successMessage = "Votre commande #$commandeId a été enregistrée avec succès.";
                $this->displayCheckout($successMessage);
            } else {
                error_log("Failed to save order");
                $data['error'] = "Erreur lors de l'enregistrement de la commande. Veuillez réessayer ou contacter le support.";
                $data['panierItems'] = $cartItems;
                $data['total'] = $total;
                $data['adresse'] = $adresse;
                include BASE_PATH . 'view/checkout.php';
            }
        }
    }
}
?>