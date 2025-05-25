<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div>
        <h2>Connexion</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error">
                <?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        <form action="index.php?page=login_user" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">

            <div>
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" required>
            </div>
            <br>
            <div>
                <label for="password">Mot de passe</label><br>
                <input type="password" id="password" name="password" required>
            </div>
            <br>
            <div>
                <button type="submit">Se connecter</button>
            </div>
        </form>
        <p>Pas de compte ? <a href="index.php?page=register_user">Inscrivez-vous</a></p>
    </div>
</body>
</html>
