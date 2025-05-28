<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <title>Informations Administrateurs</title>
    
    <!-- Favicon -->
    <link href="/FastAndYumProject/FastAndYum/public/img/logo1.png" rel="icon">


    <!-- Libraries -->
    <link href="/FastAndYumProject/FastAndYum/public/lib/animate/animate.min.css" rel="stylesheet">
    <link href="/FastAndYumProject/FastAndYum/public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="/FastAndYumProject/FastAndYum/public/css/bootstrap.min.css" rel="stylesheet">
    <link href="/fastandyam/FastAndYum/public/css/admin/admin_info.css" rel="stylesheet"> 
    
</head>
<body>
  <div class="container">
    <h2>Informations des administrateurs</h2>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger">
        <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
      </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success">
        <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
      </div>
    <?php endif; ?>

    <div class="d-flex justify-content-end mb-3">
      <a href="index.php?page=register" class="btn btn-orange">Ajouter un administrateur</a>
    </div>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nom d'utilisateur</th>
          <th>Email</th>
          <th>Date d'inscription</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($admins)): ?>
          <tr>
            <td colspan="5">Aucun administrateur trouvé.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($admins as $admin): ?>
            <tr>
              <td><?= htmlspecialchars($admin['user_id']); ?></td>
              <td><?= htmlspecialchars($admin['username']); ?></td>
              <td><?= htmlspecialchars($admin['email']); ?></td>
              <td><?= htmlspecialchars($admin['date_inscription']); ?></td>
              <td>
                <a href="index.php?page=admin_details&user_id=<?= $admin['user_id']; ?>" class="btn btn-info btn-sm">Voir</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
