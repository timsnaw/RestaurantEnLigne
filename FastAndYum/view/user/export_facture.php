<?php
// Verifie si le chemin de base est defini
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

// Inclusion de la bibliothèque FPDF 
require_once BASE_PATH . 'view/fpdf/fpdf.php'; 

// Redirige vers la page d'information si les donnees de commande sont absentes
if (!isset($data)) {
    header("Location: index.php?page=commande_user_info");
    exit;
}

$order = $data['order'];
$order_lines = $data['order_lines'];
$payment = $data['payment'];
$restaurant = $data['restaurant'];

// Creation d'une classe PDF personnalise pour l'en-tete et le pied de page
class PDF extends FPDF {
    function Header() {
         $this->Image('public/img/logo.png', 10, 6, 20);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'FastYndYum - Facture', 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 8, 'Generee le: ' . date('d/m/Y H:i'), 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Creation de l'objet PDF
$pdf = new PDF();
$pdf->AddPage();


// Informations du restaurant
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(100, 8, $restaurant['name'], 0, 0);
$pdf->Cell(0, 8, 'Client', 0, 1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(100, 8, $restaurant['address'], 0, 0);
$pdf->Cell(0, 8, 'Nom: ' . $order['prenom'] . ' ' . $order['nom'], 0, 1);

$pdf->Cell(100, 8, 'Tel: ' . $restaurant['phone'], 0, 0);
$pdf->Cell(0, 8, 'Email: ' . $order['email'], 0, 1);

$pdf->Cell(100, 8, 'Email: ' . $restaurant['email'], 0, 0);
$pdf->Cell(0, 8, 'Telephone: ' . $order['telephone'], 0, 1);

$pdf->Cell(100, 8, '' , 0, 0);
$pdf->Cell(0, 8, 'Adresse: ' . $order['adresse'], 0, 1);


$pdf->Ln(8);

$pdf->SetFont('Arial', 'B', 12);
$title = 'Facture Commande #' . $order['commande_id'];
$pdf->Cell(0, 10, $title, 0, 1, 'C');
$pdf->Ln(8);

// Tableau des details de la commande
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(60, 8, 'Plat', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'Prix', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Quantite', 1, 0, 'C', true);
$pdf->Cell(55, 8, 'Total', 1, 1, 'C', true);

// Remplissage du tableau avec les donnees de commande
$total = 0;
$pdf->SetFont('Arial', '', 10);
foreach ($order_lines as $line) {
    $line_total = $line['prix'] * $line['quantite'];
    $total += $line_total;
    $pdf->Cell(60, 8, $line['titre'], 1, 0, 'C');
    $pdf->Cell(40, 8, number_format($line['prix'], 2) . ' DH', 1, 0, 'C');
    $pdf->Cell(30, 8, $line['quantite'], 1, 0, 'C');
    $pdf->Cell(55, 8, number_format($line_total, 2) . ' DH', 1, 0, 'C');
}

// Affichage du montant total
$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(100, 8, '', 0, 0);
$pdf->Cell(30, 8, 'Total', 1, 0, 'C', true);
$pdf->Cell(55, 8, number_format($total, 2) . ' DH', 1, 1, 'C');

// Generation du fichier PDF
$pdf->Output();
?>
