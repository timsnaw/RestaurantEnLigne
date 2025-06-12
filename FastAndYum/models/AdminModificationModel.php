<?php
class AdminModificationModel {
    private $pdo;

    // Constructeur
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupère tous les administrateurs depuis la base de données
    public function getToutAdmin() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM utilisateur WHERE role = 'admin'");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la base de données: " . $e->getMessage());
        }
    }

    // Récupère les informations d’un administrateur à partir de son ID
    public function getAdminById($user_id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM utilisateur WHERE user_id = ? AND role = 'admin'");
            $stmt->execute([$user_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la base de données: " . $e->getMessage());
        }
    }

    // Modifie les informations d'un administrateur (avec ou sans mot de passe)
    public function modifierAdmin($user_id, $username, $prenom, $nom, $email, $password = null) {
        try {
            if ($password) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $this->pdo->prepare("UPDATE utilisateur SET username = ?, prenom = ?, nom = ?, email = ?, password = ? WHERE user_id = ? AND role = 'admin'");
                return $stmt->execute([$username, $prenom, $nom, $email, $hashedPassword, $user_id]);
            } else {
                $stmt = $this->pdo->prepare("UPDATE utilisateur SET username = ?, prenom = ?, nom = ?, email = ? WHERE user_id = ? AND role = 'admin'");
                return $stmt->execute([$username, $prenom, $nom, $email, $user_id]);
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la base de données: " . $e->getMessage());
        }
    }

    // Supprime un administrateur à partir de son ID
    public function deleteAdmin($user_id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM utilisateur WHERE user_id = ? AND role = 'admin'");
            return $stmt->execute([$user_id]);
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la base de données: " . $e->getMessage());
        }
    }

    // Vérifie si un email existe déjà dans la table 'utilisateur'
    public function emailExiste($email, $exclure_user_id = null) {
        try {
            $query = "SELECT COUNT(*) FROM utilisateur WHERE email = ?";
            if ($exclure_user_id) {
                $query .= " AND user_id != ?";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([$email, $exclure_user_id]);
            } else {
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([$email]);
            }
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la base de données: " . $e->getMessage());
        }
    }

    // Vérifie si un username existe déjà dans la table 'utilisateur'
    public function usernameExiste($username, $exclure_user_id = null) {
        try {
            $query = "SELECT COUNT(*) FROM utilisateur WHERE username = ?";
            if ($exclure_user_id) {
                $query .= " AND user_id != ?";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([$username, $exclure_user_id]);
            } else {
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([$username]);
            }
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la base de données: " . $e->getMessage());
        }
    }
}
?>