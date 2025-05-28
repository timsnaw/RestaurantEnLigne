<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Informations Utilisateur</title>

    <!-- Favicon -->
    <link href="/FastAndYumProject/FastAndYum/public/img/logo1.png" rel="icon">

    <!-- Bootstrap -->
    <link href="/FastAndYumProject/FastAndYum/public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/fastandyam/FastAndYum/public/css/admin/user_info.css" rel="stylesheet"> 
   
</head>
<body class="bg-light">

    <div class="container py-5">
        <div class="text-center mb-4">
            <h2>Informations Utilisateur</h2>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <div class="user-table-container p-4">
  <div class="responsive-overflow">
    <table class="table table-hover table-bordered text-center align-middle mb-0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nom d'utilisateur</th>
          <th>Prénom</th>
          <th>Nom</th>
          <th>Email</th>
          <th>Téléphone</th>
          <th>Date d'inscription</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($users)): ?>
          <tr>
            <td colspan="8" class="text-muted">Aucun utilisateur trouvé.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($users as $user): ?>
            <tr>
              <td><?= htmlspecialchars($user['user_id']) ?></td>
              <td><?= htmlspecialchars($user['username']) ?></td>
              <td><?= htmlspecialchars($user['prenom']) ?></td>
              <td><?= htmlspecialchars($user['nom']) ?></td>
              <td><?= htmlspecialchars($user['email']) ?></td>
              <td><?= htmlspecialchars($user['telephone']) ?></td>
              <td><?= htmlspecialchars($user['date_inscription'] ?? 'N/A') ?></td>
              <td>
                <a href="index.php?page=user_details&user_id=<?= $user['user_id'] ?>" class="btn btn-sm btn-view">Voir</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>


    </div>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/FastAndYumProject/FastAndYum/public/lib/wow/wow.min.js"></script>

    <script src="/FastAndYumProject/FastAndYum/public/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Javascript -->
    <script src="/FastAndYumProject/FastAndYum/public/js/main.js"></script>











</body>
</html>
