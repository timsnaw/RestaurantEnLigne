<?php
class UserModificationModel {
    private $pdo;

    // Initialise la connexion PDO
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Recupere tous les clients depuis la base de données
    public function getToutClient() {
        $stmt = $this->pdo->query("SELECT * FROM client");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Recupere un client spécifique selon son ID
    public function getClientId($client_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM client WHERE client_id = ?");
        $stmt->execute([$client_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Recupere les avis d'un client triés par date décroissante
    public function getClientAvis($client_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM avis WHERE client_id = ? ORDER BY date_avis DESC");
        $stmt->execute([$client_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Modifie les informations d’un client (avec ou sans mot de passe)
    public function ModifierClient($client_id, $username, $prenom, $nom, $email, $telephone, $adresse, $password = null) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Format d'email invalide");
        }
        if ($password && strlen($password) < 6) {
            throw new Exception("Le mot de passe doit contenir au moins 6 caractères");
        }

        $sql = "UPDATE client SET username = ?, prenom = ?, nom = ?, email = ?, telephone = ?, adresse = ?" . ($password ? ", password = ?" : "") . " WHERE client_id = ?";
        $params = [$username, $prenom, $nom, $email, $telephone, $adresse];
        if ($password) {
            $params[] = password_hash($password, PASSWORD_DEFAULT);
        }
        $params[] = $client_id;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    // Verifie si un email existe deja dans la base
    public function emailExiste($email, $exclude_client_id = null) {
        $sql = "SELECT COUNT(*) FROM client WHERE email = ?" . ($exclude_client_id ? " AND client_id != ?" : "");
        $params = [$email];
        if ($exclude_client_id) {
            $params[] = $exclude_client_id;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    // Vérifie si un nom d'utilisateur existe deja
    public function usernameExiste($username, $exclude_client_id = null) {
        $sql = "SELECT COUNT(*) FROM client WHERE username = ?" . ($exclude_client_id ? " AND client_id != ?" : "");
        $params = [$username];
        if ($exclude_client_id) {
            $params[] = $exclude_client_id;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    // Supprime un client s'il n'a pas de commandes associées
    public function SupprimeClient($client_id) {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM commande WHERE client_id = ?");
            $stmt->execute([$client_id]);
            $order_count = $stmt->fetchColumn();

            if ($order_count > 0) {
                throw new Exception("Impossible de supprimer le client : $order_count commande(s) associée(s).");
            }

            $stmt = $this->pdo->prepare("DELETE FROM client WHERE client_id = ?");
            return $stmt->execute([$client_id]);
        } catch (PDOException $e) {
            throw new Exception("Erreur base de données : " . $e->getMessage());
        } catch (Exception $e) {
            throw $e;
        }
    }
}
?>
