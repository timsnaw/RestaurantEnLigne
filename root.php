<?php
session_start();
define('BASE_PATH', __DIR__ . '/');

// base de donnee 
require_once BASE_PATH . 'config/connexion.php';

// root de tout les pages
$page = isset($_GET['page']) ? $_GET['page'] : '';
error_log("index.php processing page: $page");
switch ($page) {
	  case 'admin_login':
        require_once BASE_PATH . 'controllers/AdminController.php';
        $adminController = new AdminController($pdo);
        $adminController->handleAdminLogin();
       break;
       default:
        require('view/admin/adminPage.php');
        break;
}