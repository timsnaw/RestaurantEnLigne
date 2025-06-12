<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Connexion Administrateur</title>

  <!-- Favicon -->
  <link rel="icon" href="public/img/logo1.png" />

  <!-- Bootstrap CSS -->
  <link href="public/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Custom CSS -->
  <link href="public/css/admin/admin_login.css" rel="stylesheet" />
</head>
<body>
  <div class="login-container d-flex justify-content-center align-items-center">
    <div class="login-box shadow-lg p-4 rounded bg-white">
      <div class="text-center mb-4">
        <img src="public/img/logo1.png" alt="Fast&Yum Logo" class="login-logo mb-3">
        <h2 class="text-orange">Connexion Administrateur</h2>
      </div>

      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
          <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="index.php?page=admin_login">
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Mot de passe</label>
          <input type="password" name="password" class="form-control" required>
        </div>

        <div class="d-grid">
          <button type="submit" name="connexion" class="btn btn-orange">Connexion</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
