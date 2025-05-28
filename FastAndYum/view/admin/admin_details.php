<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Détails Administrateur</title>

  <!-- Favicon -->
  <link href="/FastAndYumProject/FastAndYum/public/img/logo1.png" rel="icon" />

  <!-- Bootstrap -->
  <link href="/FastAndYumProject/FastAndYum/public/css/bootstrap.min.css" rel="stylesheet" />
  <!-- CSS personnalisé -->
  <link href="/fastandyam/FastAndYum/public/css/admin/admin_details.css" rel="stylesheet" />
</head>
<body>

  <div class="container user_details">
    <h2>Détails de l'administrateur</h2>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (isset($adminInfo) && $adminInfo): ?>
      <div class="card-custom">

        <div class="user-info">
          <img
            src="/FastAndYumProject/FastAndYum/public/img/admins/<?= htmlspecialchars($adminInfo['photo'] ?? 'default.png'); ?>"
            alt="Photo de profil"
            class="profile-img"
          />
          <div>
            <h4 class="name"><?= htmlspecialchars($adminInfo['prenom'] . ' ' . $adminInfo['nom']); ?></h4>
            <p class="username">@<?= htmlspecialchars($adminInfo['username']); ?></p>
          </div>
        </div>

        <div class="table-responsive">
          <table>
            <tbody>
              <tr><th>ID</th><td><?= htmlspecialchars($adminInfo['user_id']); ?></td></tr>
              <tr><th>Email</th><td><?= htmlspecialchars($adminInfo['email']); ?></td></tr>
              <tr><th>Date d'inscription</th><td><?= htmlspecialchars($adminInfo['date_inscription'] ?? 'N/A'); ?></td></tr>
            </tbody>
          </table>
        </div>

        <div class="actions">
          <a href="index.php?page=admin_edit&user_id=<?= $adminInfo['user_id']; ?>" class="btn-orange">Modifier</a>
          <a href="index.php?page=admin_delete&user_id=<?= $adminInfo['user_id']; ?>" class="btn-orange btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet administrateur ?');">Supprimer</a>
          <a href="index.php?page=admin_info" class="btn btn-secondary">Retour</a>
        </div>
        
      </div>
    <?php else: ?>
      <p>Aucun détail sur l'administrateur disponible.</p>
      <a href="index.php?page=admin_info" class="btn btn-secondary back-link">Retour aux informations</a>
    <?php endif; ?>
  </div>

</body>
</html>
