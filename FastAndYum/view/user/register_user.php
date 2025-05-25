<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div>
        <h2>Inscription</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form action="index.php?page=register_user" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            <div>
                <label for="username">Nom d'utilisateur <span style="color:red">*</span></label><br>
                <input type="text" id="username" name="username" required>
            </div><br>

            <div>
                <label for="prenom">Prénom</label><br>
                <input type="text" id="prenom" name="prenom">
            </div><br>

            <div>
                <label for="nom">Nom</label><br>
                <input type="text" id="nom" name="nom">
            </div><br>

            <div>
                <label for="email">Email <span style="color:red">*</span></label><br>
                <input type="email" id="email" name="email" required>
            </div><br>

            <div>
                <label for="telephone">Téléphone</label><br>
                <input type="text" id="telephone" name="telephone">
            </div><br>

            <div>
                <label for="adresse">Adresse</label><br>
                <textarea id="adresse" name="adresse"></textarea>
            </div><br>

            <div>
                <label for="password">Mot de passe <span style="color:red">*</span></label><br>
                <input type="password" id="password" name="password" required>
            </div><br>

            <div>
                <label for="password_confirm">Confirmer le mot de passe <span style="color:red">*</span></label><br>
                <input type="password" id="password_confirm" name="password_confirm" required>
            </div><br>

            <button type="submit">S'inscrire</button>
        </form>

        <p>Déjà un compte ? <a href="index.php?page=login_user">Connectez-vous</a></p>
    </div>
</body>
</html>