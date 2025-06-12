<?php
class PlatModel {
    private $pdo;

    // Constructeur : initialise la connexion à la base de données avec gestion des erreurs
    public function __construct($pdo) {
        $this->pdo = $pdo;
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

// Ajoute un nouveau plat avec son image principale
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
            $stmt = $this->pdo->prepare("UPDATE plat SET categorie_id = ?, titre = ?, description = ?, prix = ?, image = ? WHERE plat_id = ?");
            $stmt->execute([$categorie_id, $titre, $description, $prix, $image, $plat_id]);
        } else {
            $stmt = $this->pdo->prepare("UPDATE plat SET categorie_id = ?, titre = ?, description = ?, prix = ? WHERE plat_id = ?");
            $stmt->execute([$categorie_id, $titre, $description, $prix, $plat_id]);
        }
    } catch (PDOException $e) {
        throw new Exception("Erreur base de données : " . $e->getMessage());
    }
}

// Récupère les images secondaires associées à un plat
public function getSecondairesImages($plat_id) {
    try {
        $stmt = $this->pdo->prepare("SELECT image_id, image_plat FROM images WHERE plat_id = ?");
        $stmt->execute([$plat_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception("Erreur lors de la récupération des images secondaires : " . $e->getMessage());
    }
}

// Ajoute une image secondaire à un plat
public function ajouterImageSecondaire($plat_id, $image_name) {
    try {
        $stmt = $this->pdo->prepare("INSERT INTO images (plat_id, image_plat) VALUES (?, ?)");
        $stmt->execute([$plat_id, $image_name]);
        return $this->pdo->lastInsertId();
    } catch (PDOException $e) {
        throw new Exception("Erreur lors de l'ajout de l'image secondaire : " . $e->getMessage());
    }
}

// Supprime une image secondaire par son ID
public function supprimerImageSecondaire($image_id) {
    try {
        $stmt = $this->pdo->prepare("SELECT image_plat FROM images WHERE image_id = ?");
        $stmt->execute([$image_id]);
        $image = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($image) {
            $stmt = $this->pdo->prepare("DELETE FROM images WHERE image_id = ?");
            $stmt->execute([$image_id]);
            return $image['image_plat']; // Retourne le nom du fichier pour suppression physique
        }
        return false;
    } catch (PDOException $e) {
        throw new Exception("Erreur lors de la suppression de l'image secondaire : " . $e->getMessage());
    }
}

// Supprime un plat de la base de données en fonction de son ID
public function supprimerPlat($plat_id) {
    try {
        $this->pdo->beginTransaction();

        // Récupérer l'image principale
        $stmt = $this->pdo->prepare("SELECT image FROM plat WHERE plat_id = ?");
        $stmt->execute([$plat_id]);
        $plat = $stmt->fetch(PDO::FETCH_ASSOC);

        // Récupérer les images secondaires
        $secondaryImages = $this->getSecondairesImages($plat_id);

        // Supprimer les images secondaires de la base de données
        $stmt = $this->pdo->prepare("DELETE FROM images WHERE plat_id = ?");
        $stmt->execute([$plat_id]);

        // Supprimer le plat
        $stmt = $this->pdo->prepare("DELETE FROM plat WHERE plat_id = ?");
        $stmt->execute([$plat_id]);

        $this->pdo->commit();

        // Retourner les noms des fichiers pour suppression physique
        $images = array_column($secondaryImages, 'image_plat');
        if ($plat && $plat['image']) {
            $images[] = $plat['image'];
        }
        return $images;
    } catch (PDOException $e) {
        $this->pdo->rollBack();
        throw new Exception("Erreur lors de la suppression du plat : " . $e->getMessage());
    }
}
}
?>