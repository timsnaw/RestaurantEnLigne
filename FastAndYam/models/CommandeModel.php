<?php
class CommandeModel {
    private $pdo;

    // État labels as a constant
    private const ETAT_LABELS = [
        1 => 'En cours',
        2 => 'En livraison',
        3 => 'Livrée',
        4 => 'Annulée'
    ];

    // Constructeur de la classe
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Get état labels
    public function getEtatLabels() {
        return self::ETAT_LABELS;
    }

    // Get payment details for a commande
    public function getPaymentStatus($commande_id) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT statut, mode_paiement, date_paiement 
                FROM paiement 
                WHERE commande_id = ?
            ");
            $stmt->execute([$commande_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return [
                    'statut' => $result['statut'] == 1 ? 'Payé' : 'Non payé',
                    'mode_paiement' => $result['mode_paiement'] == 1 ? 'Carte' : 'Cash',
                    'date_paiement' => $result['date_paiement'] ? $result['date_paiement'] : 'N/A'
                ];
            }
            return [
                'statut' => 'Non payé',
                'mode_paiement' => 'N/A',
                'date_paiement' => 'N/A'
            ];
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la base de données: " . $e->getMessage());
        }
    }

    // Récupérer toutes les commandes avec filtre
    public function getToutCommandes($search_id = '', $etat_commande = '', $period = 'day', $filter_year = '', $filter_month = '', $filter_day = '') {
        try {
            $query = "
                SELECT 
                    commande_id, 
                    date_commande, 
                    etat_commande, 
                    user_id, 
                    adresse 
                FROM commande NATURAL JOIN utilisateur 
                WHERE 1=1
            ";
            $params = [];

            if (!empty($search_id)) {
                $query .= " AND commande_id = ?";
                $params[] = $search_id;
            }

            if (!empty($etat_commande)) {
                $query .= " AND etat_commande = ?";
                $params[] = $etat_commande;
            }

            if (empty($search_id)) {
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

            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la base de données: " . $e->getMessage());
        }
    }

    // Récupérer une commande par son ID
    public function getCommandeId($commande_id) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    commande_id, 
                    date_commande, 
                    etat_commande, 
                    user_id, 
                    adresse 
                FROM commande NATURAL JOIN utilisateur 
                WHERE commande_id = ?
            ");
            $stmt->execute([$commande_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la base de données: " . $e->getMessage());
        }
    }

    // Récupérer les lignes d'une commande
    public function getLigneCommandes($commande_id) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    ligne_id, l.prix, quantite, p.titre, p.plat_id
                FROM ligne_commande l
                LEFT JOIN plat p ON l.plat_id = p.plat_id
                WHERE commande_id = ?
                ORDER BY ligne_id
            ");
            $stmt->execute([$commande_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la base de données: " . $e->getMessage());
        }
    }

    // Supprimer une commande et ses lignes
    public function supprimerCommande($commande_id) {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare("DELETE FROM ligne_commande WHERE commande_id = ?");
            $stmt->execute([$commande_id]);
            $stmt = $this->pdo->prepare("DELETE FROM commande WHERE commande_id = ?");
            $success = $stmt->execute([$commande_id]);
            $this->pdo->commit();
            return $success;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw new Exception("Erreur lors de la suppression de la commande: " . $e->getMessage());
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    // Modifier l'état d'une commande
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