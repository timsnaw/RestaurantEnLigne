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
            $stmt = $this->pdo->prepare("SELECT user_id, password FROM utilisateur WHERE email = ? AND role = 'admin'");
            $stmt->execute([$email]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            return ($admin && password_verify($password, $admin['password'])) ? $admin['user_id'] : false;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Permet de créer un admin 
    public function creerAdmin($username, $email, $password, $prenom = '', $nom = '') {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("INSERT INTO utilisateur (username, prenom, nom, email, password, role) VALUES (?, ?, ?, ?, ?, 'admin')");
            return $stmt->execute([$username, $prenom, $nom, $email, $hashedPassword]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Permet de vérifier si un email existe 
    public function emailExiste($email) {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM utilisateur WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Permet de vérifier si un username existe
    public function usernameExiste($username) {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM utilisateur WHERE username = ?");
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
                'nbUsers' => $this->pdo->query("SELECT COUNT(*) FROM utilisateur WHERE role = 'client'")->fetchColumn(),
                'nbAdmins' => $this->pdo->query("SELECT COUNT(*) FROM utilisateur WHERE role = 'admin'")->fetchColumn(),
                'nbOrders' => $this->pdo->query("SELECT COUNT(*) FROM commande")->fetchColumn(),
                'nbDishes' => $this->pdo->query("SELECT COUNT(*) FROM plat")->fetchColumn(),
                'nbCategories' => $this->pdo->query("SELECT COUNT(*) FROM categorie")->fetchColumn(),
                'revenue' => number_format($this->pdo->query("
                    SELECT COALESCE(SUM(p.montant), 0)
                    FROM paiement p
                    JOIN commande c ON p.commande_id = c.commande_id
                    WHERE c.etat_commande = 3
                ")->fetchColumn(), 2),
                'dailyOrders' => $this->pdo->query("
                    SELECT COUNT(*) 
                    FROM commande 
                    WHERE etat_commande = 3 
                    AND DATE(date_commande) = CURDATE()
                ")->fetchColumn(),
                'dailyRevenue' => number_format($this->pdo->query("
                    SELECT COALESCE(SUM(p.montant), 0)
                    FROM paiement p
                    JOIN commande c ON p.commande_id = c.commande_id
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

    // Permet de vérifier les mois disponibles dans les commande
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

    // Récupère les statistiques pour le PDF (clients, commande, revenu)
    public function getPDFStats($month = null, $day = null) {
        try {
            $query = "SELECT 
                (SELECT COUNT(*) FROM utilisateur WHERE role = 'client') as total_clients,
                (SELECT COUNT(*) FROM commande WHERE etat_commande = 3" . 
                ($month ? " AND DATE_FORMAT(date_commande, '%Y-%m') = ?" : "") . 
                ($day ? " AND DAY(date_commande) = ?" : "") . ") as total_orders,
                (SELECT COALESCE(SUM(p.montant), 0)
                 FROM paiement p
                 JOIN commande c ON p.commande_id = c.commande_id
                 WHERE c.etat_commande = 3" . 
                 ($month ? " AND DATE_FORMAT(c.date_commande, '%Y-%m') = ?" : "") . 
                 ($day ? " AND DAY(c.date_commande) = ?" : "") . ") as total_revenue";
            
            $params = [];
            if ($month) $params[] = $month;
            if ($day) $params[] = $day;
            if ($month) $params[] = $month;
            if ($day) $params[] = $day;

            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            $stats = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['total_revenue'] = $stats['total_revenue'] ?? 0;
            return $stats;
        } catch (PDOException $e) {
            return [
                'total_clients' => 0,
                'total_orders' => 0,
                'total_revenue' => 0
            ];
        }
    }

    // Récupère les revenus quotidiens et commande
    public function getDailyRevenue($month = null, $day = null) {
        try {
            $query = "
                SELECT DATE_FORMAT(c.date_commande, '%Y-%m-%d') as day, 
                       COALESCE(SUM(p.montant), 0) as revenue,
                       COUNT(DISTINCT c.commande_id) as orders
                FROM paiement p
                JOIN commande c ON p.commande_id = c.commande_id
                WHERE c.etat_commande = 3" . 
                ($month ? " AND DATE_FORMAT(c.date_commande, '%Y-%m') = ?" : "") . 
                ($day ? " AND DAY(c.date_commande) = ?" : "") . "
                GROUP BY day
                ORDER BY day";
            
            $params = [];
            if ($month) $params[] = $month;
            if ($day) $params[] = $day;

            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($results) && !$month && !$day) {
                $query = "
                    SELECT DATE_FORMAT(c.date_commande, '%Y-%m-%d') as day, 
                           COALESCE(SUM(p.montant), 0) as revenue,
                           COUNT(DISTINCT c.commande_id) as orders
                    FROM paiement p
                    JOIN commande c ON p.commande_id = c.commande_id
                    WHERE c.etat_commande = 3
                    GROUP BY day
                    ORDER BY day";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            return $results;
        } catch (PDOException $e) {
            return [];
        }
    }

    // Récupère les détails de débogage pour les lignes de commande
    public function getDebugDetails($month = null, $day = null) {
        try {
            $query = "
                SELECT c.commande_id, c.user_id, c.date_commande, c.etat_commande, p.montant as prix, 1 as quantite, p.montant as line_total
                FROM paiement p
                JOIN commande c ON p.commande_id = c.commande_id
                WHERE c.etat_commande = 3" . 
                ($month ? " AND DATE_FORMAT(c.date_commande, '%Y-%m') = ?" : "") . 
                ($day ? " AND DAY(c.date_commande) = ?" : "");
            
            $params = [];
            if ($month) $params[] = $month;
            if ($day) $params[] = $day;

            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
?>