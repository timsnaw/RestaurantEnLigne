<?php
class CommandeModel {
    private $pdo;

    // Constructeur de la classe
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Recuperer tout les commandes avec filtre
    public function getToutCommandes($search_id = '', $etat_commande = '', $period = 'day', $filter_year = '', $filter_month = '', $filter_day = '') {
    try {
        $query = "
            SELECT 
                commande_id, 
                date_commande, 
                etat_commande, 
                client_id, 
                adresse 
            FROM commande NATURAL JOIN client 
            WHERE 1=1
        ";
        $params = [];

        // Ajout des conditions de filtrage selon les paramètres
        if (!empty($search_id)) {
            $query .= " AND commande_id = ?";
            $params[] = $search_id;
        }

        if (!empty($etat_commande)) {
            $query .= " AND etat_commande = ?";
            $params[] = $etat_commande;
        }

        // Ne pas appliquer le filtre de période si on fait une recherche spécifique
        if (empty($search_id)) {
            // Gestion du filtrage par période
            if (empty($filter_year)) {
                $filter_year = date('Y');
            }
            
            if ($period == 'year') {
                $query .= " AND YEAR(date_commande) = ?";
                $params[] = $filter_year;
            } elseif ($period == 'month') {
                if (empty($filter_month)) {
                    $filter_month = date('m');
                }
                $query .= " AND YEAR(date_commande) = ? AND MONTH(date_commande) = ?";
                $params[] = $filter_year;
                $params[] = $filter_month;
            } elseif ($period == 'day') {
                if (empty($filter_month)) {
                    $filter_month = date('m');
                }
                if (empty($filter_day)) {
                    $filter_day = date('d');
                }
                $query .= " AND YEAR(date_commande) = ? AND MONTH(date_commande) = ? AND DAY(date_commande) = ?";
                $params[] = $filter_year;
                $params[] = $filter_month;
                $params[] = $filter_day;
            }
        }

        // Exécution de la requête
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception("Erreur dans la base de donnees: " . $e->getMessage());
    }
}
    // Recuperer une commande par son ID
    public function getCommandeId($commande_id) {
    try {
        $stmt = $this->pdo->prepare("
            SELECT 
                commande_id, 
                date_commande, 
                etat_commande, 
                client_id, 
                adresse 
            FROM commande NATURAL JOIN client 
            WHERE commande_id = ?
        ");
        $stmt->execute([$commande_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception("Error dans la base de donnees " . $e->getMessage());
    }
}

    // Recuperer les lignes d'une commande
    public function getLigneCommandes($commande_id) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                ligne_id, l.prix, quantite, p.titre,p.plat_id
                FROM ligne_commande l
                LEFT JOIN plat p ON l.plat_id = p.plat_id
                WHERE commande_id = ?
                ORDER BY ligne_id;
            ");
            $stmt->execute([$commande_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error dans la base de donnees " . $e->getMessage());
        }
    }

    // Supprimer une commande et ses lignes
    public function supprimerCommande($commande_id) {
        try {
            // Début de la transaction
            $this->pdo->beginTransaction();

            // Suppression des lignes de commande associées
            $stmt = $this->pdo->prepare("DELETE FROM ligne_commande WHERE commande_id = ?");
            $stmt->execute([$commande_id]);
            $ligne_count = $stmt->rowCount();
            

            // Suppression de la commande elle-même
            $stmt = $this->pdo->prepare("DELETE FROM commande WHERE commande_id = ?");
            $success = $stmt->execute([$commande_id]);
            $commande_count = $stmt->rowCount();
            

            // Validation de la transaction
            $this->pdo->commit();

            return $success;
        } catch (PDOException $e) {
            // Annulation en cas d'erreur
            $this->pdo->rollBack();
            throw new Exception("Erreur lors de la suppression de la commande: " . $e->getMessage());
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    // Modifier l'etat d'une commande
    public function modifierCommandeEtat($commande_id, $etat_commande) {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE commande 
                SET etat_commande = ? 
                WHERE commande_id = ?
            ");
            return $stmt->execute([$etat_commande, $commande_id]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la mise à jour de l'état de la commande: " . $e->getMessage());
        }
    }
}

?>