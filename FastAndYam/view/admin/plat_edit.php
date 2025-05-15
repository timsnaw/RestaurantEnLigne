<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Plat</title>
    <style>
        .error-message {
            color: red;
            display: none;
            margin-top: 5px;
            font-size: 14px;
        }
        .image-preview {
            max-width: 100px;
            margin-top: 10px;
            display: none;
        }
    </style>
</head>
<body>
    <div>
        <h2>Modifier Plat</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <div style="color: red;"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <div style="color: green;"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <form id="plat-form" method="POST" action="index.php?page=plat_edit&plat_id=<?php echo $platInfo['plat_id']; ?>" enctype="multipart/form-data">
            <div>
                <label>Titre</label>
                <input type="text" name="titre" value="<?php echo htmlspecialchars($platInfo['titre']); ?>" required>
            </div>
            <div>
                <label>Description</label>
                <textarea name="description"><?php echo htmlspecialchars($platInfo['description'] ?? ''); ?></textarea>
            </div>
            <div>
                <label>Prix (DH)</label>
                <input type="number" step="0.01" name="prix" value="<?php echo htmlspecialchars($platInfo['prix']); ?>" required>
            </div>
            <div>
                <label>Catégorie</label>
                <select name="categorie_id" required>
                    <option value="">Choisir une catégorie</option>
                    <?php foreach ($categories as $categorie): ?>
                        <option value="<?php echo $categorie['categorie_id']; ?>" <?php echo $platInfo['categorie_id'] == $categorie['categorie_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($categorie['nom_categorie']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Image du plat</label>
                <input type="file" id="plat-images" name="image" accept="image/jpeg,image/png,image/gif">
                <div id="plat-image-error" class="error-message"></div>
                <img id="plat-image-preview" class="image-preview" src="#" alt="Aperçu de l'image">
                <?php if ($platInfo['image']): ?>
                    <p>Image actuelle : <img src="public/images/<?php echo htmlspecialchars($platInfo['image']); ?>" alt="Image du plat" style="max-width: 100px;"></p>
                <?php endif; ?>
            </div>
            <button type="submit">Mettre à jour</button>
            <a href="index.php?page=plat_info&categorie_id=<?php echo $platInfo['categorie_id']; ?>">Annuler</a>
        </form>
    </div>
    <script src="public/js/imageValidation.js"></script>
</body>
</html>