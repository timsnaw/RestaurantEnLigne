<?php
session_start();
define('BASE_PATH', __DIR__ . '/');

//  configuration de la base de donnees 
require_once BASE_PATH . 'config/connexion.php';

// Root de toutes les pages
$page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : '';
error_log("index.php traitement de la page: $page");

switch ($page) {
    case 'logout':
        session_unset();
        session_destroy();
        $_SESSION['success'] = "You have been logged out successfully.";
        header("Location: index.php?page=admin_login");
        break;
    case 'admin':
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=admin_login");
            exit;
        }
        require_once BASE_PATH . 'view/admin/adminPage.php';
        break;

    case 'admin_login':
    case 'register':
    case 'export_pdf':
    case 'statistique':
        require_once BASE_PATH . 'controllers/AdminController.php';
        $adminController = new AdminController($pdo);
        $adminController->gereDemande();
        break;
    case 'admin_info':
    case 'admin_details':
    case 'admin_edit':
    case 'admin_delete':
        require_once BASE_PATH . 'controllers/AdminModificationController.php';
        $adminModificationController = new AdminModificationController($pdo);
        $adminModificationController->gererDemande();
        break;
    case 'user_info':
    case 'user_details':
    case 'user_edit':
    case 'user_delete':
        require_once BASE_PATH . 'controllers/UserModificationController.php';
        $userModificationController = new UserModificationController($pdo);
        $userModificationController->gererDemande();
        break;
    case 'categorie_details':
    case 'categorie_edit':
    case 'categorie_info':
    case 'categorie_add':
    case 'categorie_delete':
        require_once BASE_PATH . 'controllers/CategorieController.php';
        $categorieController = new CategorieController($pdo);
        $categorieController->gererDemande();
        break;
    case 'plats':
    case 'plat_info':
    case 'plat_edit':
    case 'plat_add':
    case 'plat_delete':
        require_once BASE_PATH . 'controllers/PlatController.php';
        $platController = new PlatController($pdo);
        $platController->gererDemande();
        break;
    case 'commandes_info':
    case 'commandes_details':
    case 'commandes_delete':
    case 'commandes_etat':
        require_once BASE_PATH . 'controllers/CommandeController.php';
        $categorieController = new CommandeController($pdo);
        $categorieController->gererDemande();
    break;
    case 'promotion_info':
    case 'promotion_add':
    case 'promotion_edit':
    case 'promotion_delete':
        require_once BASE_PATH . 'controllers/PromotionController.php';
        $controller = new PromotionController($pdo);
        $controller->gererDemande();
    break;
    default:
        echo "page home ";;
        break;
}
