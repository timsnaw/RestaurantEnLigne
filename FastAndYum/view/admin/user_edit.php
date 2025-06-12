<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Modifier un utilisateur</title>

  <!-- Bootstrap CSS -->
  <link href="public/css/bootstrap.min.css" rel="stylesheet" />
  
  <!-- Favicon -->
  <link href="public/img/logo1.png" rel="icon" />

  <!-- Libraries -->
  <link href="public/lib/animate/animate.min.css" rel="stylesheet" />
  <link href="public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

  <!-- Bootstrap -->
  <link href="public/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Custom CSS -->
  <link href="public/css/fastyum.css" rel="stylesheet" />
  <link href="public/css/admin/user_edit.css" rel="stylesheet" />

  
</head>
<body class="user_edit">

  <div class="card-custom">

    <h2>Modifier un utilisateur</h2>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (isset($userInfo) && $userInfo): ?>
      <form method="POST" action="index.php?page=user_edit&user_id=<?php echo $userInfo['user_id']; ?>">

        <label for="username">Nom d'utilisateur</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($userInfo['username']); ?>" required>

        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($userInfo['prenom']); ?>" required>

        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($userInfo['nom']); ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userInfo['email']); ?>" required>

        <label for="telephone">Téléphone</label>
        <input type="text" id="telephone" name="telephone" value="<?php echo htmlspecialchars($userInfo['telephone']); ?>" required>

        <label for="adresse">Adresse</label>
        <textarea id="adresse" name="adresse" required><?php echo htmlspecialchars($userInfo['adresse']); ?></textarea>

        <label for="password">Nouveau mot de passe (laisser vide pour ne pas le modifier)</label>
        <input type="password" id="password" name="password">

        <label for="confirm_password">Confirmer le mot de passe</label>
        <input type="password" id="confirm_password" name="confirm_password">

        <button type="submit">Mettre à jour</button>
      </form>

      <a href="index.php?page=user_details&user_id=<?php echo $userInfo['user_id']; ?>" class="btn-cancel">Annuler</a>

    <?php else: ?>
      <p>Aucune information disponible pour cet utilisateur.</p>
      <a href="index.php?page=user_info" class="btn-cancel">Retour à la liste</a>
    <?php endif; ?>

  </div>

  <script src="public/js/bootstrap.bundle.min.js"></script>
</body>
</html>
