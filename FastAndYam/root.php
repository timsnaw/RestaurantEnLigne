<?php
session_start();
define('BASE_PATH', __DIR__ . '/');

// Base de donnees 
require_once BASE_PATH . 'config/connexion.php';

// Root de toutes les pages
$page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : ''; // Secure the page parameter
error_log("index.php traitement de la page: $page");

switch ($page) {
    case 'logout':
        session_unset();
        session_destroy();
        $_SESSION['success'] = "You have been logged out successfully.";
        header("Location: ?page=login");
        exit;
    case 'admin':
        if (!isset($_SESSION['admin_id'])) {
            header("Location: index.php?page=admin_login");
            exit;
        }
        require_once BASE_PATH . 'view/admin/adminPage.php';
        break;

    case 'admin_login':
        require_once BASE_PATH . 'controllers/AdminController.php';
        $adminController = new AdminController($pdo);
        $adminController->adminLogin();
        break;

    case 'register':
        require_once BASE_PATH . 'controllers/AdminController.php';
        $adminController = new AdminController($pdo);
        $adminController->adminRegister();
        break;

    case 'statistique':
        require_once BASE_PATH . 'controllers/AdminController.php';
        $adminController = new AdminController($pdo);
        $adminController->adminStatistique();
        break;
    case 'admin_info':
    case 'admin_details':
    case 'admin_edit':
    case 'admin_delete':
        require_once BASE_PATH . 'controllers/AdminModificationController.php';
        $adminModificationController = new AdminModificationController($pdo);
        $adminModificationController->gererDemande();
    default:
        echo "page home ";;
        break;
}
