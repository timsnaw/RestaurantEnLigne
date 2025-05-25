<?php
class PromotionModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Recuperer toutes les promotions avec le nom du plat
    public function getAllPromotions() {
        try {
            $stmt = $this->pdo->prepare("
                SELECT p.promo_id, p.plat_id, p.taux_reduction, p.date_debut, p.date_fin, pl.titre AS plat_titre
                FROM promotion p
                LEFT JOIN plat pl ON p.plat_id = pl.plat_id
                ORDER BY p.promo_id DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des promotions : " . $e->getMessage());
        }
    }

    // Recuperer une promotion par son ID
    public function getPromotionById($promo_id) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT p.promo_id, p.plat_id, p.taux_reduction, p.date_debut, p.date_fin, pl.titre AS plat_titre
                FROM promotion p
                LEFT JOIN plat pl ON p.plat_id = pl.plat_id
                WHERE p.promo_id = ?
            ");
            $stmt->execute([$promo_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération de la promotion : " . $e->getMessage());
        }
    }

    // Recuperer tous les plats pour le formulaire
    public function getAllPlats() {
        try {
            $stmt = $this->pdo->prepare("SELECT plat_id, titre FROM plat ORDER BY titre");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des plats : " . $e->getMessage());
        }
    }

    // Vérifier si un plat existe
    public function platExists($plat_id) {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM plat WHERE plat_id = ?");
            $stmt->execute([$plat_id]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la verification du plat : " . $e->getMessage());
        }
    }

    // Ajouter une promotion
    public function addPromotion($plat_id, $taux_reduction, $date_debut, $date_fin) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO promotion (plat_id, taux_reduction, date_debut, date_fin)
                VALUES (?, ?, ?, ?)
            ");
            return $stmt->execute([$plat_id, $taux_reduction, $date_debut, $date_fin]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout de la promotion : " . $e->getMessage());
        }
    }

    // Modifier une promotion
    public function updatePromotion($promo_id, $plat_id, $taux_reduction, $date_debut, $date_fin) {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE promotion
                SET plat_id = ?, taux_reduction = ?, date_debut = ?, date_fin = ?
                WHERE promo_id = ?
            ");
            return $stmt->execute([$plat_id, $taux_reduction, $date_debut, $date_fin, $promo_id]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la modification de la promotion : " . $e->getMessage());
        }
    }

    // Supprimer une promotion
    public function deletePromotion($promo_id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM promotion WHERE promo_id = ?");
            return $stmt->execute([$promo_id]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression de la promotion : " . $e->getMessage());
        }
    }

    // Vérifier si une promotion existe déjà pour un plat avec des dates chevauchantes
    public function promotionExists($plat_id, $date_debut, $date_fin, $exclude_promo_id = null) {
        try {
            $query = "
                SELECT COUNT(*) 
                FROM promotion 
                WHERE plat_id = ? 
                AND date_debut <= ? 
                AND date_fin >= ? 
            ";
            $params = [$plat_id, $date_fin, $date_debut];
            if ($exclude_promo_id) {
                $query .= " AND promo_id != ?";
                $params[] = $exclude_promo_id;
            }
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la verification des promotions : " . $e->getMessage());
        }
    }
}
?>