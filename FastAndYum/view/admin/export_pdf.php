<?php
// Verifie si le chemin de base est defini
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

// Inclusion de la bibliothèque FPDF 
require_once BASE_PATH . 'view/fpdf/fpdf.php'; 

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'FastAndYum - Rapport Statistique', 0, 1, 'C');
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

// Verifier les donnees
if (!isset($data)) {
    header("Location: index.php?page=admin_statistique");
    exit;
}

$stats = $data['stats'];
$dailyRevenue = $data['dailyRevenue'];
$debugDetails = $data['debugDetails'];
$month = $data['month'];
$day = $data['day'];
$hasDataForSelection = $data['hasDataForSelection'];

// Creer PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$title = 'Statistiques ' . ($hasDataForSelection ? 'pour ' . ($month ? $month : 'toutes periodes') . ($day ? ' Jour ' . $day : '') : 'Globales');
$pdf->Cell(0, 10, $title, 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 10);

// Statistiques simples
$pdf->Cell(63, 10, 'Clients', 1, 0, 'C');
$pdf->Cell(64, 10, 'Commandes', 1, 0, 'C');
$pdf->Cell(63, 10, 'Revenu Total', 1, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(63, 10, number_format($stats['total_clients']), 1, 0, 'C');
$pdf->Cell(64, 10, number_format($stats['total_orders']), 1, 0, 'C');
$pdf->Cell(63, 10, number_format($stats['total_revenue'], 2) . ' DH', 1, 1, 'C');

$pdf->Ln(8);

// Details Quotidiens
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Details Quotidiens', 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);

// En-tête du tableau
$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(63, 8, 'Jour', 1, 0, 'C', true);
$pdf->Cell(64, 8, 'Revenu (DH)', 1, 0, 'C', true);
$pdf->Cell(63, 8, 'Commandes', 1, 1, 'C', true);

// Donnees du tableau
foreach ($dailyRevenue as $row) {
    $pdf->Cell(63, 8, date('d F Y', strtotime($row['day'])), 1, 0, 'C');
    $pdf->Cell(64, 8, number_format($row['revenue'], 2), 1, 0, 'C');
    $pdf->Cell(63, 8, $row['orders'], 1, 1, 'C');
}

$pdf->Ln(8);

// Details de Debogage
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Details de Debogage (Commandes)', 0, 1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(35, 8, 'Commande ID', 1, 0, 'C', true);
$pdf->Cell(35, 8, 'User ID', 1, 0, 'C', true);
$pdf->Cell(50, 8, 'Date', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'etat', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Montant', 1, 1, 'C', true);

foreach ($debugDetails as $debugRow) {
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

    $pdf->Cell(35, 8, $debugRow['commande_id'], 1, 0, 'C');
    $pdf->Cell(35, 8, $debugRow['user_id'], 1, 0, 'C');
    $pdf->Cell(50, 8, $debugRow['date_commande'], 1, 0, 'C');
    $pdf->Cell(40, 8, $etat_affiche, 1, 0, 'C');
    $pdf->Cell(30, 8, number_format($debugRow['prix'], 2), 1, 1, 'C');
}

// Output PDF
$pdf->Output();
?>