<?php
if (!isset($orders)) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./public/css/bootstrap.min.css">
    <title>Mes Commandes</title>
</head>
<style>
    /* commandes.css */

/* Améliorer le style du tableau */
table.table {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-radius: 8px;
    overflow: hidden;
}

table.table thead {
    background-color: #2980b9;
    color: white;
}

table.table thead th {
    border: none;
    font-weight: 600;
    text-align: center;
}

table.table tbody tr:hover {
    background-color: #f0f8ff;
}

table.table tbody td {
    vertical-align: middle;
    text-align: center;
}

/* Boutons */
.btn-sm {
    font-size: 0.85rem;
    padding: 0.3rem 0.6rem;
    border-radius: 4px;
}

.btn-danger {
    background-color: #e74c3c;
    border-color: #e74c3c;
}

.btn-danger:hover {
    background-color: #c0392b;
    border-color: #c0392b;
}

.btn-primary {
    background-color: #2980b9;
    border-color: #2980b9;
}

.btn-primary:hover {
    background-color: #1c5980;
    border-color: #1c5980;
}

/* Messages d'alerte */
.alert {
    font-size: 1rem;
    font-weight: 500;
}

/* Container margin top plus grand */
.container.mt-4 {
    margin-top: 2.5rem !important;
}

</style>
<body>
    <div class="container mt-4">
        <h2>Mes Commandes</h2>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php elseif (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <?php if (empty($orders)): ?>
            <p>Aucune commande trouvée.</p>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Commande</th>
                        <th>Date</th>
                        <th>Plat</th>
                        <th>Quantité</th>
                        <th>Prix</th>
                        <th>État</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <?php
                        // Map numeric etat_commande to human-readable status
                        $etat_affiche = match ($order['etat_commande']) {
                            1 => 'En cours',
                            2 => 'En livraison',
                            2 => 'Livrée',
                            4 => 'Annulée',
                            default => 'Inconnu',
                        };
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['commande_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['date_commande']); ?></td>
                            <td><?php echo htmlspecialchars($order['titre']); ?></td>
                            <td><?php echo htmlspecialchars($order['quantite']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($order['prix'], 2)); ?> DH</td>
                            <td><?php echo htmlspecialchars($etat_affiche); ?></td>
                            <td>
                                <?php if ($order['etat_commande'] == '1'): ?>
                                    <a href="index.php?page=cancel_order&commande_id=<?php echo $order['commande_id']; ?>" class="btn btn-danger btn-sm">Annuler</a>
                                <?php endif; ?>
                                <a href="index.php?page=export_facture&commande_id=<?php echo $order['commande_id']; ?>" class="btn btn-primary btn-sm">Exporter Facture</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>