<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter Plat</title>
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
        .secondary-image-preview {
            max-width: 100px;
            margin: 10px 0;
        }
        .image-group {
            margin-bottom: 10px;
        }
        .info-message {
            color: #555;
            font-size: 12px;
            margin-top: 5px;
        }
        button {
            margin: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div>
        <h2>Ajouter Plat hhh</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <div style="color: red;"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <div style="color: green;"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <form id="plat-form" method="POST" action="index.php?page=plat_add<?php echo isset($_GET['categorie_id']) ? '&categorie_id=' . (int)$_GET['categorie_id'] : ''; ?>" enctype="multipart/form-data">
            <div>
                <label>Titre</label>
                <input type="text" name="titre" value="" required>
            </div>
            <div>
                <label>Description</label>
                <textarea name="description"></textarea>
            </div>
            <div>
                <label>Prix (DH)</label>
                <input type="number" step="0.01" name="prix" value="" required>
            </div>
            <div>
                <label>Catégorie</label>
                <select name="categorie_id" required>
                    <option value="">Choisir une catégorie</option>
                    <?php foreach ($categories as $categorie): ?>
                        <option value="<?php echo $categorie['categorie_id']; ?>" <?php echo isset($_GET['categorie_id']) && $_GET['categorie_id'] == $categorie['categorie_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($categorie['nom_categorie']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Image principale</label>
                <input type="file" id="plat-image" name="image" accept="image/jpeg,image/png,image/gif" required>
                <div id="plat-image-error" class="error-message"></div>
                <img id="plat-image-preview" class="image-preview" src="#" alt="Aperçu de l'image">
            </div>
            <div>
                <label>Autre Images (optionnel)</label>
                <div id="secondary-images-inputs">
                    <div class="image-group">
                        <input type="file" name="images_secondary[]" accept="image/jpeg,image/png,image/gif">
                        <button type="button" class="remove-image">Supprimer</button>
                        <img class="secondary-image-preview" src="#" alt="Aperçu de l'image" style="display: none;">
                    </div>
                </div>
                <div id="plat-images-secondary-error" class="error-message"></div>
                <button type="button" id="add-secondary-image">Ajouter une autre image</button>
            </div>
            <button type="submit">Ajouter</button>
            <a href="index.php?page=plats">Annuler</a>
        </form>
    </div>
       <script src="public/js/imageValidation.js"></script>
</body>
</html>
