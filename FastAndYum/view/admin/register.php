<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inscription Administrateur</title>

  <!-- Favicon -->
  <link href="/FastAndYumProject/FastAndYum/public/img/logo1.png" rel="icon" />

  <!-- Bootstrap -->
  <link href="/FastAndYumProject/FastAndYum/public/css/bootstrap.min.css" rel="stylesheet" />

  <!-- CSS personnalisé -->
  <link href="/fastandyam/FastAndYum/public/css/admin/register.css" rel="stylesheet" />
</head>
<body>
  <div class="container user_register">
    <h2>Inscription Administrateur</h2>

    <?php if (!empty($_SESSION['error'])): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php elseif (!empty($_SESSION['success'])): ?>
      <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <form class="form-custom" method="POST" action="index.php?page=register">

      <div class="form-group">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" id="username" name="username" required />
      </div>

      <div class="form-group">
        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom" required />
      </div>

      <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" required />
      </div>

      <div class="form-group">
        <label for="email">Adresse e-mail</label>
        <input type="email" id="email" name="email" required />
      </div>

      <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required />
      </div>

      <div class="form-group">
        <label for="confirm_password">Confirmer le mot de passe</label>
        <input type="password" id="confirm_password" name="confirm_password" required />
      </div>

      <div class="actions">
        <input type="submit" name="inscrire" value="S'inscrire" class="btn-blue" />
        <a href="index.php?page=admin_info" class="btn btn-secondary">Retour à la liste</a>
      </div>
    </form>
  </div>
</body>
</html>
