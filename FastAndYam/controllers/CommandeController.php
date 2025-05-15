<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

require_once BASE_PATH . 'config/connexion.php';
require_once BASE_PATH . 'models/CommandeModel.php';

class CommandeController {
    private $model;

    // Constructeur du controleur
    public function __construct($pdo) {
        $this->model = new CommandeModel($pdo);
    }

    // Gère les différentes pages selon la demande
    public function gererDemande() {
        $page = isset($_GET['page']) ? $_GET['page'] : 'commandes_info';
        switch ($page) {
            case 'commandes_info':
                $this->afficherCommandesList();
                break;
            case 'commandes_details':
                $this->afficherCommandesDetails();
                break;
            case 'commandes_delete':
                $this->supprimerCommandes();
                break;
            case 'commandes_etat':
                $this->modifierEtat();
                break;
            default:
                header("Location: index.php?page=commandes_info");
                exit;
        }
    }

    // Affiche la liste des commande
    private function afficherCommandesList() {
    $search_id = isset($_GET['search_commande_id']) ? $_GET['search_commande_id'] : '';
    $etat_commande = isset($_GET['etat_commande']) ? $_GET['etat_commande'] : '';
    $period = isset($_GET['period']) ? $_GET['period'] : 'day';
    
    // Si on fait une recherche par ID, on ignore les filtres de période
    if (!empty($search_id)) {
        $filter_year = '';
        $filter_month = '';
        $filter_day = '';
    } else {
        $filter_year = isset($_GET['filter_year']) ? $_GET['filter_year'] : date('Y');
        $filter_month = isset($_GET['filter_month']) ? $_GET['filter_month'] : ($period == 'day' || $period == 'month' ? date('m') : '');
        $filter_day = isset($_GET['filter_day']) ? $_GET['filter_day'] : ($period == 'day' ? date('d') : '');
    }

    $commandes = $this->model->getToutCommandes($search_id, $etat_commande, $period, $filter_year, $filter_month, $filter_day);
    include BASE_PATH . 'view/admin/commandes_info.php';
}

    // Affiche les details d'une commande
    private function afficherCommandesDetails() {
    $commande_id = isset($_GET['commande_id']) ? (int)$_GET['commande_id'] : 0;
    $commandeInfo = $commande_id > 0 ? $this->model->getCommandeId($commande_id) : false;
    $lignes = $commande_id > 0 ? $this->model->getLigneCommandes($commande_id) : [];
    $file_path = BASE_PATH . 'view/admin/commandes_details.php';
    if (!file_exists($file_path)) {
        die("Erreur : Le fichier '$file_path' n'existe pas.");
    }
    include $file_path;
}

    // Supprime une commande
    private function supprimerCommandes() {
        $commande_id = isset($_GET['commande_id']) ? (int)$_GET['commande_id'] : 0;
        if ($commande_id > 0) {
            $this->model->supprimerCommande($commande_id);
        }
        header("Location: index.php?page=commandes_info");
        exit;
    }

    // Modifie l'etat d'une commande
    private function modifierEtat() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $commande_id = isset($_POST['commande_id']) ? (int)$_POST['commande_id'] : 0;
            $etat_commande = isset($_POST['etat_commande']) ? (int)$_POST['etat_commande'] : 0;
            if ($commande_id > 0 && in_array($etat_commande, [1, 2, 3, 4])) {
                $this->model->modifierCommandeEtat($commande_id, $etat_commande);
            }
        }
        header("Location: index.php?page=commandes_details&commande_id=$commande_id");
        exit;
    }
}

if (!isset($pdo)) {
    header("Location: index.php?page=admin_login");
    exit;
}
?>
