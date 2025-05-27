<?php
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
include 'view/includes/header.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du produit - Fast&Yum</title>
    <meta content="Fast&Yum, Détails produit, <?php echo htmlspecialchars($data['product']['titre']); ?>" name="keywords">
    <meta content="<?php echo htmlspecialchars($data['product']['description']); ?>" name="description">

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
<body>
    <br><br><br>
    <div class="container py-5 wow fadeInUp" data-wow-delay="0.1s">
        <form method="POST" action="index.php?page=panier&action=ajoute">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="plat_id" value="<?php echo htmlspecialchars($data['product']['plat_id']); ?>">
            <div class="row">
                <div class="col-md-6">
                    <img id="mainImage" src="public/img/<?php echo htmlspecialchars($data['product']['image']); ?>" class="product-image wow fadeInUp" data-wow-delay="0.2s" alt="<?php echo htmlspecialchars($data['product']['titre']); ?>">
                    <div class="d-flex mt-3">
                        <?php
                        $images = !empty($data['product']['image_plat']) ? explode(',', $data['product']['image_plat']) : [$data['product']['image']];
                        $delay = 0.2;
                        foreach ($images as $image):
                        ?>
                            <img src="public/img/<?php echo htmlspecialchars(trim($image)); ?>" class="thumb-img wow fadeInUp" data-wow-delay="<?php echo $delay; ?>s" onclick="changeImage(this.src)">
                        <?php
                            $delay += 0.1;
                        endforeach;
                        ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <h2 class="fw-bold"><?php echo htmlspecialchars($data['product']['titre']); ?></h2>
                    <input type="hidden" name="produit" value="<?php echo htmlspecialchars($data['product']['titre']); ?>">

                    <div class="product-rating text-warning">
                        <?php
                        $rating = $data['average_rating'] ?: 5;
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

                    <p><strong>Catégorie :</strong> <?php echo htmlspecialchars($data['categorie']['nom_categorie']); ?></p>
                    <p><strong>Description :</strong> <?php echo htmlspecialchars($data['product']['description']); ?></p>

                    <p class="price">
                        <?php
                        $prix = $data['product']['prix'];
                        if (!empty($data['product']['taux_reduction'])) {
                            $discounted_price = $prix * (1 - $data['product']['taux_reduction'] / 100);
                            echo '<span class="old-price"><i class="fas fa-tag"></i> ' . number_format($prix, 2) . 'DH</span> ';
                            echo '<span class="new-price">' . number_format($discounted_price, 2) . 'DH</span>';
                            echo '<input type="hidden" name="prix" value="' . number_format($discounted_price, 2) . '">';
                        } else {
                            echo '<span class="new-price">' . number_format($prix, 2) . 'DH</span>';
                            echo '<input type="hidden" name="prix" value="' . number_format($prix, 2) . '">';
                        }
                        ?>
                    </p>

                    <div class="mb-3">
                        <strong>Quantité :</strong>
                        <div class="d-flex align-items-center quantity-control">
                            <button type="button" class="btn-minus" onclick="decreaseQuantity()">-</button>
                            <input type="text" name="quantite" id="quantity" value="1" readonly class="form-control mx-2" style="width: 50px; text-align: center;">
                            <button type="button" class="btn-plus" onclick="increaseQuantity()">+</button>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-3">
                        <button type="submit" class="btn btn-outline-danger px-4">Ajouter au panier</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <br><br><br><br>

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
                <a href="index.php?page=menu">
                    <button class="btn btn-warning btn-lg rounded shadow-sm">Voir plus de produits</button>
                </a>
            </div>
        </section>
    </div>
    <!-- Categories End -->

    <br>

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