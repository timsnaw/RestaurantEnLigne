<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Informations sur le plat</title>
</head>
<body>
    <div>
        <h2>Informations sur le plat - <?= htmlspecialchars($plat['titre'] ?? 'Plat'); ?></h2>
        <?php if (!empty($message)): ?>
            <div><?= htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <div>
            <a href="index.php?page=plat_edit&plat_id=<?= htmlspecialchars($plat['plat_id']); ?>">Modifier le plat</a>
            <a href="index.php?page=plats">Retour à la liste des plats</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Catégorie</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($plat)): ?>
                    <tr>
                        <td colspan="6">Aucun plat trouvé.</td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td><?= htmlspecialchars($plat['plat_id']); ?></td>
                        <td><?= htmlspecialchars($plat['titre']); ?></td>
                        <td><?= htmlspecialchars($categorieInfo['nom_categorie'] ?? 'Non disponible'); ?></td>
                        <td><?= htmlspecialchars($plat['description'] ?? 'Non disponible'); ?></td>
                        <td><?= htmlspecialchars(number_format($plat['prix'], 2)); ?> €</td>
                        <td>
                            <?php if (!empty($plat['image'])): ?>
                                <img src="/FastAndYam/<?= htmlspecialchars($plat['image']); ?>" alt="Image du plat" style="max-width: 100px;">
                            <?php else: ?>
                                Pas d'image
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>