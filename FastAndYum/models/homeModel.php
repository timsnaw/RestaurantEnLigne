<?php
class ModelHome {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    // Get Tout categories
    public function getCategories() {
        $stmt = "SELECT categorie_id, nom_categorie, date_ajout, image_categorie 
                  FROM categorie";
        $result = $this->pdo->query($stmt);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get une seul categorie par ID
public function getCategorieParId($id) {
    $stmt = "SELECT categorie_id, nom_categorie, date_ajout, image_categorie 
             FROM categorie
             WHERE categorie_id = :id";
    $query = $this->pdo->prepare($stmt);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

// permet de chercher dans la base de donner pour les plats
public function searchPlats($query) {
        $stmt = "SELECT plat_id, titre
                 FROM plat 
                 WHERE titre LIKE :query 
                 LIMIT 5"; 
        $queryParam = '%' . $query . '%';
        $stmt = $this->pdo->prepare($stmt);
        $stmt->bindParam(':query', $queryParam, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // permet d'obtenir tout les avis
    public function getAvis() {
        $stmt = "SELECT a.avis_id, a.commentaire, a.date_avis, a.note, 
                        u.prenom, u.nom, u.image_client, a.user_id
                 FROM avis a
                 JOIN utilisateur u ON a.user_id = u.user_id
                 ORDER BY a.date_avis DESC";
        $result = $this->pdo->query($stmt);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }


    // permet de obtenir les plat par sont categorie
    public function getPlatParCategorie($categorie_id) {
        $stmt = "SELECT p.plat_id, p.categorie_id, p.titre, p.description, p.prix, p.image,
                        pr.promo_id, pr.taux_reduction, pr.date_debut, pr.date_fin
                 FROM plat p
                 LEFT JOIN promotion pr ON p.plat_id = pr.plat_id 
                    AND pr.date_debut <= NOW() 
                    AND pr.date_fin >= NOW()
                 WHERE p.categorie_id = :categorie_id";
        $query = $this->pdo->prepare($stmt);
        $query->bindParam(':categorie_id', $categorie_id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    //permet de obtenir note  
    public function getNote($plat_id) {
        $stmt = "SELECT AVG(note) as average_rating
                 FROM avis
                 WHERE plat_id = :plat_id";
        $query = $this->pdo->prepare($stmt);
        $query->bindParam(':plat_id', $plat_id, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['average_rating'] ? round($result['average_rating'], 1) : 0;
    }

    // permet de obtrnir les plat avec promotion
    public function getPromotedProducts() {
        $stmt = "SELECT p.plat_id, p.categorie_id, p.titre, p.description, p.prix, p.image,
                        pr.promo_id, pr.taux_reduction, pr.date_debut, pr.date_fin
                 FROM plat p
                 JOIN promotion pr ON p.plat_id = pr.plat_id
                 WHERE pr.date_debut <= NOW() AND pr.date_fin >= NOW()";
        $result = $this->pdo->query($stmt);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    // permet d'ajouter plat par sont id 
    public function getPlatParId($ids) {
        if (empty($ids)) {
            return [];
        }

        $sanitizedIds = array_map('intval', $ids);
        $placeholders = implode(',', $sanitizedIds);

        $stmt = "SELECT p.plat_id, p.categorie_id, p.titre, p.description, p.prix, p.image,
                        GROUP_CONCAT(i.image_plat) as image_plat,
                        pr.promo_id, pr.taux_reduction, pr.date_debut, pr.date_fin
                 FROM plat p
                 LEFT JOIN images i ON p.plat_id = i.plat_id
                 LEFT JOIN promotion pr ON p.plat_id = pr.plat_id 
                    AND pr.date_debut <= NOW() AND pr.date_fin >= NOW()
                 WHERE p.plat_id IN ($placeholders)
                 GROUP BY p.plat_id";
        
        $result = $this->pdo->query($stmt);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    //permet d'obtenir avis par sont id
    public function getAvisParId($plat_id = null) {
            $stmt = "SELECT a.avis_id, a.commentaire, a.date_avis, a.note, 
                            u.prenom, u.nom, u.image_client,a.user_id
                     FROM avis a
                     JOIN utilisateur u ON a.user_id = u.user_id";
            if ($plat_id) {
                $stmt .= " WHERE a.plat_id = :plat_id";
            }
            $stmt .= " ORDER BY a.date_avis DESC";
            
            $query = $this->pdo->prepare($stmt);
            if ($plat_id) {
                $query->bindParam(':plat_id', $plat_id, PDO::PARAM_INT);
            }
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }


    // permet d'ajouter des avis 
    public function addAvis($user_id, $plat_id, $commentaire, $note) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO avis (user_id, plat_id, commentaire, note, date_avis)
                VALUES (:user_id, :plat_id, :commentaire, :note, NOW())
            ");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':plat_id', $plat_id, PDO::PARAM_INT);
            $stmt->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
            $stmt->bindParam(':note', $note, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    //permet de supprimer les avis
    public function deleteAvis($avis_id, $user_id) {
        $stmt = "DELETE FROM avis WHERE avis_id = :avis_id AND user_id = :user_id";
        $query = $this->pdo->prepare($stmt);
        $query->bindParam(':avis_id', $avis_id, PDO::PARAM_INT);
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        return $query->execute();
    }

    //permet de obtenir les information de client
    public function getUserInfo($user_id) {
        $query = $this->pdo->prepare("SELECT prenom, nom, image_client FROM utilisateur WHERE user_id = :user_id");
        $query->execute(['user_id' => $user_id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
   
}
?>