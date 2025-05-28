
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







<section class="container py-5">
  <div class="card glass-card mx-auto overflow-hidden" style="max-width: 750px;">
    <div class="row g-0 w-100">
      
      <!-- Colonne image -->
      <div class="col-md-6 d-none d-md-block p-0">
        <img src="public/img/chawarma.jpg" alt="connexion Image" class="w-100 img-left">
      </div>

      <!-- Colonne formulaire -->
      <div class="col-md-6 bg-white p-4 d-flex flex-column justify-content-center">
         <img src="public/img/logoprincipale3D.png" alt="Logo" style="width: 50px; margin-bottom: 10px;" class="mx-auto d-block">
        
        <h4 class="mb-4 text-center text-danger">Connexion</h4>
        <?php if (isset($_SESSION['message'])): ?>
        <p style="color: green;"><?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?></p>
        <?php elseif (isset($_SESSION['error'])): ?>
            <p style="color: red;"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
        <?php endif; ?>

        
        <form method="POST" action="index.php?page=connexion">
           <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
          <div class="form-floating mb-3">
            <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Email" required>
            <label for="email">Votre Email</label>
          </div>

          <div class="form-floating mb-3">
            <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Mot de passe" required>
            <label for="password">Mot de passe</label>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="remember" />
              <label class="form-check-label small" for="remember">Se souvenir de moi</label>
            </div>
            <a href="#" class="text-decoration-none small text-danger">Mot de passe oublié ?</a>
          </div>

          <button type="submit" class="btn btn-danger w-100 rounded-pill btn-sm">Se connecter</button>

          <p class="mt-3 text-center small">Pas encore inscrit ?
            <a href="index.php?page=register_user" class="text-decoration-none text-warning fw-bold">Créer un compte</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</section>
 <br><br><br>







































    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/lib/wow/wow.min.js"></script>

    <script src="public/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Javascript -->
    <script src="public/js/main.js"></script>











</body>

</html>
