<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <title>Liste des promotions</title>
</head>
<!-- Favicon -->
  <link href="/FastAndYumProject/FastAndYum/public/img/logo1.png" rel="icon" />

  <!-- Bootstrap CSS -->
  <link href="/FastAndYumProject/FastAndYum/public/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Custom CSS -->
  <link href="/fastandyam/FastAndYum/public/css/admin/promotion_info.css" rel="stylesheet" />
<body>
    <div >
        <h2>Liste des promotions</h2>
        <?php if (isset($_SESSION['success'])): ?>
            <p style="color: green;"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <p style="color: red;"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
        <?php endif; ?>
        <a href="index.php?page=promotion_add" >Ajouter une promotion</a>
        <?php if (empty($promotions)): ?>
            <p>Aucune promotion trouvée.</p>
        <?php else: ?>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Plat</th>
                        <th>Taux de réduction (%)</th>
                        <th>Date de début</th>
                        <th>Date de fin</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($promotions as $promotion): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($promotion['promo_id']); ?></td>
                            <td><?php echo htmlspecialchars($promotion['plat_titre'] ?? 'Plat ID: ' . $promotion['plat_id']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($promotion['taux_reduction'], 2)); ?></td>
                            <td><?php echo htmlspecialchars($promotion['date_debut']); ?></td>
                            <td><?php echo htmlspecialchars($promotion['date_fin']); ?></td>
                            <td>
                                <a href="index.php?page=promotion_edit&promo_id=<?php echo htmlspecialchars($promotion['promo_id']); ?>" >Éditer</a>
                                <a href="index.php?page=promotion_delete&promo_id=<?php echo htmlspecialchars($promotion['promo_id']); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette promotion ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>