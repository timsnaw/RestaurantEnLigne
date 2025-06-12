<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Ajouter une catégorie</title>

    <!-- Favicon -->
    <link href="public/img/logo1.png" rel="icon" />

    <!-- Bootstrap -->
    <link href="public/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link href="public/css/admin/categorie_add.css" rel="stylesheet" />
</head>
<body>

    <div class="add-category-page">
        <h2>Ajouter une catégorie</h2>

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

        <div class="form-container">
            <form method="POST" action="index.php?page=categorie_add" enctype="multipart/form-data" id="categorie-form" novalidate>
                <div class="form-group">
                    <label for="nom_categorie">Nom de la catégorie</label>
                    <input type="text" name="nom_categorie" id="nom_categorie" class="form-control" required />
                    <p id="nom_categorie-error" class="error-message">Ce champ est requis.</p>
                </div>

                <div class="form-group">
                    <label for="categorie-images">Image de la catégorie (optionnel)</label>
                    <input type="file" name="img" id="categorie-images" class="form-control" accept="image/jpeg,image/png,image/gif" />
                    <p id="categorie-image-error" class="error-message"></p>
                    <img id="categorie-image-preview" class="image-preview" src="#" alt="Prévisualisation de l'image" />
                </div>

                <div class="d-flex justify-content-center align-items-center mt-4">
                    <button type="submit" class="btn-submit">Ajouter</button>
                    <a href="index.php?page=categorie_info" class="btn-cancel">Annuler</a>
                </div>
            </form>
        </div>
    </div>

    <script src="public/js/imageCategorie.js"></script>

</body>
</html>
