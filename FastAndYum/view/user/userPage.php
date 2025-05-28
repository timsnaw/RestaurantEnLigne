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
    <link href="/FastAndYumProject/FastAndYum/public/img/logo1.png" rel="icon">


    <!-- Libraries -->
    <link href="/FastAndYumProject/FastAndYum/public/lib/animate/animate.min.css" rel="stylesheet">
    <link href="/FastAndYumProject/FastAndYum/public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="/FastAndYumProject/FastAndYum/public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/FastAndYumProject/FastAndYum/public/css/fastyum.css" rel="stylesheet">
    <link href="/fastandyam/FastAndYum/public/css/user/userPage.css" rel="stylesheet"> 
  
</head>
<body>
  <div class="menu">
    <a href="index.php" class="logo-link" title="Fast&Yum Accueil">
      <img src="/FastAndYumProject/FastAndYum/public/img/logo1.png" alt="Logo Fast&Yum" />
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
