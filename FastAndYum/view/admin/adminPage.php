<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Administration</title>

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
    <link href="/fastandyam/FastAndYum/public/css/admin.css" rel="stylesheet"> 
</head>
<body class="bg-light">

  <div class="container-fluid">
    <div class="row min-vh-100">
      <!-- Sidebar -->
      <div class="col-md-3 col-lg-2 bg-dark text-white d-flex flex-column p-3">
        <div class="text-center mb-4">
  <a href="index.php?page=statistique" target="content-frame" class="d-flex flex-column align-items-center text-decoration-none text-white">
   <img src="/FastAndYumProject/FastAndYum/public/img/logo1.png"
     alt="Logo"
     class="mb-2 shadow logo-img"
     style="width: 80px; height: 80px;">
    <h4 class="text-warning m-0"> Administration</h4>
  </a>
</div>


        <ul class="nav nav-pills flex-column mb-auto">
          <li class="nav-item">
            <a href="index.php?page=admin_info" target="content-frame" class="nav-link text-white"><i class="bi bi-person-badge"></i> Admin Info</a>
          </li>
          <li>
            <a href="index.php?page=user_info" target="content-frame" class="nav-link text-white"><i class="bi bi-people"></i> Utilisateurs</a>
          </li>
          <li>
            <a href="index.php?page=categorie_info" target="content-frame" class="nav-link text-white"><i class="bi bi-tags"></i> Catégories</a>
          </li>
          <li>
            <a href="index.php?page=commandes_info" target="content-frame" class="nav-link text-white"><i class="bi bi-bag"></i> Commandes</a>
          </li>
          <li>
            <a href="index.php?page=plats" target="content-frame" class="nav-link text-white"><i class="bi bi-egg-fried"></i> Plats</a>
          </li>
          <li>
            <a href="index.php?page=promotion_info" target="content-frame" class="nav-link text-white"><i class="bi bi-percent"></i> Promotions</a>
          </li>
        </ul>

        <a href="index.php?page=logout" class="btn btn-danger mt-auto w-100"><i class="bi bi-box-arrow-right"></i> Déconnecter</a>
      </div>

      <!-- Main content -->
      <div class="col-md-9 col-lg-10 p-4">
        <iframe name="content-frame" src="index.php?page=statistique" class="w-100" style="height: 90vh; border: none; border-radius: 10px;"></iframe>
      </div>
    </div>
  </div>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/FastAndYumProject/FastAndYum/public/lib/wow/wow.min.js"></script>

    <script src="/FastAndYumProject/FastAndYum/public/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Javascript -->
    <script src="/FastAndYumProject/FastAndYum/public/js/main.js"></script>











</body>
</html>
