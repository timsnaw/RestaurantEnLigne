<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier une catégorie</title>

  <!-- Favicon -->
  <link href="public/img/logo1.png" rel="icon" />

  <!-- Bootstrap CSS -->
  <link href="public/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Custom CSS -->
  <link href="public/css/admin/categorie_edit.css" rel="stylesheet" />
</head>
<body class="user_details">

  <div class="container">
    <h2>Modifier une catégorie</h2>

    <?php if (!isset($categorieInfo)): ?>
      <div class="alert alert-danger">Erreur : Aucune catégorie sélectionnée.</div>
      <div class="back-link">
        <a href="index.php?page=categorie_info" class="btn btn-secondary">Retour</a>
      </div>
    <?php else: ?>
      <form method="POST" action="index.php?page=categorie_edit&categorie_id=<?php echo $categorieInfo['categorie_id']; ?>" enctype="multipart/form-data" class="form-custom">
        
        <div class="form-group">
          <label for="nom_categorie">Nom de la catégorie</label>
          <input type="text" name="nom_categorie" id="nom_categorie" class="form-control" value="<?php echo htmlspecialchars($categorieInfo['nom_categorie']); ?>" required>
        </div>

        <div class="form-group">
          <label for="categorie-images">Image de la catégorie</label>
          <input type="file" name="img" id="categorie-images" class="form-control" accept="image/jpeg,image/png,image/gif">
          <p id="categorie-image-error" class="error-message"></p>
          <img id="categorie-image-preview" class="image-preview" src="#" alt="Prévisualisation de l'image">

          <?php if ($categorieInfo['image_categorie']): ?>
            <p class="mt-3">Image actuelle :</p>
            <img src="public/img/<?php echo htmlspecialchars($categorieInfo['image_categorie']); ?>" alt="Image Catégorie" style="max-width: 100px;">
          <?php endif; ?>
        </div>

        <div class="actions">
          <button type="submit" class="btn-orange">Mettre à jour</button>
          <a href="index.php?page=categorie_info" class="btn-secondary">Annuler</a>
        </div>
      </form>
    <?php endif; ?>
  </div>

   <script src="public/js/imageValidation.js"></script>
</body>
</html>