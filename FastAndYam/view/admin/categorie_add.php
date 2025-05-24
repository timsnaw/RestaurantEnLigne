<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une catégorie</title>
    <style>
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }
        .image-preview {
            margin-top: 10px;
            max-width: 150px;
            display: none;
        }
    </style>
</head>
<body>
    <div>
        <h2>Ajouter une catégorie</h2>

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

        <form method="POST" action="index.php?page=categorie_add" enctype="multipart/form-data" id="categorie-form">
            <div>
                <label for="nom_categorie">Nom de la catégorie</label><br>
                <input type="text" name="nom_categorie" id="nom_categorie" required>
            </div>
            <br>
            <div>
                <label for="categorie-images">Image de la catégorie (optionnel)</label><br>
                <input type="file" name="images" id="categorie-images" accept="image/jpeg,image/png,image/gif">
                <p id="categorie-image-error" class="error-message"></p>
                <img id="categorie-image-preview" class="image-preview" src="#" alt="Prévisualisation de l'image">
            </div>
            <br>
            <div>
                <button type="submit">Ajouter</button>
                <a href="index.php?page=categorie_info">Annuler</a>
            </div>
        </form>
    </div>

    <script src="public/js/imageCategorie.js"></script>
</body>
</html>