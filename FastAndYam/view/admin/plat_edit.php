```html
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
        .secondary-image-container {
            display: flex;
            flex-wrap: wrap;
            margin-top: 10px;
        }
        .secondary-image {
            max-width: 100px;
            margin: 10px;
            position: relative;
        }
        .secondary-image img {
            max-width: 100%;
        }
        .secondary-image .remove-btn {
            position: absolute;
            top: 0;
            right: 0;
            background: red;
            color: white;
            border: none;
            cursor: pointer;
            padding: 2px 5px;
        }
        .info-message {
            color: #555;
            font-size: 12px;
            margin-top: 5px;
        }
        .image-group {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .image-group input[type="file"] {
            margin-right: 10px;
        }
        .image-group button {
            margin: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }
        .secondary-image-preview {
            max-width: 100px;
            margin: 10px 0;
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
                <label>Image principale (optionnel)</label>
                <input type="file" id="plat-image" name="image" accept="image/jpeg,image/png,image/gif">
                <div id="plat-image-error" class="error-message"></div>
                <img id="plat-image-preview" class="image-preview" src="#" alt="Aperçu de l'image">
                <?php if ($platInfo['image']): ?>
                    <p>Image principale actuelle : <img src="public/img/<?php echo htmlspecialchars($platInfo['image']); ?>" alt="Image principale du plat" style="max-width: 100px;"></p>
                <?php endif; ?>
            </div>
            <div>
                <label>Images secondaires (optionnel)</label>
                <div id="secondary-images-inputs">
                    <div class="image-group">
                        <input type="file" name="images_secondary[]" accept="image/jpeg,image/png,image/gif">
                        <button type="button" class="remove-image">Supprimer</button>
                        <img class="secondary-image-preview" src="#" alt="Aperçu de l'image" style="display: none;">
                    </div>
                </div>
                <div id="plat-images-secondary-error" class="error-message"></div>
                <button type="button" id="add-secondary-image">Ajouter une autre image</button>
                <div class="info-message">Vous pouvez ajouter jusqu'à 5 images secondaires, une à la fois.</div>
                <div id="secondary-images-preview" class="secondary-image-container">
                    <?php
                    $secondaryImages = $this->platModel->getSecondairesImages($platInfo['plat_id']);
                    foreach ($secondaryImages as $image): ?>
                        <div class="secondary-image" data-image-id="<?php echo $image['image_id']; ?>">
                            <img src="public/img/<?php echo htmlspecialchars($image['image_plat']); ?>" alt="Image secondaire">
                            <button type="button" class="remove-btn" onclick="window.location.href='index.php?page=plat_edit&plat_id=<?php echo $platInfo['plat_id']; ?>&delete_image_id=<?php echo $image['image_id']; ?>'">supprimer</button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <button type="submit">Mettre à jour</button>
            <a href="index.php?page=plat_info&categorie_id=<?php echo $platInfo['categorie_id']; ?>" onclick="console.log('Cancel link clicked')">Annuler</a>
        </form>
    </div>
    <script src="public/js/imageValidation.js"></script>
</body>
</html>