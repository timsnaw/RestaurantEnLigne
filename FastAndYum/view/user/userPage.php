<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Utilisateur</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
<!-- sidebaricon -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
 
    <!-- Favicon -->
    <link href="public/img/logo1.png" rel="icon">


    <!-- Libraries -->
    <link href="public/lib/animate/animate.min.css" rel="stylesheet">
    <link href="public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="public/css/fastyum.css" rel="stylesheet">
    <link href="public/css/user/userPage.css" rel="stylesheet"> 
  
</head>
<body>
  <div class="menu">
    <a href="index.php" class="logo-link" title="Fast&Yum Accueil">
      <img src="public/img/logo1.png" alt="Logo Fast&Yum" />
      <span>Fast&amp;Yum</span>
    </a>

    <ul>
      <li><a href="index.php?page=utilisateur_info" target="content-frame">Informations utilisateur</a></li>
      <li><a href="index.php?page=commande_user_info" target="content-frame">Mes commandes</a></li>
    </ul>

    <a href="index.php?page=logout_user" class="logout-btn">Déconnecter</a>
  </div>

  <div class="content">
    <iframe name="content-frame" src="index.php?page=utilisateur_info"></iframe>
  </div>
</body>
</html>
