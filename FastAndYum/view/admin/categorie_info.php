<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Informations sur les catégories</title>
</head>
<body>
    <div>
        <h2>Informations sur les catégories</h2>
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

         <a href="index.php?page=categorie_add">Ajouter</a>
        <table border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <th>Identifiant</th>
                    <th>Nom</th>
                    <th>Date de création</th>
                    <th>Action</th>
                </tr>

                <?php if (empty($categories)): ?>
                    <tr>
                        <td colspan="4">Aucune catégorie trouvée.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($category['categorie_id']); ?></td>
                            <td><?php echo htmlspecialchars($category['nom_categorie']); ?></td>
                            <td><?php echo htmlspecialchars($category['date_ajout'] ?? 'N/A'); ?></td>
                            <td>
                                <a href="index.php?page=categorie_details&categorie_id=<?php echo $category['categorie_id']; ?>">Voir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>

        </table>
    </div>
</body>
</html>
