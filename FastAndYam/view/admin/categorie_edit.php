<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($categorieInfo) ? 'Modifier une catégorie' : 'Erreur'; ?></title>
    <style>
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }
        #image-preview {
            margin-top: 10px;
            max-width: 150px;
            display: none;
        }
    </style>
</head>
<body>
    <div>
        <h2><?php echo isset($categorieInfo) ? 'Modifier une catégorie' : 'Erreur'; ?></h2>


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
                <label for="images">Image de la catégorie</label><br>
                <input type="file" name="images" id="images" accept="image/jpeg,image/png,image/gif">
                <p id="image-error" class="error-message"></p>
                <img id="image-preview" src="#" alt="Prévisualisation de l'image">
                <?php if ($categorieInfo['image_categorie']): ?>
                    <p>Image actuelle : 
                    <img src="public/images/<?php echo htmlspecialchars($categorieInfo['image_categorie']); ?>"
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

    <script src="public/js/categorie.js"></script>
</body>
</html>