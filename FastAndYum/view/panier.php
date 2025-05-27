<?php
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
include 'view/includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Panier - Fast&Yum</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Fast&Yum, Panier, Commande" name="keywords">
    <meta content="Votre panier d'achat sur Fast&Yum" name="description">

    <!-- Fast&Yum Icon -->
    <link href="public/img/logo1.png" rel="icon">

    <!-- Icons of the site -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="public/lib/animate/animate.min.css" rel="stylesheet">
    <link href="public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="public/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS Stylesheet -->
    <link href="public/css/fastyum.css" rel="stylesheet">
</head>

<body class="panierbody">
<br><br>
<div class="container my-5">
    <?php if (!empty($data['success'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($data['success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>

    <form action="index.php?page=panier&action=modifier" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <div class="mb-3">
            <a href="index.php?page=menu" class="text-decoration-none">← Poursuivre les achats</a>
        </div>

        <h5 class="text-warning mb-4">Panier</h5>

        <div class="row">
            <div class="col-md-8">
                <?php if (empty($data['panierItems'])): ?>
                    <p>Votre panier est vide.</p>
                <?php else: ?>
                    <?php foreach ($data['panierItems'] as $item): ?>
                        <div class="cart-item d-flex align-items-center mb-3">
                            <img src="public/img/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['titre']); ?>" class="img-fluid" style="width: 100px;">
                            <div class="flex-grow-1 ms-3">
                                <div><strong><?php echo htmlspecialchars($item['titre']); ?></strong></div>
                                <small><?php echo htmlspecialchars($item['description']); ?></small>
                            </div>
                            <input type="number" class="form-control w-25 mx-2" name="quantities[<?php echo $item['plat_id']; ?>]" value="<?php echo $item['quantite']; ?>" min="1">
                            <div class="me-3"><?php echo number_format($item['subtotal'], 2); ?>DH</div>
                            <a href="index.php?page=panier&action=supprimer&plat_id=<?php echo $item['plat_id']; ?>" class="btn btn-sm btn-outline-danger">🗑</a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="col-md-4">
                <h5 class="text-center bg-white text-dark py-2 rounded-top">Détails de la facture</h5>
                <div class="cart-summary rounded-top-0 p-3">
                    <div class="d-flex justify-content-between mb-2">
                        <div>Sous-total</div>
                        <div><?php echo number_format($data['total'], 2); ?>DH</div>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <div>Livraison</div>
                        <div>Gratuit</div>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <strong>Total</strong>
                        <strong><?php echo number_format($data['total'], 2); ?>DH</strong>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" formaction="index.php?page=panier&action=acheter" class="btn btn-buy">Acheter →</button>
                        <button type="submit"  class="btn btn-buy">modifier →</button>
                        <a href="index.php?page=menu" class="btn btn-return">Retour</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<br><br><br>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="public/lib/wow/wow.min.js"></script>
<script src="public/lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Javascript -->
<script src="public/js/main.js"></script>

</body>
</html>

<?php include 'view/includes/footer.php'; ?>