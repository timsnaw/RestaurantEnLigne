<?php
class PlatModel {
    private $pdo;

    // Constructeur : initialise la connexion à la base de données avec gestion des erreurs
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Recupere toutes les catégories de plats depuis la base de données
    public function getCategories() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM categorie");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur base de données : " . $e->getMessage());
        }
    }

    // Ajoute un nouveau plat avec ses informations de base 
    public function ajouterPlat($categorie_id, $titre, $description, $prix, $image) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO plat (categorie_id, titre, description, prix, image) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$categorie_id, $titre, $description, $prix, $image]);
            return $this->pdo->lastInsertId(); // Retourne l'ID du nouveau plat
        } catch (PDOException $e) {
            throw new Exception("Erreur base de données : " . $e->getMessage());
        }
    }

    // Modifie un plat existant avec ou sans mise à jour de l'image
    public function modifierPlat($plat_id, $categorie_id, $titre, $description, $prix, $image = null) {
        try {
            if ($image) {
                // Si une image est fournie, on la met à jour
                $stmt = $this->pdo->prepare("UPDATE plat SET categorie_id = ?, titre = ?, description = ?, prix = ?, image = ? WHERE plat_id = ?");
                $stmt->execute([$categorie_id, $titre, $description, $prix, $image, $plat_id]);
            } else {
                // Sinon on met à jour les autres champs uniquement
                $stmt = $this->pdo->prepare("UPDATE plat SET categorie_id = ?, titre = ?, description = ?, prix = ? WHERE plat_id = ?");
                $stmt->execute([$categorie_id, $titre, $description, $prix, $plat_id]);
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur base de données : " . $e->getMessage());
        }
    }

    // Recupere tous les plats avec leur catégorie, ou seulement ceux d'une catégorie spécifique
    public function getPlatsAvecCategories($categorie_id = null) {
        try {
            $sql = "
                SELECT p.plat_id, p.titre, p.description, p.prix, p.image, c.nom_categorie
                FROM plat p
                JOIN categorie c ON p.categorie_id = c.categorie_id
            ";
            if ($categorie_id !== null) {
                // Si une catégorie est précisée, filtre les plats
                $sql .= " WHERE p.categorie_id = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$categorie_id]);
            } else {
                // Sinon Recupere tous les plats
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur base de données : " . $e->getMessage());
        }
    }

    // Recupere les informations d'un plat spécifique via son ID
    public function getPlatId($plat_id) {
        try {
            $query = "SELECT p.*, c.nom_categorie 
                      FROM plat p 
                      LEFT JOIN categorie c ON p.categorie_id = c.categorie_id 
                      WHERE p.plat_id = :plat_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['plat_id' => $plat_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur base de données : " . $e->getMessage());
        }
    }

    // Supprime un plat de la base de données en fonction de son ID
    public function supprimerPlat($plat_id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM plat WHERE plat_id = ?");
            $stmt->execute([$plat_id]);
        } catch (PDOException $e) {
            throw new Exception("Erreur base de données : " . $e->getMessage());
        }
    }
}
?>