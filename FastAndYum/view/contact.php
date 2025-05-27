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


 <!-- Premier partie Start -->
    <div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="public/img/contactez.jpg" alt="Image" width="200px">
                      <img src="public/img/logoprincipale3D.png" class="animated-logo" alt="Logo Fast&Yum">

                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-lg-7">
                                    <h5 class="display-2 mb-5 animated slideInDown">
                                        <font color="white">
                                            Contactez-Nous </font>

                                    </h5>

                                    <a href="index.php?page=apropos" class="btn py-sm-2 px-sm-4 me-2"
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
                                            style="font-size: 1.8rem; color: orange;">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                        <a href="" target="_blank"
                                            style="font-size: 1.8rem; color: orange;">
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

    <!-- Contact Start -->
    <div class="container-xxl py-6">
        <div class="container">
            <div class=" text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <h1 class="display-5 mb-3"><FONT color="brown">Contactez-nous</FONT></h1>
                
            </div>
            <div class="row g-5 justify-content-center">
                <div class="col-lg-5 col-md-12 wow fadeInUp" data-wow-delay="0.1s">
  <div class="bg-image-contact text-white d-flex flex-column justify-content-center h-100 p-5">
                        <h5 class="text-white">Appelle-nous</h5>
                        <p class="mb-5"><i class="fa fa-phone-alt me-3"></i>+212 707070707</p>
                        <h5 class="text-white">Gmail</h5>
                        <p class="mb-5"><i class="fa fa-envelope me-3"></i>fastandyum@gmail.com</p>
                        <h5 class="text-white">Address</h5>
                        <p class="mb-5"><i class="fa fa-map-marker-alt me-3"></i>123 Fast&Yum, Errachidia, Maroc</p>
                        <h5 class="text-white">Suivez-nous</h5>
                        <div class="d-flex pt-2">
                           
                            <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i class="fab fa-facebook-f"></i></a> 
                           
                            <a class="btn btn-square btn-outline-light rounded-circle me-0" href=""><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-12 wow fadeInUp" data-wow-delay="0.5s">
                    <p class="mb-4">En attendant, vous pouvez nous joindre par téléphone, email ou via nos réseaux sociaux.
Merci de votre compréhension et à très bientôt chez <font color="orange"><strong>Fast&Yum</strong></font> !</p>
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" placeholder="Your Name">
                                    <label for="name">Votre nom</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" placeholder="Your Email">
                                    <label for="email">Votre Email</label>
                                </div>
                            </div>
                            
                            
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Leave a message here" id="message" style="height: 200px"></textarea>
                                    <label for="message">Message</label>
                                </div>
                            </div>
                            <div class="col-12">
                               <button id="whatsappBtn" class="btn btn-primary rounded-pill py-3 px-5" type="button">Envoyer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

<br><br>
    <!-- Google Map Start -->
   <div class="container-xl py-4 ">
  <div class="row align-items-stretch g-0">
    
    <!-- Left: Info Section -->
    <div class="col-md-6 d-flex align-items-center bg-light p-4 wow fadeInUp"  data-wow-delay="0.1s" style="height: 300px;">
      <div>
        <h5 class="mb-3">Informations de Contact</h5>
        <p><strong>Adresse :</strong> Errachidia, Maroc</p>
        <p><strong>Téléphone :</strong> +212 7 07 07 07 07</p>
        <p><strong>Email :</strong> fastandyum@gmail.com</p>
      </div>
    </div>

    <!-- Right: Google Map -->
    <div class="col-md-6 wow fadeInUp"  data-wow-delay="0.2s">
      <iframe class="w-100" style="height: 300px; border:0;"
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3382.702390168!2d-4.42663!3d31.9314!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd9f7b7b1f0e5a9d%3A0x123456789abcdef!2sErrachidia%2C%20Maroc!5e0!3m2!1sfr!2sma!4v1603794290143!5m2!1sfr!2sma"
        allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
    </div>

  </div>
</div>


    <!-- Google Map End -->

<br><br>
    
  


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/lib/wow/wow.min.js"></script>

    <script src="public/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Javascript -->
    <script src="public/js/main.js"></script>
    <script src="public/js/contact.js"></script>




</body>

</html>
<?php include 'includes/footer.php'; ?>
