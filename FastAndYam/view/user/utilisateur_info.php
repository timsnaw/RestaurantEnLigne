<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
</head>
<body>

    <h2>Profil de l'utilisateur</h2>
    <p>
        <img src="./public/images/<?php echo htmlspecialchars($user['image_client'] ?? ''); ?>" alt="Image de profil" width="150" height="150">
    </p>
    <p>Nom d'utilisateur : <?php echo htmlspecialchars($user['username']); ?></p>
    <p>Prénom : <?php echo htmlspecialchars($user['prenom'] ?? 'Non défini'); ?></p>
    <p>Nom : <?php echo htmlspecialchars($user['nom'] ?? 'Non défini'); ?></p>
    <p>Email : <?php echo htmlspecialchars($user['email']); ?></p>
    <p>Téléphone : <?php echo htmlspecialchars($user['telephone'] ?? 'Non défini'); ?></p>
    <p>Adresse : <?php echo htmlspecialchars($user['adresse'] ?? 'Non défini'); ?></p>
    <p><a href="index.php?page=utilisateur_edit">Modifier le profil</a></p>

    <?php if (isset($_SESSION['message'])): ?>
        <p style="color: green;"><?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?></p>
    <?php elseif (isset($_SESSION['error'])): ?>
        <p style="color: red;"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
    <?php endif; ?>

</body>
</html>
