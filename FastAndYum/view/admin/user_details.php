<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Détails de l'utilisateur</title>

  <!-- Favicon -->
  <link href="/FastAndYumProject/FastAndYum/public/img/logo1.png" rel="icon" />

  <!-- Libraries -->
  <link href="/FastAndYumProject/FastAndYum/public/lib/animate/animate.min.css" rel="stylesheet" />
  <link href="/FastAndYumProject/FastAndYum/public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

  <!-- Bootstrap -->
  <link href="/FastAndYumProject/FastAndYum/public/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Custom CSS -->
  <link href="/FastAndYumProject/FastAndYum/public/css/fastyum.css" rel="stylesheet" />
  <link href="/fastandyam/FastAndYum/public/css/admin/user_details.css" rel="stylesheet" />

  
</head>
<body class="user_details">

  <div class="card-custom animate__animated animate__fadeIn">
    <h2>Détails de l'utilisateur</h2>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (isset($userInfo) && $userInfo): ?>
      <div class="user-info">
        <?php if ($userInfo['image_client'] !== '1'): ?>
          <img src="public/img/<?php echo htmlspecialchars($userInfo['image_client']); ?>" alt="Image de profil" class="profile-img" />
        <?php else: ?>
          <div class="profile-img d-flex align-items-center justify-content-center bg-secondary text-white"><img src="" alt=""></div>
        <?php endif; ?>
        <div>
          <div class="name"><?php echo htmlspecialchars($userInfo['prenom'] . ' ' . $userInfo['nom']); ?></div>
          <div class="username">@<?php echo htmlspecialchars($userInfo['username']); ?></div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table">
          <tbody>
            <tr><th>Identifiant</th><td><?php echo htmlspecialchars($userInfo['user_id']); ?></td></tr>
            <tr><th>Email</th><td><?php echo htmlspecialchars($userInfo['email']); ?></td></tr>
            <tr><th>Téléphone</th><td><?php echo htmlspecialchars($userInfo['telephone']); ?></td></tr>
            <tr><th>Adresse</th><td><?php echo htmlspecialchars($userInfo['adresse']); ?></td></tr>
            <tr><th>Date d'inscription</th><td><?php echo htmlspecialchars($userInfo['date_inscription'] ?? 'N/A'); ?></td></tr>
          </tbody>
        </table>
      </div>

      <h4>Avis</h4>
      <?php if (empty($avis)): ?>
        <p class="text-muted">Aucun avis trouvé.</p>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-sm">
            <thead>
              <tr>
                <th>ID Avis</th>
                <th>Commentaire</th>
                <th>Date</th>
                <th>ID Plat</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($avis as $remark): ?>
                <tr>
                  <td><?php echo htmlspecialchars($remark['avis_id']); ?></td>
                  <td><?php echo htmlspecialchars($remark['commentaire']); ?></td>
                  <td><?php echo htmlspecialchars($remark['date_avis']); ?></td>
                  <td><?php echo htmlspecialchars($remark['plat_id']); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>

      <div class="actions">
        <a href="index.php?page=user_edit&user_id=<?php echo $userInfo['user_id']; ?>" class="btn btn-orange">Modifier</a>
        <a href="index.php?page=user_delete&user_id=<?php echo $userInfo['user_id']; ?>" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">Supprimer</a>
      </div>
    <?php else: ?>
      <p class="text-muted text-center">Aucun détail disponible pour cet utilisateur.</p>
    <?php endif; ?>

    <div class="back-link">
      <a href="index.php?page=user_info" class="btn btn-outline-secondary">⬅ Retour à la liste</a>
    </div>
  </div>

  <script src="/FastAndYumProject/FastAndYum/public/js/bootstrap.bundle.min.js"></script>
</body>
</html>
