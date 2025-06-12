<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

require_once BASE_PATH . 'config/connexion.php';
require_once BASE_PATH . 'models/PromotionModel.php';

class PromotionController {
    private $model;

    public function __construct($pdo) {
        $this->model = new PromotionModel($pdo);
    }

    public function gererDemande() {
        if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?page=admin_login");
            exit;
        }
        
        $page = isset($_GET['page']) ? $_GET['page'] : 'promotion_info';
        switch ($page) {
            case 'promotion_info':
                $this->afficherPromotionList();
                break;
            case 'promotion_add':
                $this->ajouterPromotion();
                break;
            case 'promotion_edit':
                $this->modifierPromotion();
                break;
            case 'promotion_delete':
                $this->supprimerPromotion();
                break;
            default:
                header("Location: index.php?page=promotion_info");
                exit;
        }
    }

    // Affiche la liste des promotions
    private function afficherPromotionList() {
        $promotions = $this->model->getAllPromotions();
        include BASE_PATH . 'view/admin/promotion_info.php';
    }

    // Ajouter une nouvelle promotion
    private function ajouterPromotion() {
        $plats = $this->model->getAllPlats();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            $plat_id = filter_input(INPUT_POST, 'plat_id', FILTER_VALIDATE_INT);
            $taux_reduction = filter_input(INPUT_POST, 'taux_reduction', FILTER_VALIDATE_FLOAT);
            $date_debut = trim($_POST['date_debut'] ?? '');
            $date_fin = trim($_POST['date_fin'] ?? '');

            // Validation des champs
            if (!$plat_id || !$this->model->platExists($plat_id)) {
                $errors[] = "Plat invalide.";
            }
            if ($taux_reduction === false || $taux_reduction <= 0 || $taux_reduction > 100) {
                $errors[] = "Taux de réduction invalide (doit être entre 0 et 100).";
            }
            if (empty($date_debut) || !DateTime::createFromFormat('Y-m-d', $date_debut)) {
                $errors[] = "Date de début invalide.";
            }
            if (empty($date_fin) || !DateTime::createFromFormat('Y-m-d', $date_fin)) {
                $errors[] = "Date de fin invalide.";
            }
            if ($date_debut && $date_fin && strtotime($date_debut) >= strtotime($date_fin)) {
                $errors[] = "La date de fin doit être postérieure à la date de début.";
            }
            if ($this->model->promotionExists($plat_id, $date_debut, $date_fin)) {
                $errors[] = "Une promotion existe déjà pour ce plat sur cette période.";
            }

            if (empty($errors)) {
                try {
                    if ($this->model->addPromotion($plat_id, $taux_reduction, $date_debut, $date_fin)) {
                        $_SESSION['success'] = "Promotion ajoutée avec succès.";
                        header("Location: index.php?page=promotion_info");
                        exit;
                    } else {
                        $errors[] = "Erreur lors de l'ajout de la promotion.";
                    }
                } catch (Exception $e) {
                    $errors[] = "Erreur : " . $e->getMessage();
                }
            }

            if (!empty($errors)) {
                $_SESSION['error'] = "Erreurs : " . implode(", ", $errors);
            }
        }

        include BASE_PATH . 'view/admin/promotion_add.php';
    }

    // Modifier une promotion existante
    private function modifierPromotion() {
        $promo_id = isset($_GET['promo_id']) ? (int)$_GET['promo_id'] : 0;
        $promotionInfo = $promo_id > 0 ? $this->model->getPromotionById($promo_id) : false;
        if (!$promotionInfo) {
            $_SESSION['error'] = "Promotion introuvable.";
            header("Location: index.php?page=promotion_info");
            exit;
        }
        $plats = $this->model->getAllPlats();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            $plat_id = filter_input(INPUT_POST, 'plat_id', FILTER_VALIDATE_INT);
            $taux_reduction = filter_input(INPUT_POST, 'taux_reduction', FILTER_VALIDATE_FLOAT);
            $date_debut = trim($_POST['date_debut'] ?? '');
            $date_fin = trim($_POST['date_fin'] ?? '');
            

            // Validation des champs
            if (!$plat_id || !$this->model->platExists($plat_id)) {
                $errors[] = "Plat invalide.";
            }
            if ($taux_reduction === false || $taux_reduction <= 0 || $taux_reduction > 100) {
                $errors[] = "Taux de réduction invalide (doit être entre 0 et 100).";
            }
            if (empty($date_debut) || !DateTime::createFromFormat('Y-m-d', $date_debut)) {
                $errors[] = "Date de début invalide.";
            }
            if (empty($date_fin) || !DateTime::createFromFormat('Y-m-d', $date_fin)) {
                $errors[] = "Date de fin invalide.";
            }
            if ($date_debut && $date_fin && strtotime($date_debut) >= strtotime($date_fin)) {
                $errors[] = "La date de fin doit être postérieure à la date de début.";
            }
            if ($this->model->promotionExists($plat_id, $date_debut, $date_fin, $promo_id)) {
                $errors[] = "Une promotion existe déjà pour ce plat sur cette période.";
            }

            if (empty($errors)) {
                try {
                    if ($this->model->updatePromotion($promo_id, $plat_id, $taux_reduction, $date_debut, $date_fin)) {
                        $_SESSION['success'] = "Promotion modifiée avec succès.";
                        header("Location: index.php?page=promotion_info");
                        exit;
                    } else {
                        $errors[] = "Erreur lors de la modification de la promotion.";
                    }
                } catch (Exception $e) {
                    $errors[] = "Erreur : " . $e->getMessage();
                }
            }

            if (!empty($errors)) {
                $_SESSION['error'] = "Erreurs : " . implode(", ", $errors);
            }
        }

        include BASE_PATH . 'view/admin/promotion_edit.php';
    }

    // Supprime une promotion
    private function supprimerPromotion() {
        $promo_id = isset($_GET['promo_id']) ? (int)$_GET['promo_id'] : 0;
        if ($promo_id > 0) {
            try {
                if ($this->model->deletePromotion($promo_id)) {
                    $_SESSION['success'] = "Promotion supprimée avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de la suppression de la promotion.";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Erreur : " . $e->getMessage();
            }
        } else {
            $_SESSION['error'] = "ID de promotion invalide.";
        }
        header("Location: index.php?page=promotion_info");
        exit;
    }
}
?>