<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <title>Inscription Administrateur</title>
</head>
<body>

  <h2>Inscription Administrateur</h2>

  <?php
    // Affichage conditionnel des messages (sans classe, seulement inline style)
    if (!empty($_SESSION['error'])) {
      echo '<div style="color: red; margin-bottom: 15px;">' . htmlspecialchars($_SESSION['error']) . '</div>';
      unset($_SESSION['error']);
    } elseif (!empty($_SESSION['success'])) {
      echo '<div style="color: green; margin-bottom: 15px;">' . htmlspecialchars($_SESSION['success']) . '</div>';
      unset($_SESSION['success']);
    }
  ?>

  <form method="POST" action="index.php?page=register">

    <label>Nom d'utilisateur<br />
      <input type="text" name="username" required />
    </label><br /><br />

    <label>Prénom<br />
      <input type="text" name="prenom" required />
    </label><br /><br />

    <label>Nom<br />
      <input type="text" name="nom" required />
    </label><br /><br />

    <label>Adresse e-mail<br />
      <input type="email" name="email" required />
    </label><br /><br />

    <label>Mot de passe<br />
      <input type="password" name="password" required />
    </label><br /><br />

    <label>Confirmer le mot de passe<br />
      <input type="password" name="confirm_password" required />
    </label><br /><br />

    <input type="submit" value="S'inscrire" name="inscrire" />

  </form>
  <a href="index.php?page=admin_info">Retour à la liste</a>
</body>
</html>