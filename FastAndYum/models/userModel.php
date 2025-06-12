<?php
// Definir le chemin de base
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

// Inclure le fichier de connexion a la base de donnee
require_once BASE_PATH . 'config/connexion.php';

class UserModel {
    private $pdo;

    // Constructeur 
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // recupere toutes les informations d'un utilisateur par son ID
    public function getUserInfo($user_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateur WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // recupere uniquement l'image de l'utilisateur
    public function getCurrentImage($user_id) {
        $stmt = $this->pdo->prepare("SELECT image_client FROM utilisateur WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchColumn() ?: null;
    }

    // Met a jour les informations de l'utilisateur (avec ou sans image)
    public function modifierUserInfo($user_id, $data) {
        $query = "UPDATE utilisateur SET username = ?, prenom = ?, nom = ?, email = ?, telephone = ?, adresse = ?";
        $params = [
            $data['username'],
            $data['prenom'],
            $data['nom'],
            $data['email'],
            $data['telephone'],
            $data['adresse']
        ];

        // Ajoute l'image si elle est fournie
        if ($data['image_client'] !== null) {
            $query .= ", image_client = ?";
            $params[] = $data['image_client'];
        }

        $query .= " WHERE user_id = ?";
        $params[] = $user_id;

        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($params);
    }

    // Met a jour le mot de passe de l'utilisateur 
    public function modifierPassword($user_id, $new_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("UPDATE utilisateur SET password = ? WHERE user_id = ?");
        return $stmt->execute([$hashed_password, $user_id]);
    }

    // Verifie si le mot de passe donne est correct pour l'utilisateur
    public function verifiePassword($user_id, $password) {
        $stmt = $this->pdo->prepare("SELECT password FROM utilisateur WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user && password_verify($password, $user['password']);
    }

    // Supprime un utilisateur et toutes ses commandes associees
    public function deleteUser($user_id) {
        $this->pdo->beginTransaction();
        try {
            // Supprimer les lignes de commande
            $stmt = $this->pdo->prepare("DELETE FROM ligne_commande WHERE commande_id IN (SELECT commande_id FROM commande WHERE user_id = ?)");
            $stmt->execute([$user_id]);

            // Supprimer les commandes
            $stmt = $this->pdo->prepare("DELETE FROM commande WHERE user_id = ?");
            $stmt->execute([$user_id]);

            // Supprimer l'utilisateur
            $stmt = $this->pdo->prepare("DELETE FROM utilisateur WHERE user_id = ?");
            $stmt->execute([$user_id]);

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Error supprimer utilisateur: " . $e->getMessage());
            return false;
        }
    }

    // recupere les commandes passees par un utilisateur avec details
    public function getUserOrders($user_id) {
        $stmt = $this->pdo->prepare(
            "SELECT c.commande_id, c.date_commande, c.etat_commande, lc.ligne_id, lc.quantite, lc.prix, p.titre, p.image
             FROM commande c
             JOIN ligne_commande lc ON c.commande_id = lc.commande_id
             JOIN plat p ON lc.plat_id = p.plat_id
             WHERE c.user_id = ?"
        );
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // recupere l'état d'une commande spécifique pour un utilisateur
    public function getOrderStatus($commande_id, $user_id) {
        $stmt = $this->pdo->prepare("SELECT etat_commande FROM commande WHERE commande_id = ? AND user_id = ?");
        $stmt->execute([$commande_id, $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Annule une commande en mettant son état à 4
    public function cancelOrder($commande_id) {
        $stmt = $this->pdo->prepare("UPDATE commande SET etat_commande = 4 WHERE commande_id = ?");
        return $stmt->execute([$commande_id]);
    }

    // Authentifie un utilisateur avec email et mot de passe
    public function login($email, $password) {
        $stmt = $this->pdo->prepare("SELECT user_id, password ,role FROM utilisateur WHERE email = ? AND role = 'client'");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    // Enregistre un nouvel utilisateur dans la base de données
    public function register($data) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO utilisateur (username, prenom, nom, email, telephone, adresse,image_client, password, role, date_inscription)
             VALUES (?, ?, ?, ?, ?, ?,'user.png', ?, 'client', NOW())"
        );
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
        try {
            return $stmt->execute([
                $data['username'],
                $data['prenom'],
                $data['nom'],
                $data['email'],
                $data['telephone'],
                $data['adresse'],
                $hashed_password
            ]);
        } catch (PDOException $e) {
            echo "error de la base de données: " . $e->getMessage();
            return false;
        }
    }
    // recupere les donnees pour facture 
    public function exportFactureInfo($commande_id) {
        // Fetch order details
        $query = "SELECT c.commande_id, c.date_commande, c.etat_commande, u.user_id, u.prenom, u.nom, u.email, u.telephone, u.adresse
                  FROM commande c
                  JOIN utilisateur u ON c.user_id = u.user_id
                  WHERE c.commande_id = :commande_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':commande_id', $commande_id, PDO::PARAM_INT);
        $stmt->execute();
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        // Fetch order lines
        $query = "SELECT lc.ligne_id, lc.prix, lc.quantite, p.titre, p.description
                  FROM ligne_commande lc
                  JOIN plat p ON lc.plat_id = p.plat_id
                  WHERE lc.commande_id = :commande_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':commande_id', $commande_id, PDO::PARAM_INT);
        $stmt->execute();
        $order_lines = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch payment details
        $query = "SELECT montant, mode_paiement, date_paiement, statut
                  FROM paiement
                  WHERE commande_id = :commande_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':commande_id', $commande_id, PDO::PARAM_INT);
        $stmt->execute();
        $payment = $stmt->fetch(PDO::FETCH_ASSOC);

        // Restaurant details
        $restaurant = [
            'name' => 'FastYndYam',
            'address' => '123 Rue targa, Errachidia, Maroc',
            'phone' => '0535123456',
            'email' => 'FastAndYam@gmail.com'
        ];

        return [
            'order' => $order,
            'order_lines' => $order_lines,
            'payment' => $payment,
            'restaurant' => $restaurant
        ];
    }
        // Get Tout categories
    public function getCategories() {
        $stmt = "SELECT categorie_id, nom_categorie, date_ajout, image_categorie 
                  FROM categorie";
        $result = $this->pdo->query($stmt);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
