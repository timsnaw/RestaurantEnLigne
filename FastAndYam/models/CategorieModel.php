<?php
class CategorieModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Recupere toutes les catégories de la base de données
    public function getToutCategories() {
        try {
            $stmt = $this->pdo->query("SELECT categorie_id, nom_categorie, date_ajout, image_categorie FROM categorie");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des catégories : " . $e->getMessage());
        }
    }

    // Recupere les informations d'une catégorie spécifique par son ID
    public function getCategorieId($categorie_id) {
        try {
            $stmt = $this->pdo->prepare("SELECT categorie_id, nom_categorie, date_ajout, image_categorie FROM categorie WHERE categorie_id = ?");
            $stmt->execute([$categorie_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération de la catégorie : " . $e->getMessage());
        }
    }

    // Recupere les plats appartenant à une catégorie donnée
    public function getPlatsParCategorie($categorie_id) {
        try {
            $stmt = $this->pdo->prepare("SELECT plat_id, titre, description, prix, image FROM plat WHERE categorie_id = ? ORDER BY titre");
            $stmt->execute([$categorie_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des plats de la catégorie : " . $e->getMessage());
        }
    }

    // Met à jour les informations d'une catégorie
    public function modifierCategorie($categorie_id, $nom_categorie, $image_categorie) {
        try {
            $stmt = $this->pdo->prepare("UPDATE categorie SET nom_categorie = ?, image_categorie = ? WHERE categorie_id = ?");
            return $stmt->execute([$nom_categorie, $image_categorie, $categorie_id]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la modification de la catégorie : " . $e->getMessage());
        }
    }

    // Ajoute une nouvelle catégorie à la base de données
    public function ajouterCategorie($nom_categorie, $image_categorie) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO categorie (nom_categorie, image_categorie, date_ajout) VALUES (?, ?, NOW())");
            return $stmt->execute([$nom_categorie, $image_categorie]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout de la catégorie : " . $e->getMessage());
        }
    }

    // Supprime une categorie par son ID et tous les plats associés
    public function supprimeCategorie($categorie_id) {
        try {
            $this->pdo->beginTransaction();

            $stmtPlats = $this->pdo->prepare("DELETE FROM plat WHERE categorie_id = ?");
            $stmtPlats->execute([$categorie_id]);

            // Supprimer la catégorie
            $stmtCategorie = $this->pdo->prepare("DELETE FROM categorie WHERE categorie_id = ?");
            $result = $stmtCategorie->execute([$categorie_id]);

            // Valider la transaction
            $this->pdo->commit();

            return $result;
        } catch (PDOException $e) {
            // Annuler la transaction en cas d'erreur
            $this->pdo->rollBack();
            throw new Exception("Erreur lors de la suppression de la catégorie ou des plats associés : " . $e->getMessage());
        }
    }

    // Vérifie si un nom de catégorie existe déjà (avec possibilité d’exclusion d’un ID pour les modifications)
    public function nameExiste($nom_categorie, $exclude_categorie_id = null) {
        try {
            $query = "SELECT COUNT(*) FROM categorie WHERE nom_categorie = ?";
            if ($exclude_categorie_id) {
                $query .= " AND categorie_id != ?";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([$nom_categorie, $exclude_categorie_id]);
            } else {
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([$nom_categorie]);
            }
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la vérification du nom de la catégorie : " . $e->getMessage());
        }
    }
}
?>
