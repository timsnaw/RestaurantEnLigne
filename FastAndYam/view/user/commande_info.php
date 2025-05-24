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
                        <tr>
                            <td><?php echo htmlspecialchars($order['commande_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['date_commande']); ?></td>
                            <td><?php echo htmlspecialchars($order['titre']); ?></td>
                            <td><?php echo htmlspecialchars($order['quantite']); ?></td>
                            <td><?php echo htmlspecialchars($order['prix']); ?> €</td>
                            <td><?php echo htmlspecialchars($order['etat_commande']); ?></td>
                            <td>
                                <?php if ($order['etat_commande'] === 'pending'): ?>
                                    <a href="index.php?page=cancel_order&commande_id=<?php echo $order['commande_id']; ?>" class="btn btn-danger btn-sm">Annuler</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>