<?php
// Prevent direct access
if (!isset($data)) {
    header("Location: index.php?page=statistique");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 10px; background: #fff; }
        .container { max-width: 1000px; margin: auto; }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 5px; }
        .stat-box { background: #f0f0f0; padding: 5px; text-align: center; border: 1px solid #ccc; }
        .stat-box span, .stat-box p { font-size: 12px; margin: 0; }
        form { margin: 10px 0; }
        select, button { padding: 5px; font-size: 12px; border: 1px solid #ccc; }
        button { background: #333; color: #fff; border: none; cursor: pointer; }
        h2 { font-size: 14px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="stats">
            <div class="stat-box"><span>Clients</span><p><?= htmlspecialchars($data['stats']['nbUsers']) ?></p></div>
            <div class="stat-box"><span>Admins</span><p><?= htmlspecialchars($data['stats']['nbAdmins']) ?></p></div>
            <div class="stat-box"><span>Commandes</span><p><?= htmlspecialchars($data['stats']['nbOrders']) ?></p></div>
            <div class="stat-box"><span>Plats</span><p><?= htmlspecialchars($data['stats']['nbDishes']) ?></p></div>
            <div class="stat-box"><span>Catégories</span><p><?= htmlspecialchars($data['stats']['nbCategories']) ?></p></div>
            <div class="stat-box"><span>Revenus</span><p><?= htmlspecialchars($data['stats']['revenue']) ?> DH</p></div>
        </div>
        <h2>Télécharger PDF</h2>
        <form method="get" action="view/admin/export_pdf.php">
            <select name="month" required>
                <option value="">Sélectionner un mois</option>
                <?php foreach ($data['availableMonths'] as $month): ?>
                    <option value="<?= htmlspecialchars($month) ?>">
                        <?= date('F Y', strtotime($month . '-01')) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Télécharger</button>
        </form>
    </div>
</body>
</html>