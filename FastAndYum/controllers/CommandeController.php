<?php
// Définir le chemin de base du projet
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

// Inclusion des fichiers de configuration et du modèle
require_once BASE_PATH . 'config/connexion.php';
require_once BASE_PATH . 'models/CommandeModel.php';

class CommandeController {
    private $model;

    // Constructeur : initialise le modèle avec la connexion PDO
    public function __construct($pdo) {
        $this->model = new CommandeModel($pdo);
    }

    // Gère les différentes pages selon la valeur de "page" dans l'URL
    public function gererDemande() {
        $page = isset($_GET['page']) ? $_GET['page'] : 'commandes_info';
        switch ($page) {
            case 'commandes_info':
                $this->afficherCommandesList(); // Afficher la liste des commandes
                break;
            case 'commandes_details':
                $this->afficherCommandesDetails(); // Afficher les détails d'une commande
                break;
            case 'commandes_delete':
                $this->supprimerCommandes(); // Supprimer une commande
                break;
            case 'commandes_etat':
                $this->modifierEtat(); // Modifier l'état d'une commande
                break;
            default:
                header("Location: index.php?page=commandes_info");
                exit;
        }
    }

    // Affiche la liste des commandes avec filtres
    private function afficherCommandesList() {
        $search_id = isset($_GET['search_commande_id']) ? $_GET['search_commande_id'] : '';
        $etat_commande = isset($_GET['etat_commande']) ? $_GET['etat_commande'] : '';
        $period = isset($_GET['period']) ? $_GET['period'] : 'day';

        // Si recherche par ID, pas de filtre par date
        if (!empty($search_id)) {
            $filter_year = '';
            $filter_month = '';
            $filter_day = '';
        } else {
            $filter_year = isset($_GET['filter_year']) ? $_GET['filter_year'] : date('Y');
            $filter_month = isset($_GET['filter_month']) ? $_GET['filter_month'] : ($period == 'day' || $period == 'month' ? date('m') : '');
            $filter_day = isset($_GET['filter_day']) ? $_GET['filter_day'] : ($period == 'day' ? date('d') : '');
        }

        // Récupère les commandes filtrées
        $commandes = $this->model->getToutCommandes($search_id, $etat_commande, $period, $filter_year, $filter_month, $filter_day);

        // Ajout des informations de paiement et état sous forme lisible
        foreach ($commandes as &$commande) {
            $payment_details = $this->model->getPaymentStatus($commande['commande_id']);
            $commande['paiement_status'] = $payment_details['statut'];
            $etat_labels = $this->model->getEtatLabels();
            $commande['etat_label'] = isset($etat_labels[$commande['etat_commande']]) ? $etat_labels[$commande['etat_commande']] : 'Inconnu';
        }
        unset($commande);

        // Inclure la vue d'affichage
        include BASE_PATH . 'view/admin/commandes_info.php';
    }

    // Affiche les détails d'une commande spécifique
    private function afficherCommandesDetails() {
        $commande_id = isset($_GET['commande_id']) ? (int)$_GET['commande_id'] : 0;
        $commandeInfo = $commande_id > 0 ? $this->model->getCommandeId($commande_id) : false;
        $lignes = $commande_id > 0 ? $this->model->getLigneCommandes($commande_id) : [];
        $etat_labels = $this->model->getEtatLabels();

        // Si commande trouvée, ajouter les infos supplémentaires
        if ($commandeInfo) {
            $payment_details = $this->model->getPaymentStatus($commande_id);
            $commandeInfo['paiement_status'] = $payment_details['statut'];
            $commandeInfo['mode_paiement'] = $payment_details['mode_paiement'];
            $commandeInfo['date_paiement'] = $payment_details['date_paiement'];
            $commandeInfo['etat_label'] = isset($etat_labels[$commandeInfo['etat_commande']]) ? $etat_labels[$commandeInfo['etat_commande']] : 'Inconnu';
        }

        // Vérifie l'existence du fichier vue
        $file_path = BASE_PATH . 'view/admin/commandes_details.php';
        if (!file_exists($file_path)) {
            die("Erreur : Le fichier '$file_path' n'existe pas.");
        }

        // Inclure la vue
        include $file_path;
    }

    // Supprime une commande à partir de son ID
    private function supprimerCommandes() {
        $commande_id = isset($_GET['commande_id']) ? (int)$_GET['commande_id'] : 0;
        if ($commande_id > 0) {
            $this->model->supprimerCommande($commande_id);
        }
        // Redirige vers la liste après suppression
        header("Location: index.php?page=commandes_info");
        exit;
    }

    // Modifie l'état d'une commande (ex: en cours, livré, annulé, etc.)
    private function modifierEtat() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $commande_id = isset($_POST['commande_id']) ? (int)$_POST['commande_id'] : 0;
            $etat_commande = isset($_POST['etat_commande']) ? (int)$_POST['etat_commande'] : 0;
            if ($commande_id > 0 && in_array($etat_commande, [1, 2, 3, 4])) {
                $this->model->modifierCommandeEtat($commande_id, $etat_commande);
            }
        }
        // Redirige vers la page de détails après modification
        header("Location: index.php?page=commandes_details&commande_id=$commande_id");
        exit;
    }
}
?>
