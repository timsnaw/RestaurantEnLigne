<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Plats</title>
</head>
<body>
    <div>
        <h2>Liste des Plats</h2>
        <?php if (!empty($message)): ?>
            <div><?= htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <div>
            <div>
                <form method="GET" action="">
                    <input type="hidden" name="page" value="plats">
                    <label>Filtrer par Catégorie</label>
                    <select name="categorie_id" onchange="this.form.submit()">
                        <option value="">Toutes les catégories</option>
                        <?php if (isset($categories) && is_array($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= htmlspecialchars($category['categorie_id']); ?>" <?= ($selected_categorie_id == $category['categorie_id']) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($category['nom_categorie']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">Aucune catégorie disponible</option>
                        <?php endif; ?>
                    </select>
                </form>
            </div>
            <div>
                <a href="index.php?page=plat_add">Ajouter un Plat</a>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Catégorie</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Image principale</th>
                    <th>Supprimer</th>
                    <th>details</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($plats) && is_array($plats)): ?>
                    <?php foreach ($plats as $plat): ?>
                        <tr>
                            <td><?= htmlspecialchars($plat['titre']); ?></td>
                            <td><?= htmlspecialchars($plat['nom_categorie']); ?></td>
                            <td><?= htmlspecialchars($plat['description']); ?></td>
                            <td><?= number_format($plat['prix'], 2); ?> DH</td>
                            <td>
                                <?php if (!empty($plat['image'])): ?>
                                    <img src="public/images/<?= htmlspecialchars($plat['image']); ?>" alt="Image principale" style="max-width: 100px;">
                                <?php else: ?>
                                    Pas d'image
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="index.php?page=plat_delete&plat_id=<?= htmlspecialchars($plat['plat_id']); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce plat ?');">Supprimer</a>
                            </td>
                             <td>
                                <a href="index.php?page=plat_info&plat_id=<?= htmlspecialchars($plat['plat_id']); ?>">voir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Aucun plat disponible.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>