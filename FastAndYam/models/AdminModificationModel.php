<?php
class AdminModificationModel {
    private $pdo;
    // Constructeur
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
// Recupere tous les administrateurs depuis la base de données
    public function getToutAdmin() {
        try {
            $stmt = $this->pdo->prepare("SELECT admin_id, username, email, date_inscription FROM admin");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            throw new Exception("Error dans la base de données: " . $e->getMessage());
        }
    }
// Recupere les informations d’un administrateur a partir de son ID    
    public function getAdminById($admin_id) {
        try {
            $stmt = $this->pdo->prepare("SELECT admin_id, username, email, date_inscription FROM admin WHERE admin_id = ?");
            $stmt->execute([$admin_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error dans la base de données : " . $e->getMessage());
        }
    }

// Modifie les informations d'un administrateur (avec ou sans mot de passe)
    public function modifierAdmin($admin_id, $username, $email, $password = null) {
        try {
            if ($password) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $this->pdo->prepare("UPDATE admin SET username = ?, email = ?, password = ? WHERE admin_id = ?");
                return $stmt->execute([$username, $email, $hashedPassword, $admin_id]);
            } else {
                $stmt = $this->pdo->prepare("UPDATE admin SET username = ?, email = ? WHERE admin_id = ?");
                return $stmt->execute([$username, $email, $admin_id]);
            }
        } catch (PDOException $e) {
            throw new Exception("Error dnas la base de données: " . $e->getMessage());
        }
    }

// Supprime un administrateur a partir de son ID
    public function deleteAdmin($admin_id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM admin WHERE admin_id = ?");
            return $stmt->execute([$admin_id]);
        } catch (PDOException $e) {
            throw new Exception("Error dnas la base de données: " . $e->getMessage());
        }
    }

//
    public function emailExiste($email, $exclude_admin_id = null) {
        try {
            $query = "SELECT COUNT(*) FROM admin WHERE email = ?";
            if ($exclude_admin_id) {
                $query .= " AND admin_id != ?";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([$email, $exclude_admin_id]);
            } else {
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([$email]);
            }
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            throw new Exception("Error dnas la base de données: " . $e->getMessage());
        }
    }
    
// Verifie si un email existe déjà dans la table 'admin'
// Option : exclure un ID admin spécifique (utile lors de la modification)
    public function usernameExiste($username, $exclude_admin_id = null) {
        try {
            $query = "SELECT COUNT(*) FROM admin WHERE username = ?";
            if ($exclude_admin_id) {
                $query .= " AND admin_id != ?";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([$username, $exclude_admin_id]);
            } else {
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([$username]);
            }
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            throw new Exception("Error dnas la base de données: " . $e->getMessage());
        }
    }
}
?>