<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une catégorie</title>
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
        <h2>Modifier une catégorie</h2>

        <?php if (!isset($categorieInfo)): ?>
            <p style="color: red;">Erreur : Aucune catégorie sélectionnée.</p>
            <a href="index.php?page=categorie_info">Retour à la liste des catégories</a>
        <?php else: ?>
        <form method="POST" action="index.php?page=categorie_edit&categorie_id=<?php echo $categorieInfo['categorie_id']; ?>" enctype="multipart/form-data" id="categorie-form">
            <div>
                <label for="nom_categorie">Nom de la catégorie</label><br>
                <input type="text" name="nom_categorie" id="nom_categorie" value="<?php echo htmlspecialchars($categorieInfo['nom_categorie']); ?>" required>
            </div>
            <br>
            <div>
                <label for="categorie-images">Image de la catégorie</label><br>
                <input type="file" name="img" id="categorie-images" accept="image/jpeg,image/png,image/gif">
                <p id="categorie-image-error" class="error-message"></p>
                <img id="categorie-image-preview" class="image-preview" src="#" alt="Prévisualisation de l'image">
                <?php if ($categorieInfo['image_categorie']): ?>
                    <p>Image actuelle : 
                    <img src="public/img/<?php echo htmlspecialchars($categorieInfo['image_categorie']); ?>"
                         alt="Image Catégorie" 
                         style="max-width: 100px;">
                    </p>
                <?php endif; ?>
            </div>
            <br>
            <div>
                <button type="submit">Mettre à jour</button>
                <a href="index.php?page=categorie_info">Annuler</a>
            </div>
        </form>
        <?php endif; ?>
    </div>

   <script src="public/js/imageValidation.js"></script>
</body>
</html>