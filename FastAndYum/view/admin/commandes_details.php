<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de la commande</title>
          <!-- Favicon -->
  <link href="/FastAndYumProject/FastAndYum/public/img/logo1.png" rel="icon" />

  <!-- Bootstrap CSS -->
  <link href="/FastAndYumProject/FastAndYum/public/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Custom CSS -->
  <link href="/fastandyam/FastAndYum/public/css/admin/commandes_details.css" rel="stylesheet" />
</head>
<body>
    <div>
        <h2>Détails de la commande</h2>
        <?php if (isset($commandeInfo) && $commandeInfo): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <td><?php echo htmlspecialchars($commandeInfo['commande_id']); ?></td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td><?php echo htmlspecialchars($commandeInfo['date_commande'] ?? 'N/A'); ?></td>
                </tr>
                <tr>
                    <th>État</th>
                    <td>
                        <form action="index.php?page=commandes_etat" method="POST">
                            <input type="hidden" name="commande_id" value="<?php echo htmlspecialchars($commandeInfo['commande_id']); ?>">
                            <select name="etat_commande" onchange="this.form.submit()">
                                <?php foreach ($etat_labels as $value => $label): ?>
                                    <option value="<?php echo $value; ?>" <?php echo $commandeInfo['etat_commande'] == $value ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($label); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </td>
                </tr>
                <tr>
                    <th>Paiement</th>
                    <td><?php echo htmlspecialchars($commandeInfo['paiement_status']); ?></td>
                </tr>
                <tr>
                    <th>Mode de paiement</th>
                    <td><?php echo htmlspecialchars($commandeInfo['mode_paiement']); ?></td>
                </tr>
                <tr>
                    <th>Date de paiement</th>
                    <td><?php echo htmlspecialchars($commandeInfo['date_paiement']); ?></td>
                </tr>
                <tr>
                    <th>Adresse de livraison</th>
                    <td><?php echo htmlspecialchars($commandeInfo['adresse']); ?></td>
                </tr>
                <tr>
                    <th>ID client</th>
                    <td><?php echo htmlspecialchars($commandeInfo['user_id']); ?></td>
                </tr>
            </table>

            <h3>Lignes de commande</h3>
            <?php if (empty($lignes)): ?>
                <p>Aucune ligne de commande trouvée.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID ligne</th>
                            <th>Plat</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lignes as $ligne): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($ligne['ligne_id']); ?></td>
                                <td><?php echo htmlspecialchars($ligne['titre'] ?? 'Plat ID: ' . $ligne['plat_id']); ?></td>
                                <td><?php echo htmlspecialchars($ligne['prix']); ?></td>
                                <td><?php echo htmlspecialchars($ligne['quantite']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <a href="index.php?page=commandes_delete&commande_id=<?php echo htmlspecialchars($commandeInfo['commande_id']); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');">Supprimer</a>
            <a href="index.php?page=commandes_info">Retour à la liste</a>
        <?php else: ?>
            <p>Aucun détail de commande disponible.</p>
            <a href="index.php?page=commandes_info">Retour à la liste</a>
        <?php endif; ?>
    </div>
</body>
</html>