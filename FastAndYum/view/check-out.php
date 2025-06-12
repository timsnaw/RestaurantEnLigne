<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Finaliser la commande</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Icone -->
    <link href="/FastAndYumProject/FastAndYum/public/img/logo1.png" rel="icon">

    <!-- Maktabat Stylesheet -->
    <link href="/FastAndYumProject/FastAndYum/public/lib/animate/animate.min.css" rel="stylesheet">
    <link href="/FastAndYumProject/FastAndYum/public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="/FastAndYumProject/FastAndYum/public/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS Stylesheet -->
    <link href="/FastAndYumProject/FastAndYum/public/css/fastyum.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #fde4e4, #cce0e0);
            font-family: 'Segoe UI', sans-serif;
        }
        .checkout-container {
            margin-top: 60px;
            margin-bottom: 60px;
        }
        .card {
            border-radius: 16px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
        }
        .product-img {
            width: 100px;
            height: auto;
            border-radius: 12px;
        }
        .section-title {
            color: #ff9900;
            font-weight: bold;
        }
        .btn-pay {
            background-color: #17e5d0;
            color: white;
            font-weight: bold;
        }
        .btn-pay:hover {
            background-color: #13c3b2;
        }
        .btn-back {
            background-color: #dc3545;
            color: white;
        }
        .btn-back:hover {
            background-color: #bb2d3b;
        }
        .form-check-input {
            margin-top: 0.3rem;
        }
        /*check out */
        .checkout-body {
    background: linear-gradient(to right, #fddede, #d7f1f9);
    font-family: 'Segoe UI', sans-serif;
}

textarea.form-control {
    resize: none;
}

.card h5 {
    font-size: 1.2rem;
}

    </style>
      <!-- Icons of the site -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<br><br>
<div class="container checkout-container">
    <a href="#" class="text-decoration-none text-warning">&larr; Retour au panier</a>

    <h4 class="my-4 section-title">Finalisation de la commande</h4>

   <form action="traitement_commande.php" method="post">
    <div class="row">
        <!-- Colonne produit -->
        <div class="col-md-8">
            <div class="card d-flex align-items-center flex-row">
                <img src="/FastAndYumProject/FastAndYum/public/img/Menu/STAR BACON.jpg" alt="Pizza Italien" class="product-img me-3">
                <div class="flex-grow-1">
                    <h5 class="mb-1">Pizza italien</h5>
                    <p class="mb-2 text-muted">Extra cheese and topping</p>

                    <!-- Hidden inputs li ytsiftu l PHP -->
                    <input type="hidden" name="produit" value="Pizza italien">
                    <input type="hidden" name="prix" value="50.00">

                    <div class="d-flex align-items-center">
                        <span class="me-3 fw-bold">Quantité :</span>
                        <input type="number" class="form-control w-25" name="qty" value="3" readonly>
                        <span class="ms-4 fw-bold">Prix : 50.00DH</span>
                    </div>
                </div>
            </div>

            <!-- Méthode de paiement -->
            <div class="card">
                <h5 class="mb-3">Méthode de paiement</h5>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment" id="paypal" value="paypal" checked>
                    <label class="form-check-label" for="paypal"> 💳PayPal</label>
                </div>
                <div class="form-check mt-2">
                    <input class="form-check-input" type="radio" name="payment" id="cash" value="cash">
                    <label class="form-check-label" for="cash">💵 Paiement en espèces</label>
                </div>
            </div>

            <!-- Adresse -->
            <div class="card">
                <h5 class="mb-3">Adresse de livraison</h5>
                <textarea name="adresse" class="form-control" rows="3" placeholder="Entrez votre adresse complète ici..." required></textarea>
            </div>
        </div>

        <!-- Colonne dyal facture -->
        <div class="col-md-4">
            <h5 class="text-center bg-white text-dark py-2 rounded-top">Détails de la facture</h5>
            <div class="card">
                <div class="d-flex justify-content-between mb-2">
                    <span>Sous-total</span>
                    <span>50.00DH</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Livraison</span>
                    <span>Gratuit</span>
                </div>
                <div class="d-flex justify-content-between fw-bold mb-4">
                    <span>Total</span>
                    <span>50.00DH</span>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-pay">Valider la commande →</button>
                    <a href="#" class="btn btn-back">Annuler</a>
                </div>
            </div>
        </div>
    </div>
</form>

</div>

</body>
</html>
<?php include 'includes/footer.php'; ?>
 <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/FastAndYumProject/FastAndYum/public/lib/wow/wow.min.js"></script>

    <script src="/FastAndYumProject/FastAndYum/public/lib/owlcarousel/owl.carousel.min.js"></script>

 <!-- Javascript -->
    <script src="/FastAndYumProject/FastAndYum/public/js/main.js"></script>
