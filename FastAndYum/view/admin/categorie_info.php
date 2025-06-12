<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Informations sur les catégories</title>

    <!-- Favicon -->
    <link href="public/img/logo1.png" rel="icon" />

    <!-- Bootstrap -->
    <link href="public/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link href="public/css/admin/categorie_info.css" rel="stylesheet" />
</head>
<body>

    <div class="container category-page">
        <h2 class="text-center">Informations sur les catégories</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success text-center" role="alert">
                <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <div class="mb-4 text-end">
            <a href="index.php?page=categorie_add" class="btn btn-add-category">Ajouter une catégorie</a>
        </div>

        <div class="category-table-container table-responsive shadow-sm rounded">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th scope="col">Identifiant</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Date de création</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($categories)): ?>
                        <tr>
                            <td colspan="4" class="text-center">Aucune catégorie trouvée.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?= htmlspecialchars($category['categorie_id']); ?></td>
                                <td><?= htmlspecialchars($category['nom_categorie']); ?></td>
                                <td><?= htmlspecialchars($category['date_ajout'] ?? 'N/A'); ?></td>
                                <td class="text-center">
                                    <a href="index.php?page=categorie_details&categorie_id=<?= $category['categorie_id']; ?>"
                                       class="btn btn-view-details btn-sm">
                                        Voir
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
