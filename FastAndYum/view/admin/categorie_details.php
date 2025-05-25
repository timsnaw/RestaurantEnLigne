<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de la catégorie</title>
</head>
<body>
    <div>
        
        <?php if (isset($_SESSION['error'])): ?>
            <p style="color: red;">
                <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </p>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <p style="color: green;">
                <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            </p>
        <?php endif; ?>
        <h2>Détails de la catégorie</h2>
        <?php if (isset($categorieInfo) && $categorieInfo): ?>
            <table border="1" cellpadding="8" cellspacing="0">
                <tr>
                    <th>Identifiant</th>
                    <td><?php echo htmlspecialchars($categorieInfo['categorie_id']); ?></td>
                </tr>
                <tr>
                    <th>Nom</th>
                    <td><?php echo htmlspecialchars($categorieInfo['nom_categorie']); ?></td>
                </tr>
                <tr>
                    <th>Image</th>
                    <td>
                        <?php if ($categorieInfo['image_categorie']): ?>
                            <img src="public/img/<?php echo htmlspecialchars($categorieInfo['image_categorie']); ?>" alt="Image Catégorie" style="max-width: 100px;">
                        <?php else: ?>
                            Aucune image
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Date de création</th>
                    <td><?php echo htmlspecialchars($categorieInfo['date_ajout'] ?? 'Non disponible'); ?></td>
                </tr>
            </table>

            <h3>Plats dans cette catégorie</h3>
            <?php if (empty($plats)): ?>
                <p>Aucun plat trouvé.</p>
            <?php else: ?>
                <table border="1" cellpadding="8" cellspacing="0">
                    <tr>
                        <th>ID du plat</th>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Image</th>
                    </tr>
                    <?php foreach ($plats as $plat): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($plat['plat_id']); ?></td>
                            <td><?php echo htmlspecialchars($plat['titre']); ?></td>
                            <td><?php echo htmlspecialchars($plat['description'] ?? 'Non disponible'); ?></td>
                            <td><?php echo htmlspecialchars($plat['prix']); ?></td>
                            <td>
                                <?php if ($plat['image']): ?>
                                    <img src="public/img/<?php echo htmlspecialchars($plat['image']); ?>" alt="Image Plat" style="max-width: 50px;">
                                <?php else: ?>
                                    Aucune image
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>

            <p>
                <a href="index.php?page=categorie_edit&categorie_id=<?php echo $categorieInfo['categorie_id']; ?>">Modifier</a> |
                <a href="index.php?page=categorie_delete&categorie_id=<?php echo $categorieInfo['categorie_id']; ?>" onclick="return confirm('Voulez-vous vraiment supprimer cette catégorie ?');">Supprimer</a>
            </p>
        <?php else: ?>
            <p>Aucune information disponible pour cette catégorie.</p>
        <?php endif; ?>

        <p><a href="index.php?page=categorie_info">Retour à la liste</a></p>
    </div>
</body>
</html>
