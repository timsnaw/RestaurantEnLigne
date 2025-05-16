<?php
class AdminModel {
    private $pdo;

    // Constructeur
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Permet de vérifier l'existence d'un admin
    public function verifieAdmin($email, $password) {
        try {
            $stmt = $this->pdo->prepare("SELECT admin_id, password FROM admin WHERE email = ?");
            $stmt->execute([$email]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            return ($admin && password_verify($password, $admin['password'])) ? $admin['admin_id'] : false;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Permet de créer un admin 
    public function creerAdmin($username, $email, $password) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("INSERT INTO admin (username, email, password, code) VALUES (?, ?, ?, ?)");
            return $stmt->execute([$username, $email, $hashedPassword, '']);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Permet de vérifier si un email existe 
    public function emailExiste($email) {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM admin WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Permet de vérifier si un username existe
    public function usernameExiste($username) {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM admin WHERE username = ?");
            $stmt->execute([$username]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Permet de voir les statistiques 
    public function getStatistique() {
        try {
            return [
                'nbUsers' => $this->pdo->query("SELECT COUNT(*) FROM client")->fetchColumn(),
                'nbAdmins' => $this->pdo->query("SELECT COUNT(*) FROM admin")->fetchColumn(),
                'nbOrders' => $this->pdo->query("SELECT COUNT(*) FROM commande")->fetchColumn(),
                'nbDishes' => $this->pdo->query("SELECT COUNT(*) FROM plat")->fetchColumn(),
                'nbCategories' => $this->pdo->query("SELECT COUNT(*) FROM categorie")->fetchColumn(),
                'revenue' => number_format($this->pdo->query("
                    SELECT COALESCE(SUM(l.prix * l.quantite), 0)
                    FROM ligne_commande l
                    JOIN commande c ON l.commande_id = c.commande_id
                    WHERE c.etat_commande = 3
                ")->fetchColumn(), 2),
                'dailyOrders' => $this->pdo->query("
                    SELECT COUNT(*) 
                    FROM commande 
                    WHERE etat_commande = 3 
                    AND DATE(date_commande) = CURDATE()
                ")->fetchColumn(),
                'dailyRevenue' => number_format($this->pdo->query("
                    SELECT COALESCE(SUM(l.prix * l.quantite), 0)
                    FROM ligne_commande l
                    JOIN commande c ON l.commande_id = c.commande_id
                    WHERE c.etat_commande = 3 
                    AND DATE(c.date_commande) = CURDATE()
                ")->fetchColumn(), 2)
            ];
        } catch (PDOException $e) {
            return [
                'nbUsers' => 0,
                'nbAdmins' => 0,
                'nbOrders' => 0,
                'nbDishes' => 0,
                'nbCategories' => 0,
                'revenue' => '0.00',
                'dailyOrders' => 0,
                'dailyRevenue' => '0.00'
            ];
        }
    }

    // Permet de vérifier les mois disponibles dans les commandes
    public function getMoisDisponible() {
        try {
            $stmt = $this->pdo->query("
                SELECT DISTINCT DATE_FORMAT(date_commande, '%Y-%m') as month
                FROM commande
                WHERE etat_commande = 3
                ORDER BY month DESC
            ");
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            return [];
        }
    }
}
?>