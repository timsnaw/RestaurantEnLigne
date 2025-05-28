<?php include 'view/includes/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Détails du produit - Fast&Yum</title>



  <!-- Fast&Yumicon -->
  <link href="/FastAndYumProject/FastAndYum/public/img/logo1.png" rel="icon">


  <!-- Icons of the site -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Maktabat Stylesheet -->
  <link href="/FastAndYumProject/FastAndYum/public/lib/animate/animate.min.css" rel="stylesheet">
  <link href="/FastAndYumProject/FastAndYum/public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="/FastAndYumProject/FastAndYum/public/css/bootstrap.min.css" rel="stylesheet">

  <!-- CSS Stylesheet -->
  <link href="/FastAndYumProject/FastAndYum/public/css/fastyum.css" rel="stylesheet">




</head>

<body>
  <br><br><br>
  <!-- Navbar Start -->

  <!-- Navbar End -->
  <div class="container py-5 wow fadeInUp" data-wow-delay="0.1s">
    <form method="POST" action="panier.php">
      <div class="row">
        <div class="col-md-6">
          <img id="mainImage" src="/FastAndYumProject/FastAndYum/public/img/burger.jpg"
            class="product-image wow fadeInUp" data-wow-delay="0.2s" alt="Burger">
          <div class="d-flex mt-3">
            <img src="/FastAndYumProject/FastAndYum/public/img/burger.jpg" class="thumb-img wow fadeInUp"
              data-wow-delay="0.2s" onclick="changeImage(this.src)">
            <img src="/FastAndYumProject/FastAndYum/public/img/burger.jpg" class="thumb-img wow fadeInUp"
              data-wow-delay="0.3s" onclick="changeImage(this.src)">
            <img src="/FastAndYumProject/FastAndYum/public/img/burger.jpg" class="thumb-img wow fadeInUp"
              data-wow-delay="0.4s" onclick="changeImage(this.src)">
          </div>
        </div>
        <div class="col-md-6">
          <h2 class="fw-bold">BIG BURGER</h2>
          <input type="hidden" name="produit" value="BIG BURGER">

          <div class="product-rating text-warning">
            <i class="fas fa-star" style="font-size: 12px;"></i>
            <i class="fas fa-star" style="font-size: 12px;"></i>
            <i class="fas fa-star" style="font-size: 12px;"></i>
            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
            <i class="far fa-star" style="font-size: 12px;"></i>
          </div>

          <p><strong>Catégorie :</strong> BURGER</p>
          <p><strong>Description :</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>

          <p class="price">
            <span class="old-price">
              <i class="fas fa-tag"></i> 50DH
            </span>
            <span class="new-price">
              40DH
            </span>
          </p>
          <input type="hidden" name="prix" value="40">


          <div class="mb-3">
            <strong>Quantité :</strong>
            <div class="d-flex align-items-center quantity-control">
              <button type="button" class="btn-minus" onclick="decreaseQuantity()">-</button>
              <input type="text" name="quantite" id="quantity" value="1" readonly class="form-control mx-2"
                style="width: 50px; text-align: center;">
              <button type="button" class="btn-plus" onclick="increaseQuantity()">+</button>
            </div>
          </div>





          <div class="mt-4 d-flex gap-3">

            <button type="submit" name="action" value="panier" class="btn btn-outline-danger px-4">Ajouter au
              panier</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <br><br><br><br>


  <!-- Categories start -->
  <div class="container-fluid py-5" style="background: linear-gradient(135deg, #f9f7f1, #e6d9b8);">
    <section class="section2">
      <h2 class="text-center mb-5 text-uppercase fw-bold wow fadeIn" data-wow-delay="0.1s" style="color:#5b4b2d;">
        Catégories</h2>

      <div class="row justify-content-center g-4">
        <!-- Tacos -->
        <div class="col-6 col-lg-2 text-center wow fadeInUp" data-wow-delay="0.1s">
          <a href="index.php?url=menu#tab-2" class="d-inline-block circle-card">
            <img src="/FastAndYumProject/FastAndYum/public/img/i146583-tacos-poulet-curry.jpg" alt="Tacos">
          </a>
          <h5 class="mt-3 text-warning fw-semibold">TACOS</h5>
        </div>

        <!-- Burgers -->
        <div class="col-6 col-lg-2 text-center wow fadeInUp" data-wow-delay="0.2s">
          <a href="index.php?url=menu#tab-3" class="d-inline-block circle-card">
            <img src="/FastAndYumProject/FastAndYum/public/img/burger.jpg" alt="Burgers">
          </a>
          <h5 class="mt-3 text-warning fw-semibold">Burgers</h5>
        </div>

        <!-- Pizza -->
        <div class="col-6 col-lg-2 text-center wow fadeInUp" data-wow-delay="0.3s">
          <a href="index.php?url=menu#tab-1" class="d-inline-block circle-card">
            <img src="/FastAndYumProject/FastAndYum/public/img/pizza3.webp" alt="Pizza">
          </a>
          <h5 class="mt-3 text-warning fw-semibold">Pizza’s</h5>
        </div>

        <!-- Salade -->
        <div class="col-6 col-lg-2 text-center wow fadeInUp" data-wow-delay="0.4s">
          <a href="index.php?url=menu#tab-4" class="d-inline-block circle-card">
            <img src="/FastAndYumProject/FastAndYum/public/img/saladenicoise.jpeg" alt="Salade">
          </a>
          <h5 class="mt-3 text-warning fw-semibold">Salade</h5>
        </div>

        <!-- Jus -->
        <div class="col-6 col-lg-2 text-center wow fadeInUp" data-wow-delay="0.5s">
          <a href="index.php?url=menu#tab-5" class="d-inline-block circle-card">
            <img src="/FastAndYumProject/FastAndYum/public/img/Menu/Milkshaky Shaky.jpg" alt="Jus">
          </a>
          <h5 class="mt-3 text-warning fw-semibold">Jus et Cocktails</h5>
        </div>
      </div>

      <div class="text-center mt-5">
        <a href="index.php?url=menu">
          <button class="btn btn-warning btn-lg rounded shadow-sm">Voir plus de produits</button>
        </a>
      </div>
    </section>
  </div>
  <!-- Categories end -->


  <br>
  <!--footer-->

  <!-- Footer End -->




  <!-- JavaScript Libraries -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/FastAndYumProject/FastAndYum/public/lib/wow/wow.min.js"></script>

  <script src="/FastAndYumProject/FastAndYum/public/lib/owlcarousel/owl.carousel.min.js"></script>

  <!-- Javascript -->
  <script src="/FastAndYumProject/FastAndYum/public/js/main.js"></script>

</body>

</html>

<?php include 'view/includes/footer.php'; ?>