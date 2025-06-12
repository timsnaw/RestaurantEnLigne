<?php include 'includes/header.php'; ?>
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

</head>

<body>



    <!-- Navbar Start -->

    <!-- Navbar End -->


    <!-- Premier partie Start -->
    <div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.1s">

        <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="public/img/PROMOSssss.jpg" alt="Image" width="200px">

                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-lg-7">

                                    <br><br><br><br><br><br><br><br><br><br><br>
                                    <a href="index.php?page=promotions" class="btn py-sm-2 px-sm-4 me-2"
                                        style="border: 2px solid red; color: red; border-radius: 8px; background-color: transparent; font-weight: bold;"
                                        onmouseover="this.style.backgroundColor='red'; this.style.color='white';"
                                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='red';">
                                        Afficher plus
                                    </a>

                                    <a href="index.php?page=menu" class="btn py-sm-2 px-sm-4"
                                        style="border: 2px solid red; background-color: red; color: white; border-radius: 8px; font-weight: bold;"
                                        onmouseover="this.style.backgroundColor='transparent'; this.style.color='red';"
                                        onmouseout="this.style.backgroundColor='red'; this.style.color='white';">
                                        Passer la commande
                                    </a>
                                    <div class="mt-4">
                                        <a href="" target="_blank" class="me-3"
                                            style="font-size: 1.8rem; color: #E4405F;">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                        <a href="" target="_blank" style="font-size: 1.8rem; color: #E4405F;">
                                            <i class="fab fa-facebook"></i>

                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- premier partie End -->


    <!-- Products Start -->
    <div class="container-xxl py-5">
        <div class="container">


            <div class=" text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <h1 class="display-5 mb-3">
                    <FONT color="brown">🔥 Promotions 🔥</FONT>
                </h1>


            </div>
<p class="text-center mb-4 wow fadeInUp" data-wow-delay="0.2s"
   style="max-width: 700px; margin: auto; font-size: 20px; color: #5c4033; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: bold;">
    Chez <span style="color: #FF5722;">Fast&Yum</span>, régalez-vous tout en faisant des économies ! 🍕<br>
    Profitez de <span style="color: green;">nos meilleures offres</span> sur vos plats préférés,  Ne ratez pas cette occasion savoureuse !
</p>



<!-- Promotions Start -->
    <div class="container py-5">
        <h1 class="text-center mb-5">Nos Promotions</h1>
        <div class="row g-4">
            <?php foreach ($products as $product): ?>
                <!-- Product -->
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="product-item">
                        <div class="position-relative bg-light overflow-hidden">
                            <img class="img-fluid w-100" 
                                 src="public/img/<?php echo htmlspecialchars($product['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['titre']); ?>">
                        </div>
                        <div class="text-center p-4">
                            <div class="text-start fw-bold mb-2"><?php echo htmlspecialchars($product['titre']); ?></div>              
                            <div class="product-info">
                                <div class="product-price">
                                    <?php
                                    $prix = $product['prix'];
                                    $discounted_price = $prix * (1 - $product['taux_reduction'] / 100);
                                    ?>
                                    <span style="color: green; font-weight: bold; font-size: 14.5px;">
                                        <?php echo number_format($discounted_price, 2); ?> MAD
                                    </span>
                                    <br>
                                    <span style="text-decoration: line-through; color: orange; font-size: 12px;">
                                        <?php echo number_format($prix, 2); ?> MAD
                                    </span>
                                </div>
                                <div class="product-rating text-warning">
                                    <?php
                                    $rating = $product['average_rating'];
                                    if ($rating === null || $rating == 0) {
                                        $rating = 5;
                                    }
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
                        <div class="d-flex border-top">
                            <small class="w-50 text-center border-end py-2">
                                <a class="text-body" href="index.php?page=details&plat_id=<?php echo htmlspecialchars($product['plat_id']); ?>">
                                    <i class="fa fa-eye text-primary me-2"></i>Voir
                                </a>
                            </small>
                            <small class="w-50 text-center py-2">
                                <a class="text-body" href="index.php?page=panier&action=add&plat_id=<?php echo htmlspecialchars($product['plat_id']); ?>">
                                    <i class="fa fa-shopping-bag text-primary me-2"></i>Ajouter
                                </a>
                            </small>
                        </div>
                    </div>
                </div>
                <!-- End Product -->
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Promotions End -->
            
        </div>
    </div>

    <!-- End Tab Content -->
    </div>
    </div>
    <!-- Products End -->
    <br><br>
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