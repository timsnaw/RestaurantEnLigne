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


    public function getAvis() {
        $stmt = "SELECT a.avis_id, a.commentaire, a.date_avis, a.note, 
                        u.prenom, u.nom, u.image_client
                 FROM avis a
                 JOIN utilisateur u ON a.user_id = u.user_id
                 ORDER BY a.date_avis DESC";
        $result = $this->pdo->query($stmt);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }


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


    public function getPromotedProducts() {
        $stmt = "SELECT p.plat_id, p.categorie_id, p.titre, p.description, p.prix, p.image,
                        pr.promo_id, pr.taux_reduction, pr.date_debut, pr.date_fin
                 FROM plat p
                 JOIN promotion pr ON p.plat_id = pr.plat_id
                 WHERE pr.date_debut <= NOW() AND pr.date_fin >= NOW()";
        $result = $this->pdo->query($stmt);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

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
}
?>