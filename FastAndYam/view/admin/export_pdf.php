<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

require_once BASE_PATH . 'vendor/fpdf/fpdf.php'; // Updated path to FPDF

// Verify data (passed from UserController)
if (!isset($data)) {
    header("Location: index.php?page=commande_user_info");
    exit;
}

$order = $data['order'];
$order_lines = $data['order_lines'];
$payment = $data['payment'];
$restaurant = $data['restaurant'];

// Create custom PDF class
class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'FastYndYam - Facture', 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 8, 'Générée le: ' . date('d/m/Y H:i'), 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Create PDF
try {
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);
    $title = 'Facture Commande #' . $order['commande_id'];
    $pdf->Cell(0, 10, $title, 0, 1, 'C');
    $pdf->Ln(8);

    // Restaurant details
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 8, $restaurant['name'], 0, 1);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 8, $restaurant['address'], 0, 1);
    $pdf->Cell(0, 8, 'Tél: ' . $restaurant['phone'], 0, 1);
    $pdf->Cell(0, 8, 'Email: ' . $restaurant['email'], 0, 1);
    $pdf->Ln(8);

    // Client details
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 8, 'Client', 0, 1);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 8, 'Nom: ' . ($order['prenom'] ?? '') . ' ' . ($order['nom'] ?? ''), 0, 1);
    $pdf->Cell(0, 8, 'Email: ' . ($order['email'] ?? ''), 0, 1);
    $pdf->Cell(0, 8, 'Téléphone: ' . ($order['telephone'] ?? ''), 0, 1);
    $pdf->Cell(0, 8, 'Adresse: ' . ($order['adresse'] ?? ''), 0, 1);
    $pdf->Ln(8);

    // Order details table
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(220, 220, 220);
    $pdf->Cell(50, 8, 'Plat', 1, 0, 'C', true);
    $pdf->Cell(30, 8, 'Prix', 1, 0, 'C', true);
    $pdf->Cell(20, 8, 'Quantité', 1, 0, 'C', true);
    $pdf->Cell(50, 8, 'Ajouts', 1, 0, 'C', true);
    $pdf->Cell(30, 8, 'Total', 1, 1, 'C', true);

    // Table data
    $total = 0;
    $pdf->SetFont('Arial', '', 10);
    foreach ($order_lines as $line) {
        $line_total = $line['prix'] * $line['quantite'];
        $total += $line_total;
        $pdf->Cell(50, 8, $line['titre'] ?? '-', 1, 0, 'C');
        $pdf->Cell(30, 8, number_format($line['prix'], 2) . ' DH', 1, 0, 'C');
        $pdf->Cell(20, 8, $line['quantite'] ?? '-', 1, 0, 'C');
        $pdf->Cell(50, 8, $line['ajout'] ?? '-', 1, 0, 'C');
        $pdf->Cell(30, 8, number_format($line_total, 2) . ' DH', 1, 1, 'C');
    }

    // Total amount
    $pdf->Ln(8);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(150, 8, 'Total', 1, 0, 'R', true);
    $pdf->Cell(30, 8, number_format($total, 2) . ' DH', 1, 1, 'C');

    // Output PDF
    $pdf->Output('D', 'facture_commande_' . $order['commande_id'] . '.pdf');
} catch (Exception $e) {
    error_log("PDF generation error: " . $e->getMessage());
    $_SESSION['error'] = "Erreur lors de la génération de la facture.";
    header('Location: index.php?page=commande_user_info');
    exit;
}
?>