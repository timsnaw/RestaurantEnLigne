<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Modifier Administrateur</title>

  <!-- Favicon -->
  <link href="/FastAndYumProject/FastAndYum/public/img/logo1.png" rel="icon" />

  <!-- Bootstrap -->
  <link href="/FastAndYumProject/FastAndYum/public/css/bootstrap.min.css" rel="stylesheet" />
  <!-- CSS personnalisé -->
  <link href="/fastandyam/FastAndYum/public/css/admin/admin_edit.css" rel="stylesheet" />
</head>
<body>

  <div class="container user_details">
    <h2>Modifier l'administrateur</h2>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (isset($adminInfo) && $adminInfo): ?>
      <form class="form-custom" method="POST" action="index.php?page=admin_edit&user_id=<?= $adminInfo['user_id']; ?>">

        <div class="form-group">
          <label for="prenom">Prénom</label>
          <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($adminInfo['prenom']); ?>" required />
        </div>

        <div class="form-group">
          <label for="nom">Nom</label>
          <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($adminInfo['nom']); ?>" required />
        </div>

        <div class="form-group">
          <label for="username">Nom d'utilisateur</label>
          <input type="text" id="username" name="username" value="<?= htmlspecialchars($adminInfo['username']); ?>" required />
        </div>

        <div class="form-group">
          <label for="email">Adresse email</label>
          <input type="email" id="email" name="email" value="<?= htmlspecialchars($adminInfo['email']); ?>" required />
        </div>

        <div class="form-group">
          <label for="password">Nouveau mot de passe (laisser vide pour conserver l'actuel)</label>
          <input type="password" id="password" name="password" />
        </div>

        <div class="form-group">
          <label for="confirm_password">Confirmer le nouveau mot de passe</label>
          <input type="password" id="confirm_password" name="confirm_password" />
        </div>

        <div class="actions">
          <button type="submit" class="btn-orange">Mettre à jour</button>
          <a href="index.php?page=admin_details&user_id=<?= $adminInfo['user_id']; ?>" class="btn btn-secondary">Annuler</a>
        </div>

      </form>
    <?php else: ?>
      <p>Aucune information sur l'administrateur disponible.</p>
      <a href="index.php?page=admin_info" class="btn btn-secondary back-link">Retour à la liste</a>
    <?php endif; ?>
  </div>

</body>
</html>
