<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <title>Modifier un utilisateur</title>
</head>
<body>
    <div>
        <h2>Modifier un utilisateur</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if (isset($userInfo) && $userInfo): ?>
            <form method="POST" action="index.php?page=user_edit&user_id=<?php echo $userInfo['user_id']; ?>">

                <div>
                    <label>Nom d'utilisateur</label>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($userInfo['username']); ?>" required>
                </div>

                <div>
                    <label>Prénom</label>
                    <input type="text" name="prenom" value="<?php echo htmlspecialchars($userInfo['prenom']); ?>" required>
                </div>

                <div>
                    <label>Nom</label>
                    <input type="text" name="nom" value="<?php echo htmlspecialchars($userInfo['nom']); ?>" required>
                </div>

                <div>
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($userInfo['email']); ?>" required>
                </div>

                <div>
                    <label>Téléphone</label>
                    <input type="text" name="telephone" value="<?php echo htmlspecialchars($userInfo['telephone']); ?>" required>
                </div>

                <div>
                    <label>Adresse</label>
                    <textarea name="adresse" required><?php echo htmlspecialchars($userInfo['adresse']); ?></textarea>
                </div>

                <div>
                    <label>Nouveau mot de passe (laisser vide pour ne pas le modifier)</label>
                    <input type="password" name="password">
                </div>

                <div>
                    <label>Confirmer le mot de passe</label>
                    <input type="password" name="confirm_password">
                </div>

                <button type="submit">Mettre à jour</button>
                <a href="index.php?page=user_details&user_id=<?php echo $userInfo['user_id']; ?>">Annuler</a>
            </form>
        <?php else: ?>
            <p>Aucune information disponible pour cet utilisateur.</p>
            <a href="index.php?page=user_info">Retour à la liste</a>
        <?php endif; ?>
    </div>
</body>
</html>
