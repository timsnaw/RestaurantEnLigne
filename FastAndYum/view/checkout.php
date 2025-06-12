<?php
error_log("Checkout view loaded, POST data: " . json_encode($_POST));
include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Finaliser la commande</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="/FastAndYumProject/FastAndYum/public/img/logo1.png" rel="icon">
    <link href="/FastAndYumProject/FastAndYum/public/lib/animate/animate.min.css" rel="stylesheet">
    <link href="/FastAndYumProject/FastAndYum/public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="/FastAndYumProject/FastAndYum/public/css/bootstrap.min.css" rel="stylesheet">
    <link href="/FastAndYumProject/FastAndYum/public/css/fastyum.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #fddede, #d7f1f9);
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
        textarea.form-control {
            resize: none;
        }
        .card h5 {
            font-size: 1.2rem;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<br><br>
<div class="container checkout-container">
    <a href="index.php?page=panier" class="text-decoration-none text-warning">← Retour au panier</a>

    <h4 class="my-4 section-title">Finalisation de la commande</h4>

    <?php if (isset($data['success'])): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($data['success']); ?>
            <br>
            <a href="index.php?page=home" class="btn btn-primary mt-2">Continuer les achats</a>
        </div>
    <?php elseif (isset($data['error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($data['error']); ?></div>
    <?php endif; ?>

    <?php if (!isset($data['success'])): ?>
        <form action="index.php?page=checkout&action=place_order" method="post" onsubmit="console.log('Form submitting');">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
            <div class="row">
                <div class="col-md-8">
                    <?php if (empty($data['panierItems'])): ?>
                        <div class="alert alert-warning">Aucun article dans le panier.</div>
                    <?php else: ?>
                        <?php foreach ($data['panierItems'] as $item): ?>
                            <div class="card d-flex align-items-center flex-row">
                                <img src="/FastAndYumProject/FastAndYum/public/img/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['titre']); ?>" class="product-img me-3">
                                <div class="flex-grow-1">
                                    <h5 class="mb-1"><?php echo htmlspecialchars($item['titre']); ?></h5>
                                    <p class="mb-2 text-muted"><?php echo htmlspecialchars($item['description']); ?></p>
                                    <!-- Hidden inputs pour envoyer les données au PHP -->
                                    <input type="hidden" name="produit[<?php echo $item['plat_id']; ?>]" value="<?php echo htmlspecialchars($item['titre']); ?>">
                                    <input type="hidden" name="prix[<?php echo $item['plat_id']; ?>]" value="<?php echo htmlspecialchars($item['prix']); ?>">
                                    <div class="d-flex align-items-center">
                                        <span class="me-3 fw-bold">Quantité :</span>
                                        <input type="number" class="form-control w-25" name="qty[<?php echo $item['plat_id']; ?>]" value="<?php echo htmlspecialchars($item['quantite']); ?>" readonly>
                                        <span class="ms-4 fw-bold">Prix : <?php echo number_format($item['prix'], 2); ?>DH</span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <div class="card">
                        <h5 class="mb-3">Méthode de paiement</h5>
                        <div class="form-check ">
                            <input class="form-check-input" type="radio" name="mode_paiement" id="especes" value="especes" checked>
                            <label class="form-check-label" for="especes">💵 Paiement en espèces</label>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="radio" name="mode_paiement" id="paypal" value="paypal" >
                            <label class="form-check-label" for="paypal">💳 PayPal</label>
                        </div>
                    </div>

                    <div class="card">
                        <h5 class="mb-3">Adresse de livraison</h5>
                        <textarea name="adresse" class="form-control" rows="3" placeholder="Entrez votre adresse complète ici..." required><?php echo htmlspecialchars($data['adresse'] ?? ''); ?></textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <h5 class="text-center bg-white text-dark py-2 rounded-top">Détails de la facture</h5>
                    <div class="card">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Sous-total</span>
                            <span><?php echo number_format($data['total'] ?? 0, 2); ?>DH</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Livraison</span>
                            <span>Gratuit</span>
                        </div>
                        <div class="d-flex justify-content-between fw-bold mb-4">
                            <span>Total</span>
                            <span><?php echo number_format($data['total'] ?? 0, 2); ?>DH</span>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-pay">Valider la commande →</button>
                            <a href="index.php?page=panier" class="btn btn-back">Annuler</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/FastAndYumProject/FastAndYum/public/lib/wow/wow.min.js"></script>
<script src="/FastAndYumProject/FastAndYum/public/lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Javascript -->
<script src="/FastAndYumProject/FastAndYum/public/js/main.js"></script>