<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Statistiques</title>

  <!-- Favicon -->
  <link href="public/img/logo1.png" rel="icon">

  <!-- Libraries -->
  <link href="public/lib/animate/animate.min.css" rel="stylesheet">
  <link href="public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="public/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="public/css/fastyum.css" rel="stylesheet">
  <link href="public/css/admin/statiqtique.css" rel="stylesheet">

  
</head>
<body class="stats">
  <div class="container">
    <h2>Statistique globale</h2>
<div class="row g-4 mb-4">
  <!-- Première ligne: 4 stats -->
  <div class="col-md-3 col-sm-6">
    <div class="stat-box">
      <span>Clients</span>
      <p><?= htmlspecialchars($data['stats']['nbUsers']) ?></p>
    </div>
  </div>
  <div class="col-md-3 col-sm-6">
    <div class="stat-box">
      <span>Admins</span>
      <p><?= htmlspecialchars($data['stats']['nbAdmins']) ?></p>
    </div>
  </div>
  <div class="col-md-3 col-sm-6">
    <div class="stat-box">
      <span>Commandes</span>
      <p><?= htmlspecialchars($data['stats']['nbOrders']) ?></p>
    </div>
  </div>
  <div class="col-md-3 col-sm-6">
    <div class="stat-box">
      <span>Plats</span>
      <p><?= htmlspecialchars($data['stats']['nbDishes']) ?></p>
    </div>
  </div>

  <!-- Deuxième ligne: 2 stats + Revenus large -->
  <div class="col-md-6 col-sm-6">
    <div class="stat-box">
      <span>Catégories</span>
      <p><?= htmlspecialchars($data['stats']['nbCategories']) ?></p>
    </div>
  </div>
  <div class="col-md-6 col-sm-6">
    <div class="stat-box revenue-box">
      <span>Revenus</span>
      <p><?= htmlspecialchars($data['stats']['revenue']) ?> DH</p>
    </div>
  </div>
</div>


    <h2>Statistique de ce jour</h2>
<div class="row g-4 mb-4">
  <div class="col-md-6 col-sm-6">
    <div class="stat-box">
      <span>Commandes</span>
      <p><?= htmlspecialchars($data['stats']['dailyOrders']) ?></p>
    </div>
  </div>
  <div class="col-md-6 col-sm-6">
    <div class="stat-box revenue-box">
      <span>Revenu</span>
      <p><?= htmlspecialchars($data['stats']['dailyRevenue']) ?> DH</p>
    </div>
  </div>
</div>


    <h2>Télécharger PDF</h2>
    <form method="get" action="index.php" class="row g-3 align-items-center">
      <input type="hidden" name="page" value="export_pdf">
      <div class="col-auto">
        <select name="month" required class="form-control">
          <option value="">Sélectionner un mois</option>
          <?php foreach ($data['availableMonths'] as $month): ?>
          <option value="<?= htmlspecialchars($month) ?>">
            <?= date('F Y', strtotime($month . '-01')) ?>
          </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-orange">Télécharger</button>
      </div>
    </form>
  </div>
</body>
</html>
