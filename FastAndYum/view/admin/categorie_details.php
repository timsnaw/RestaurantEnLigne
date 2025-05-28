<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Détails de la catégorie</title>

    <!-- Favicon -->
    <link href="/FastAndYumProject/FastAndYum/public/img/logo1.png" rel="icon" />

    <!-- Bootstrap -->
    <link href="/FastAndYumProject/FastAndYum/public/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link href="/fastandyam/FastAndYum/public/css/admin/categorie_details.css" rel="stylesheet" />
</head>
<body>

<div class="container categorie-details-page my-5">

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

    <h2 class="mb-4 text-center">Détails de la catégorie</h2>

    <?php if (isset($categorieInfo) && $categorieInfo): ?>
        <div class="table-responsive mb-5 shadow rounded p-3 bg-white">
            <table class="table table-bordered mb-0">
                <tbody>
                    <tr>
                        <th>Identifiant</th>
                        <td><?= htmlspecialchars($categorieInfo['categorie_id']); ?></td>
                    </tr>
                    <tr>
                        <th>Nom</th>
                        <td><?= htmlspecialchars($categorieInfo['nom_categorie']); ?></td>
                    </tr>
                    <tr>
                        <th>Image</th>
                        <td>
                            <?php if ($categorieInfo['image_categorie']): ?>
                                <img src="public/img/<?= htmlspecialchars($categorieInfo['image_categorie']); ?>" alt="Image Catégorie" class="img-thumbnail" style="max-width: 150px;">
                            <?php else: ?>
                                <span class="text-muted">Aucune image</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Date de création</th>
                        <td><?= htmlspecialchars($categorieInfo['date_ajout'] ?? 'Non disponible'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h3 class="mb-3">Plats dans cette catégorie</h3>

        <?php if (empty($plats)): ?>
            <p class="text-muted">Aucun plat trouvé.</p>
        <?php else: ?>
            <div class="table-responsive shadow rounded p-3 bg-white">
                <table class="table table-hover table-bordered mb-0 plats-table">
                    <thead class="table-primary">
                        <tr>
                            <th>ID du plat</th>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Prix</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($plats as $plat): ?>
                            <tr>
                                <td data-label="ID du plat"><?= htmlspecialchars($plat['plat_id']); ?></td>
                                <td data-label="Titre"><?= htmlspecialchars($plat['titre']); ?></td>
                                <td data-label="Description"><?= htmlspecialchars($plat['description'] ?? 'Non disponible'); ?></td>
                                <td data-label="Prix"><?= htmlspecialchars($plat['prix']); ?> €</td>
                                <td data-label="Image">
                                    <?php if ($plat['image']): ?>
                                        <img src="public/img/<?= htmlspecialchars($plat['image']); ?>" alt="Image Plat" class="img-thumbnail" />
                                    <?php else: ?>
                                        <span class="text-muted">Aucune image</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <div class="mt-4 d-flex justify-content-center gap-3 btn-group">
            <a href="index.php?page=categorie_edit&categorie_id=<?= $categorieInfo['categorie_id']; ?>" class="btn btn-warning">
                Modifier
            </a>
            <a href="index.php?page=categorie_delete&categorie_id=<?= $categorieInfo['categorie_id']; ?>" 
               class="btn btn-danger" 
               onclick="return confirm('Voulez-vous vraiment supprimer cette catégorie ?');">
                Supprimer
            </a>
        </div>
    <?php else: ?>
        <p class="text-center text-muted">Aucune information disponible pour cette catégorie.</p>
    <?php endif; ?>

    <p class="text-center mt-5">
        <a href="index.php?page=categorie_info" class="btn btn-secondary">Retour à la liste</a>
    </p>
</div>

</body>
</html>
