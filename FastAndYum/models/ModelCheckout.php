<?php
class ModelCheckout {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getCartItems($userId) {
        try {
            if (empty($_SESSION['panier'])) {
                error_log("Cart is empty in getCartItems for user $userId");
                return [];
            }

            $platIds = array_keys($_SESSION['panier']);
            if (empty($platIds)) {
                error_log("No plat IDs in cart for user $userId");
                return [];
            }

            $query = "
                SELECT plat_id, titre, description, prix, image
                FROM plat
                WHERE plat_id IN (" . implode(',', array_fill(0, count($platIds), '?')) . ")
            ";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($platIds);

            $items = [];
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $product) {
                $items[] = [
                    'plat_id' => $product['plat_id'],
                    'titre' => $product['titre'],
                    'description' => $product['description'],
                    'prix' => $this->getPriceWithPromotion($product['plat_id'], $product['prix']),
                    'image' => $product['image'],
                    'quantite' => $_SESSION['panier'][$product['plat_id']]
                ];
            }
            error_log("Cart items retrieved: " . json_encode($items));
            return $items;
        } catch (PDOException $e) {
            error_log("Error fetching cart items: " . $e->getMessage());
            return [];
        }
    }

    public function calculateTotal($cartItems) {
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['prix'] * $item['quantite'];
        }
        return $total;
    }

    private function getPriceWithPromotion($platId, $originalPrice) {
        try {
            $query = "
                SELECT taux_reduction
                FROM promotion
                WHERE plat_id = :plat_id
                AND date_debut <= CURDATE()
                AND date_fin >= CURDATE()
            ";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['plat_id' => $platId]);
            $promotion = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($promotion) {
                $discount = $promotion['taux_reduction'] / 100;
                return $originalPrice * (1 - $discount);
            }
            return $originalPrice;
        } catch (PDOException $e) {
            error_log("Error checking promotion: " . $e->getMessage());
            return $originalPrice;
        }
    }

    public function saveOrder($userId, $adresse, $modePaiement, $total) {
        try {
            $this->pdo->beginTransaction();
            error_log("Starting saveOrder: user=$userId, total=$total, mode=$modePaiement");

            $query = "INSERT INTO commande (user_id, date_commande, etat_commande) VALUES (:user_id, NOW(), 1)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['user_id' => $userId]);
            $commandeId = $this->pdo->lastInsertId();
            error_log("Commande inserted, ID: $commandeId");

            $cartItems = $this->getCartItems($userId);
            if (empty($cartItems)) {
                error_log("No cart items to save for user $userId");
                $this->pdo->rollBack();
                return false;
            }

            foreach ($cartItems as $item) {
                $query = "INSERT INTO ligne_commande (prix, quantite, commande_id, plat_id) VALUES (:prix, :quantite, :commande_id, :plat_id)";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([
                    'prix' => $item['prix'],
                    'quantite' => $item['quantite'],
                    'commande_id' => $commandeId,
                    'plat_id' => $item['plat_id']
                ]);
                error_log("Ligne_commande inserted for plat_id: {$item['plat_id']}");
            }

            $modePaiementInt = ($modePaiement === 'paypal') ? 1 : 0;
            $statut = ($modePaiement === 'paypal') ? 1 : 0;
            $query = "INSERT INTO paiement (commande_id, montant, mode_paiement, date_paiement, statut, user_id) VALUES (:commande_id, :montant, :mode_paiement, NOW(), :statut, :user_id)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                'commande_id' => $commandeId,
                'montant' => $total,
                'mode_paiement' => $modePaiementInt,
                'statut' => $statut,
                'user_id' => $userId
            ]);
            error_log("Paiement inserted for commande_id: $commandeId");

            $query = "UPDATE utilisateur SET adresse = :adresse WHERE user_id = :user_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['adresse' => $adresse, 'user_id' => $userId]);
            error_log("Address updated for user $userId");

            $_SESSION['panier'] = [];
            error_log("Cart cleared for user $userId");

            $this->pdo->commit();
            return $commandeId;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Error saving order: " . $e->getMessage() . " (Code: " . $e->getCode() . ")");
            return false;
        }
    }

    public function getCategories() {
        $stmt = "SELECT categorie_id, nom_categorie, date_ajout, image_categorie 
                  FROM categorie";
        $result = $this->pdo->query($stmt);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>