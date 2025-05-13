<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <title>Modifier Administrateur</title>
</head>
<body>
    <div >
        <h2>Modifier l'administrateur</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <div ><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <div ><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (isset($adminInfo) && $adminInfo): ?>
            <form method="POST" action="index.php?page=admin_edit&admin_id=<?php echo $adminInfo['admin_id']; ?>">
                <div >
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($adminInfo['username']); ?>" required>
                </div>
                <div >
                    <label for="email">Adresse email</label>
                    <input type="email"  name="email" value="<?php echo htmlspecialchars($adminInfo['email']); ?>" required>
                </div>
                <div >
                    <label for="password">Nouveau mot de passe (laisser vide pour conserver l'actuel)</label>
                    <input type="password"  name="password">
                </div>
                <div >
                    <label for="confirm_password">Confirmer le nouveau mot de passe</label>
                    <input type="password"  name="confirm_password">
                </div>
                <button type="submit" >Mettre à jour</button>
                <a href="index.php?page=admin_details&admin_id=<?php echo $adminInfo['admin_id']; ?>">Annuler</a>
            </form>
        <?php else: ?>
            <p>Aucune information sur l'administrateur disponible.</p>
            <a href="index.php?page=admin_linfo" >Retour à la liste</a>
        <?php endif; ?>
    </div>
</body>
</html>
