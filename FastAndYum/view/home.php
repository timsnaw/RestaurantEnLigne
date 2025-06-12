<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Fast&Yum</title>
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

</head>

<body>



    <!-- Premier partie Start -->
    <div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="public/img/burgerlast.jpg" alt="Image">

                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-lg-7">
                                    <h5 class="display-2 mb-5 animated slideInDown">Parce que <font color="orange">
                                            rapide</font>
                                        peut aussi être <font color="orange">délicieux</font>
                                    </h5>

                                    <a href="index.php?page=apropos" class="btn py-sm-2 px-sm-4 me-2"
                                        style="border: 2px solid red; color: red; border-radius: 8px; background-color: transparent; font-weight: bold;"
                                        onmouseover="this.style.backgroundColor='red'; this.style.color='white';"
                                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='red';">
                                        Afficher plus
                                    </a>

                                    <a href="index.php?page=menu#tab-12" class="btn py-sm-2 px-sm-4"
                                        style="border: 2px solid red; background-color: red; color: white; border-radius: 8px; font-weight: bold;"
                                        onmouseover="this.style.backgroundColor='transparent'; this.style.color='red';"
                                        onmouseout="this.style.backgroundColor='red'; this.style.color='white';">
                                        Passer la commande
                                    </a>
                                    <div class="mt-4">
                                        <a href="https://www.instagram.com" target="_blank" class="me-3"
                                            style="font-size: 1.8rem; color: #E4405F;">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                        <a href="https://www.facebook.com" target="_blank"
                                            style="font-size: 1.8rem; color: #E4405F;">
                                            <i class="fab fa-facebook"></i>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <img class="w-100" src="public/img/pizzalast.jpg" alt="Image">
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-lg-7">
                                    <h1 class="display-2 mb-5 animated slideInDown">
                                        <font color="orange">Fast&Yum</font>
                                        <br>
                                        <font color="white"> Le plaisir express</font>
                                    </h1>


                                    <a href="index.php?page=apropos" class="btn py-sm-2 px-sm-4 me-2"
                                        style="border: 2px solid red; color: red; border-radius: 8px; background-color: transparent; font-weight: bold;"
                                        onmouseover="this.style.backgroundColor='red'; this.style.color='white';"
                                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='red';">
                                        Afficher plus
                                    </a>

                                    <a href="index.php?page=menu#tab-12" class="btn py-sm-2 px-sm-4"
                                        style="border: 2px solid red; background-color: red; color: white; border-radius: 8px; font-weight: bold;"
                                        onmouseover="this.style.backgroundColor='transparent'; this.style.color='red';"
                                        onmouseout="this.style.backgroundColor='red'; this.style.color='white';">
                                        Passer la commande
                                    </a>
                                    <div class="mt-4">
                                        <a href="https://www.instagram.com" target="_blank" class="me-3"
                                            style="font-size: 1.8rem; color: #E4405F;">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                        <a href="https://www.facebook.com" target="_blank"
                                            style="font-size: 1.8rem; color: #E4405F;">
                                            <i class="fab fa-facebook"></i>
                                        </a>
                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
              
            </button>
        </div>
    </div>
    <!-- premier partie End -->




    <!-- Categories Start -->
    <div class="container-fluid py-5" style="background: linear-gradient(135deg, #f9f7f1, #e6d9b8);">
        <section class="section2">
            <h2 class="text-center mb-5 text-uppercase fw-bold wow fadeIn" data-wow-delay="0.1s" style="color:#5b4b2d;">Catégories</h2>
            <div class="row justify-content-center g-4">
                <?php foreach ($categories as $key => $categorie): ?>
                    <div class="col-6 col-lg-2 text-center wow fadeInUp" data-wow-delay="0.<?php echo ($key + 1); ?>s">
                        <a href="index.php?page=menu#tab-<?php echo $categorie['categorie_id']; ?>" class="d-inline-block circle-card">
                            <img src="public/img/<?php echo htmlspecialchars($categorie['image_categorie']); ?>" alt="<?php echo htmlspecialchars($categorie['nom_categorie']); ?>">
                        </a>
                        <h5 class="mt-3 text-warning fw-semibold"><?php echo htmlspecialchars($categorie['nom_categorie']); ?></h5>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center mt-5">
                <a href="index.php?page=menu#tab-12">
                    <button class="btn btn-warning btn-lg rounded shadow-sm">Voir plus de produits</button>
                </a>
            </div>
        </section>
    </div>
    <!-- Categories End -->





    <br><br><br><br>

    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="">
                        <img class="img-fluid w-100" src="public/img/pizza2-Photoroom.png"
                            style="animation: rotateImage 10s infinite linear;">
                    </div>


                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-5 mb-4">Chez Fast & Yum,
                    </h1>
                    <p class="mb-4">La pizza fait partie d’un mode de vie équilibré . <br> On croit qu’une bonne pizza
                        peut être à la fois savoureuse et nutritive. Grâce à des ingrédients frais et des recettes bien
                        pensées, nos pizzas vous offrent le plaisir sans compromis sur l’équilibre. Manger vite peut
                        aussi rimer avec manger bien.

                    </p>

                    <a class="btn btn-primary py-3 px-5 mt-3" href="index.php?page=apropos"
                        style="background-color: orange; color: white; border: 2px solid orange; border-radius: 15px; transition: all 0.3s ease;"
                        onmouseover="this.style.backgroundColor='white'; this.style.color='orange'; this.style.borderColor='orange';"
                        onmouseout="this.style.backgroundColor='orange'; this.style.color='white'; this.style.borderColor='orange';">
                        Plus d'infos
                    </a>


                </div>
            </div>
        </div>
    </div>
    <!-- About End -->
     <br><br><br><br><br>


<!-- Style cercle -->
<style>

</style>

  <!-- Section Livraison stylisée -->
<section class="py-5" style="background: linear-gradient(135deg, #fef9f1, #fff1d0);">
  <div class="container">
    
    
    <div class="row text-center mb-5 wow fadeIn" data-wow-delay="0.1s">
      <div class="col-md-4">
        <div class="p-4 wow fadeInUp" data-wow-delay="0.1s">
          <div class="mx-auto mb-3 bg-warning rounded-circle d-flex justify-content-center align-items-center" style="width: 70px; height: 70px;">
            <i class="fa fa-utensils fa-lg text-white"></i>
          </div>
          <h5 class="fw-bold mt-3">Choisissez Vos Repas</h5>
          <p>Parcourez notre menu et ajoutez vos plats préférés au panier.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 wow fadeInUp" data-wow-delay="0.2s">
          <div class="mx-auto mb-3 bg-warning rounded-circle d-flex justify-content-center align-items-center" style="width: 70px; height: 70px;">
            <i class="fa fa-truck fa-lg text-white"></i>
          </div>
          <h5 class="fw-bold mt-3">Suivez Votre Commande</h5>
          <p>Obtenez des mises à jour en temps réel jusqu'à votre porte.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 wow fadeInUp" data-wow-delay="0.3s">
          <div class="mx-auto mb-3 bg-warning rounded-circle d-flex justify-content-center align-items-center" style="width: 70px; height: 70px;">
            <i class="fa fa-box-open fa-lg text-white"></i>
          </div>
          <h5 class="fw-bold mt-3">Récupérez La Commande</h5>
          <p>Profitez de vos plats chauds, prêts à être dégustés chez vous !</p>
        </div>
      </div>
    </div>

    <section class="py-5" style="background-color: #fff7ec; border-radius: 20px;">
  <div class="container">
    <div class="row g-4 justify-content-center align-items-center">

      <!-- Bloc  -->
      <div class="col-md-6 wow fadeInUp" data-wow-delay="0.1s">
        <div class="p-4 bg-light rounded-4 shadow-sm text-center" style="border-radius: 20px;">
          <img src="public/img/fastdelevry.png" alt="Livraison rapide"
               class="img-fluid rounded-4" style="max-height: 220px; object-fit: contain; border-radius: 20px;">
        </div>
      </div>

      <!-- Bloc texte  -->
      <div class="col-md-6 wow fadeInUp" data-wow-delay="0.2">
        <div class="p-4 rounded-4 shadow-sm text-white" style="background-color: #ff9f43; border-radius: 20px;">
          <h3 class="fw-bold mb-3" style="font-family: 'Segoe UI', sans-serif;">Livraison rapide, goût intense</h3>
          <ul class="list-unstyled fs-5" style="line-height: 1.8;">
            <li>🚀 Le goût du bonheur arrive à toute vitesse !</li>
            <li>🍔 Fast & Yum : burgers livrés avec le sourire.</li>
            <li>🛵 Envie d’un festin ? On vous l’apporte !</li>
            <li>🎯 Ne bougez pas, on s’occupe de vous régaler.</li>
          </ul>
        </div>
      </div>

    </div>
  </div>
</section>

  </div>
</section>

    <br><br><br><br><br>


    <!--promo-->
    <section class="promo-section">
        <a href="index.php?page=promotions" class="promo-button">Order Now</a>
    </section>
    <!--end promo-->

    <br><br><br>



    <!-- AVIS -->
<div class="container-fluid py-6 mb-5"
     style="background: linear-gradient(to bottom, rgba(255, 165, 0, 0.4), rgba(255, 255, 255, 0.8));">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 500px;">
            <h1 class="display-5 mb-3">
                <font color="white">Les avis de nos clients</font>
            </h1>
        </div>
        <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
            <?php foreach ($avis as $review): ?>
                <div class="testimonial-item bg-white p-5 mt-4">
                    <p class="mb-4"><?php echo htmlspecialchars($review['commentaire']); ?></p>
                    <div class="d-flex align-items-center">
                        <img class="flex-shrink-0 rounded-circle" 
                             src="public/img/<?php echo htmlspecialchars($review['image_client']); ?>" 
                             alt="<?php echo htmlspecialchars($review['prenom'] . ' ' . $review['nom']); ?>">
                        <div class="ms-3">
                            <h5 class="mb-1"><?php echo htmlspecialchars($review['prenom'] . ' ' . $review['nom']); ?></h5>
                            <div class="product-rating text-warning">
                                <?php
                                $rating = $review['note'] ?: 5;
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($rating >= $i) {
                                        echo '<i class="fas fa-star" style="font-size: 12px;"></i>';
                                    } elseif ($rating >= $i - 0.5) {
                                        echo '<i class="fas fa-star-half-alt" style="font-size: 12px;"></i>';
                                    } else {
                                        echo '<i class="far fa-star" style="font-size: 12px;"></i>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- Avis End -->







    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/lib/wow/wow.min.js"></script>

    <script src="public/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Javascript -->
    <script src="public/js/main.js"></script>
</body>
</html>
<?php include 'includes/footer.php'; ?>