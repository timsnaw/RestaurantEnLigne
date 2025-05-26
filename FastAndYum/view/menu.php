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



    <!-- Navbar Start -->


    <!-- Navbar End -->



    <!-- Premier partie Start -->
    <div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="/FastAndYumProject/FastAndYum/public/img/NosPlatsss.jpg" alt="Image"
                        width="200px">

                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-lg-7">
                                    <h5 class="display-2 mb-5 animated slideInDown">
                                        <font color="orange">
                                            Nos Plats </font>

                                    </h5>

                                    <a href="index.php?url=apropos" class="btn py-sm-2 px-sm-4 me-2"
                                        style="border: 2px solid red; color: red; border-radius: 8px; background-color: transparent; font-weight: bold;"
                                        onmouseover="this.style.backgroundColor='red'; this.style.color='white';"
                                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='red';">
                                        Afficher plus
                                    </a>

                                    <a href="index.php?url=menu" class="btn py-sm-2 px-sm-4"
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

    <div class=" text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
        <h1 class="display-5 mb-3">
            <FONT color="brown">Menu</FONT>
        </h1>

    </div>
    <!-- Products Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <!-- Navigation Tabs -->
            <div class="row g-0 gx-5 align-items-end">
                <div class="col-12 mx-auto text-center wow slideInRight" data-wow-delay="0.1s">
                    <ul class="nav flex-wrap justify-content-center gap-5 mb-5 p-0">
                        <li class="nav-item">
                            <a class="btn-orange border-2  active " data-bs-toggle="pill" href="#tab-1">Pizzas</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-orange border-2" data-bs-toggle="pill" href="#tab-2">Tacos</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-orange border-2" data-bs-toggle="pill" href="#tab-3">Burgers</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-orange border-2" data-bs-toggle="pill" href="#tab-4">Salades</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-orange border-2" data-bs-toggle="pill" href="#tab-5">Jus et Cocktails</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="tab-content">
                <!-- PIZZAS -->
                <div id="tab-1" class="tab-pane fade show active">
                    <div class="row g-4">
                        <!-- Product 1 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/STAR BACON.jpg" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">STAR BACON</div>
                                    <div class="quantity d-flex align-items-center" style="gap: 4px;">
                                        <button class="btn btn-outline-secondary btn-sm px-1 py-0"
                                            style="font-size: 10px;">-</button>
                                        <input type="text" name="quantity" value="1" readonly
                                            style="width: 30px; height: 24px; text-align: center; font-size: 12px; border: 1px solid #ccc; border-radius: 4px;">
                                        <button class="btn btn-outline-secondary btn-sm px-1 py-0"
                                            style="font-size: 10px;">+</button>
                                    </div>
                                    <div class="product-info">
                                        <div class="product-price">19.00 MAD</div>

                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!--endProduit 1-->
                        <!-- Product 2 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/BUFFALO.jpg" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">BUFFALO</div>
                                    <div class="product-info">
                                        <div class="product-price">19.00 MAD</div>

                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!--endProduit 2-->
                        <!-- Product 3 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/VÉGÉTARIENNE.jpg" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">VÉGÉTARIENNE</div>
                                    <div class="product-info">
                                        <div class="product-price">19.00 MAD</div>

                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!--endProduit 3-->
                        <!-- Product 4 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/LA REINE.png" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">LA REINE</div>
                                    <div class="product-info">
                                        <div class="product-price">19.00 MAD</div>

                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!--endProduit 4-->
                        <!-- Product 5 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/QUATRE FROMAGE.png" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">QUATRE FROMAGE</div>
                                    <div class="product-info">
                                        <div class="product-price">19.00 MAD</div>

                                        <div class="product-rating d-flex">
                                            <div class="product-rating text-warning">
                                                <div class="product-rating text-warning">
                                                    <i class="fas fa-star" style="font-size: 12px;"></i>
                                                    <i class="fas fa-star" style="font-size: 12px;"></i>
                                                    <i class="fas fa-star" style="font-size: 12px;"></i>
                                                    <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                                    <i class="far fa-star" style="font-size: 12px;"></i>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!--endProduit 5-->
                        <!-- Product 6 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/MARGARITA.png" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">MARGARITA</div>
                                    <div class="product-info">
                                        <div class="product-price">19.00 MAD</div>

                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!--endProduit 6-->
                        <!-- Product 7 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/LA FROMAGÈRE.jpg" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">LA FROMAGÈRE</div>
                                    <div class="product-info">
                                        <div class="product-price">19.00 MAD</div>

                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!--endProduit 7-->
                        <!-- Product 8 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/LA QATARIE.jpg" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">LA QATARIE</div>
                                    <div class="product-info">
                                        <div class="product-price">19.00 MAD</div>

                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!--endProduit 8-->
                    </div>
                </div>

                <!-- BURGERS -->
                <div id="tab-3" class="tab-pane fade">
                    <div class="row g-4">
                        <!-- B 1 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/Double Beef Burger.png"
                                        alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">Double Beef </div>
                                    <div class="product-info">
                                        <div class="product-price">25.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!--END B 1-->
                        <!-- B2 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/Double GRILL Burger.png"
                                        alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">Double GRILL </div>
                                    <div class="product-info">
                                        <div class="product-price">25.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!--END B 2-->
                        <!-- B 3 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/Big Flamme Burger.jpg"
                                        alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">Big Flamme Burger</div>
                                    <div class="product-info">
                                        <div class="product-price">25.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!--END B 3-->
                        <!-- B 4 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/Double cheese burger.png"
                                        alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">Double cheese </div>
                                    <div class="product-info">
                                        <div class="product-price">25.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!--END B 4-->
                        <!-- B 5 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/Touareg.jpg" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">Touareg</div>
                                    <div class="product-info">
                                        <div class="product-price">25.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!--END B 5-->
                        <!-- B 6 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/Double Chicken Burger.jpg"
                                        alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2"> Double Chicken </div>
                                    <div class="product-info">
                                        <div class="product-price">25.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!--END B 6-->
                        <!-- B 7 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/Chicken Burger.jpg" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">Chicken Burger</div>
                                    <div class="product-info">
                                        <div class="product-price">25.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!--END B 7-->
                        <!-- B 8 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/Double FishBurger.jpg"
                                        alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">Double FishBurger</div>
                                    <div class="product-info">
                                        <div class="product-price">25.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!--END B 8-->
                    </div>
                </div>

                <!-- TACOSES -->
                <div id="tab-2" class="tab-pane fade">
                    <div class="row g-4">
                        <!-- TACOS 1 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/Tacos Buffalo.jpg" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">Tacos Buffalo</div>
                                    <div class="product-info">
                                        <div class="product-price">30.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!-- END TACOS  1 -->
                        <!--  TACOS 2 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/Big Yummy.jpg" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">Big Yummy</div>
                                    <div class="product-info">
                                        <div class="product-price">30.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!-- END  TACOS 2-->
                        <!--  TACOS 3 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/Tacos farmer.jpg" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">Tacos farmer</div>
                                    <div class="product-info">
                                        <div class="product-price">30.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!-- END  TACOS 3 -->
                        <!--  TACOS 4 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/Monster.jpg" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">Monster</div>
                                    <div class="product-info">
                                        <div class="product-price">30.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!-- END  TACOS 4 -->
                        <!--  TACOS 5 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/Tacos Fromagaire.jpg" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">Tacos Fromagaire</div>
                                    <div class="product-info">
                                        <div class="product-price">30.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!-- END TACOS 5 -->
                        <!-- TACOS 6 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/Tacos Fish.jpg" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">Tacos Fish</div>
                                    <div class="product-info">
                                        <div class="product-price">30.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!-- END TACOS 6 -->
                        <!-- TACOS 7 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/Tacos Chicken.jpg" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">Tacos Chicken</div>
                                    <div class="product-info">
                                        <div class="product-price">30.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!-- END TACOS 7-->
                        <!--  TACOS 8 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/Tacos Chili.jpg" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">Tacos Chili</div>
                                    <div class="product-info">
                                        <div class="product-price">30.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!-- END TACOS 8 -->

                    </div>
                </div>

                <!-- SALADES -->
                <div id="tab-4" class="tab-pane fade">
                    <div class="row g-4">
                        <!-- SALADE 1-->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/Salade Marocaine.png" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">Salade Marocaine</div>
                                    <div class="product-info">
                                        <div class="product-price">18.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!-- END-SALADE 1-->
                        <!-- SALADE 2-->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/Salade Niçoise.jpg" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">Salade Niçoise</div>
                                    <div class="product-info">
                                        <div class="product-price">18.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!-- END-SALADE 2-->
                        <!-- SALADE 3-->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/Salade varieé.jpg" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">Salade varieé</div>
                                    <div class="product-info">
                                        <div class="product-price">18.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!-- END-SALADE 3-->
                        <!-- SALADE 4-->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/salade Pates froide.jpg"
                                        alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">Salade Pates froide</div>
                                    <div class="product-info">
                                        <div class="product-price">18.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!-- END-SALADE 4-->

                        <!-- SALADE 5-->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/Salade Crispy.jpg" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">Salade Crispy</div>
                                    <div class="product-info">
                                        <div class="product-price">18.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!-- END-SALADE 5-->

                    </div>
                </div>
                <!-- Jus  -->
                <div id="tab-5" class="tab-pane fade">
                    <div class="row g-4">
                        <!-- Jus 1 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/menu//Milkshaky Shaky.jpg" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">Milkshaky Shaky</div>
                                    <div class="product-info">
                                        <div class="product-price">30.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!-- END Jus 1 -->
                        <!-- Jus 2 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/Mojito citron.jpg" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">Mojito citron</div>
                                    <div class="product-info">
                                        <div class="product-price">30.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!-- END Jus 2-->
                        <!-- Jus 3 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/Mojito Passion.jpg" alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">Mojito Passion</div>
                                    <div class="product-info">
                                        <div class="product-price">30.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!-- END Jus 3 -->

                        <!-- Jus 4 -->
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                            <div class="product-item">
                                <div class="position-relative bg-light overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="/FastAndYumProject/FastAndYum/public/img/Menu/Smoothie Tropical.jpg"
                                        alt="">
                                </div>
                                <div class="text-center p-4">
                                    <div class="text-start fw-bold mb-2">Smoothie Tropical</div>
                                    <div class="product-info">
                                        <div class="product-price">30.00 MAD</div>
                                        <div class="product-rating text-warning">
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                            <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                            <i class="far fa-star" style="font-size: 12px;"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="w-50 text-center border-end py-2">
                                        <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Voir</a>
                                    </small>
                                    <small class="w-50 text-center py-2">
                                        <a class="text-body" href=""><i
                                                class="fa fa-shopping-bag text-primary me-2"></i>Ajouter</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!-- End Jus 4 -->
                    </div>
                </div>
            </div>
            <!-- End Tab Content -->
        </div>
    </div>
    <!-- Products End -->
    <br><br>
    <!--promo-->
    <section class="promo-section">
        <a href="index.php?url=promotions" class="promo-button">Order Now</a>
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
                <div class="testimonial-item bg-white p-5 mt-4">
                    <p class="mb-4">"Service exceptionnel ! Je recommande vivement."</p>
                    <div class="d-flex align-items-center">
                        <img class="flex-shrink-0 rounded-circle" src="/FastAndYumProject/FastAndYum/public/img/1.jpg"
                            alt="Karim El Amrani">
                        <div class="ms-3">
                            <h5 class="mb-1">Karim El Amrani</h5>
                            <span>Entrepreneur - Casablanca</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item position-relative bg-white p-5 mt-4">
                    <p class="mb-4">"Toujours délicieux et rapide !"</p>
                    <div class="d-flex align-items-center">
                        <img class="flex-shrink-0 rounded-circle" src="/FastAndYumProject/FastAndYum/public/img/111.jpg"
                            alt="Mohamed Benjelloun">
                        <div class="ms-3">
                            <h5 class="mb-1">Mohamed Benjelloun</h5>
                            <span>Directeur Marketing - Rabat</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item position-relative bg-white p-5 mt-4">
                    <p class="mb-4"><br>"Frites parfaites à chaque fois"</p>
                    <div class="d-flex align-items-center">
                        <img class="flex-shrink-0 rounded-circle"
                            src="/FastAndYumProject/FastAndYum/public/img/1111.jpg" alt="Mehdi Alaoui">
                        <div class="ms-3">
                            <h5 class="mb-1">Mehdi Alaoui</h5>
                            <span>Etudiant - Marrakech</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item position-relative bg-white p-5 mt-4">
                    <p class="mb-4">"Service souriant et ultra rapide. 10/10 !"</p>
                    <div class="d-flex align-items-center">
                        <img class="flex-shrink-0 rounded-circle" src="/FastAndYumProject/FastAndYum/public/img/2.jpg"
                            alt="Amina Belhaj">
                        <div class="ms-3">
                            <h5 class="mb-1">Amina Belhaj</h5>
                            <span>Architecte d'intérieur - Tanger</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Avis End -->


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
<?php include 'includes/footer.php'; ?>