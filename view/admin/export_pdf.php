<?php
require('fpdf/fpdf.php');

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Fast&Yum - Rapport Statistique', 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 8, 'Genere le: ' . date('d/m/Y H:i'), 0, 1, 'C');
        $this->Ln(5);
    }
    
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

// connexion de la data base
$con = new mysqli("localhost", "root", "", "FastAndYam");
if ($con->connect_error) {
    die("Connection error: " . $con->connect_error);
}

// Get annee et jour 
$selectedYear = $_GET['year'] ?? date('Y');
$selectedDay = $_GET['day'] ?? null;

// Simple statistique client, commande et revenue
$statsQuery = "SELECT 
    (SELECT COUNT(*) FROM client) as total_clients,
    (SELECT COUNT(*) FROM commande WHERE YEAR(date_commande) = '$selectedYear'" . 
    ($selectedDay ? " AND DAY(date_commande) = '$selectedDay'" : "") . ") as total_orders,
    (SELECT SUM(l.prix * l.quantite) 
     FROM ligne_commande l
     JOIN commande c ON l.commande_id = c.commande_id
     WHERE YEAR(c.date_commande) = '$selectedYear'" . 
     ($selectedDay ? " AND DAY(c.date_commande) = '$selectedDay'" : "") . ") as total_revenue";

$statsResult = $con->query($statsQuery);
$stats = $statsResult->fetch_assoc();
$stats['total_revenue'] = $stats['total_revenue'] ?? 0;

$dailyRevenueQuery = "
    SELECT DATE_FORMAT(c.date_commande, '%Y-%m-%d') as day, 
           SUM(l.prix * l.quantite) as revenue,
           COUNT(DISTINCT c.commande_id) as orders
    FROM ligne_commande l
    JOIN commande c ON l.commande_id = c.commande_id
    WHERE YEAR(c.date_commande) = '$selectedYear'" . 
    ($selectedDay ? " AND DAY(c.date_commande) = '$selectedDay'" : "") . "
    GROUP BY day
    ORDER BY day";

$dailyRevenue = $con->query($dailyRevenueQuery);
$hasDataForSelection = $dailyRevenue->num_rows > 0;

if (!$hasDataForSelection) {
    // tout les date quantite et revenue
    $dailyRevenueQuery = "
        SELECT DATE_FORMAT(c.date_commande, '%Y-%m-%d') as day, 
               SUM(l.prix * l.quantite) as revenue,
               COUNT(DISTINCT c.commande_id) as orders
        FROM ligne_commande l
        JOIN commande c ON l.commande_id = c.commande_id
        GROUP BY day
        ORDER BY day";
    $dailyRevenue = $con->query($dailyRevenueQuery);
}

$debugQuery = "
    SELECT c.commande_id, c.date_commande, c.etat_commande, l.prix, l.quantite, (l.prix * l.quantite) as line_total
    FROM ligne_commande l
    JOIN commande c ON l.commande_id = c.commande_id
    WHERE YEAR(c.date_commande) = '$selectedYear'" . 
    ($selectedDay ? " AND DAY(c.date_commande) = '$selectedDay'" : "");
$debugResult = $con->query($debugQuery);

// cree PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$title = 'Statistiques ' . ($hasDataForSelection ? 'pour ' . $selectedYear . ($selectedDay ? ' Jour ' . $selectedDay : '') : 'Globales');
$pdf->Cell(0, 10, $title, 0, 1,'C');
$pdf->SetFont('Arial', 'B', 10);

// simple statistique
$pdf->Cell(63, 10, 'Clients', 1, 0, 'C');
$pdf->Cell(64, 10, 'Commandes', 1, 0, 'C');
$pdf->Cell(63, 10, 'Revenu Total', 1, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(63, 10, number_format($stats['total_clients']), 1, 0,'C');
$pdf->Cell(64, 10, number_format($stats['total_orders']), 1, 0,'C');
$pdf->Cell(63, 10, number_format($stats['total_revenue'], 2) . ' DH', 1, 1,'C');

$pdf->Ln(8);

// Details Quotidiens
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Details Quotidiens', 0, 1,'C');
$pdf->SetFont('Arial', '', 10);

// Table header jour revenu commandes
$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(63, 8, 'Jour', 1, 0, 'C', true);
$pdf->Cell(64, 8, 'Revenu (DH)', 1, 0, 'C', true);
$pdf->Cell(63, 8, 'Commandes', 1, 1, 'C', true);

// les information de la table
while ($row = $dailyRevenue->fetch_assoc()) {
    $pdf->Cell(63, 8, date('d F Y', strtotime($row['day'])), 1,0,'C');
    $pdf->Cell(64, 8, number_format($row['revenue'], 2), 1, 0, 'C');
    $pdf->Cell(63, 8, $row['orders'], 1, 1, 'C');
}

// Details de Debogage (Ligne Commande)
$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Details de Debogage (Ligne Commande)', 0, 1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 8, 'Commande ID', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'Date', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'etat', 1, 0, 'C', true);
$pdf->Cell(20, 8, 'Prix', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Quantite', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'Total Ligne', 1, 1, 'C', true);

while ($debugRow = $debugResult->fetch_assoc()) {
    $etat = $debugRow['etat_commande'];

    switch ($etat) {
        case '1':
            $etat_affiche = 'En cours';
            break;
        case '2':
            $etat_affiche = 'En livraison';
            break;
        case '3':
            $etat_affiche = 'Livree';
            break;
        case '4':
            $etat_affiche = 'Annulee';
            break;
        default:
            $etat_affiche = 'Inconnu';
            break;
    }

    $pdf->Cell(30, 8, $debugRow['commande_id'], 1,0,'C');
    $pdf->Cell(40, 8, $debugRow['date_commande'], 1);
    $pdf->Cell(30, 8, $etat_affiche , 1, 0, 'C');
    $pdf->Cell(20, 8, number_format($debugRow['prix'], 2), 1, 0, 'C');
    $pdf->Cell(30, 8, $debugRow['quantite'], 1, 0, 'C');
    $pdf->Cell(40, 8, number_format($debugRow['line_total'], 2), 1, 1, 'C');
}

// Output PDF
$pdf->Output();
?>