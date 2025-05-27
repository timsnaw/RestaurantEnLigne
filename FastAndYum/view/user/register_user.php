<?php include 'view/includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">



    <!-- Fast&Yumicon -->
<link href="public/img/logo1.png" rel="icon">


    <!-- Icons of the site -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Maktabat Stylesheet -->
    <link href="public/lib/animate/animate.min.css" rel="stylesheet">
    <link href="public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="public/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS Stylesheet -->
    <link href="public/css/fastyum.css" rel="stylesheet">
    <link href="public/css/authentification.css" rel="stylesheet">


</head>

<body> 

<br><br><br><br><br>


<section class="container py-5" style="margin-bottom: 500px;">
  <div class="card glass-card mx-auto" style="max-width: 950px;">
    <div class="row g-0 w-100">

      <!-- Colonne image -->
      <div class="col-md-6 d-none d-md-block p-0">
        <img src="public/img/chawarma.jpg" alt="Register Image" class="w-100 img-left">
      </div>

      <!-- Colonne formulaire -->
      <div class="col-md-6 bg-white p-4 d-flex flex-column justify-content-center">
        <img src="public/img/logoprincipale3D.png" alt="Logo" style="width: 50px; margin-bottom: 10px;" class="mx-auto d-block">

        <h4 class="mb-3 text-center text-danger">Créer un compte</h4>
         <?php if (isset($_SESSION['message'])): ?>
            <p style="color: green;"><?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?></p>
        <?php elseif (isset($_SESSION['error'])): ?>
            <p style="color: red;"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
        <?php endif; ?>

        <form method="POST" action="index.php?page=register_user">
           <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
          <div class="row">
            <div class="col-md-6 mb-2">
              <label for="username" class="form-label small">Nom d'utilisateur</label>
              <input type="text" class="form-control form-control-sm" id="username" name="username" required>
            </div>

            <div class="col-md-6 mb-2">
              <label for="telephone" class="form-label small">Téléphone</label>
              <input type="text" class="form-control form-control-sm" id="telephone" name="telephone" required>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-2">
              <label for="prenom" class="form-label small">Prénom</label>
              <input type="text" class="form-control form-control-sm" id="prenom" name="prenom" required>
            </div>

            <div class="col-md-6 mb-2">
              <label for="nom" class="form-label small">Nom</label>
              <input type="text" class="form-control form-control-sm" id="nom" name="nom" required>
            </div>
          </div>

          <div class="mb-2">
            <label for="email" class="form-label small">Email</label>
            <input type="email" class="form-control form-control-sm" id="email" name="email" required>
          </div>

          <div class="mb-2">
            <label for="adresse" class="form-label small">Adresse</label>
            <input type="text" class="form-control form-control-sm" id="adresse" name="adresse" required>
          </div>

          <div class="mb-2">
            <label for="password" class="form-label small">Mot de passe</label>
            <input type="password" class="form-control form-control-sm" id="password" name="password" required>
          </div>

          <div class="mb-3">
            <label for="confirm_password" class="form-label small">Confirmer le mot de passe</label>
            <input type="password" class="form-control form-control-sm" id="confirm_password" name="password_confirm" required>
          </div>

          <button type="submit" class="btn btn-danger w-100 rounded-pill btn-sm">S'inscrire</button>

          <p class="mt-3 text-center small">Déjà inscrit ?
            <a href="index.php?page=connexion" class="text-decoration-none text-warning fw-bold">Se connecter</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</section>








































    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/lib/wow/wow.min.js"></script>

    <script src="public/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Javascript -->
    <script src="public/js/main.js"></script>











</body>

</html>
<?php include 'view/includes/footer.php'; ?>