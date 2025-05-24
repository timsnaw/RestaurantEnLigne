<?php
if (!isset($user) || $user['user_id'] !== $_SESSION['user_id']) {
    header('Location: index.php?page=login_user');
    exit;
}
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Profil</title>
</head>
<body>
    <h2>Modifier le Profil</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <p style="color: green;">
            <?php echo htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8'); unset($_SESSION['message']); ?>
        </p>
    <?php elseif (isset($_SESSION['error'])): ?>
        <p style="color: red;">
            <?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); unset($_SESSION['error']); ?>
        </p>
    <?php endif; ?>

    <!-- modifier profile -->
    <form action="index.php?page=update_user" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">

        <label for="username">Nom d'utilisateur</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br>

        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user['prenom'] ?? ''); ?>"><br>

        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($user['nom'] ?? ''); ?>"><br>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>

        <label for="telephone">Téléphone</label>
        <input type="text" id="telephone" name="telephone" value="<?php echo htmlspecialchars($user['telephone'] ?? ''); ?>"><br>

        <label for="adresse">Adresse</label>
        <textarea id="adresse" name="adresse"><?php echo htmlspecialchars($user['adresse'] ?? ''); ?></textarea><br>

        <label for="image_client">Image de profil</label>
        <input type="file" id="image_client" name="image_client" accept="image/jpeg,image/png,image/gif"><br>
        <?php if (!empty($user['image_client'])): ?>
            <img src="<?php echo htmlspecialchars('public/images/' . $user['image_client']); ?>" alt="Image de profil" width="100"><br>
        <?php endif; ?>

        <label>
            <input type="checkbox" id="show-password-form" onchange="togglePasswordForm()"> Modifier le mot de passe
        </label><br>

        <label>
            <input type="checkbox" id="show-delete-account-form" onchange="toggleDeleteAccountForm()"> Supprimer le compte
        </label><br>

        <button type="submit">Mettre à jour</button>
        <a href="index.php?page=utilisateur_info">Annuler</a>
    </form>

    <!-- Changer mot de passe form -->
    <div id="password-form" style="display: none;">
        <h3>Changer le mot de passe</h3>
        <form action="index.php?page=update_password" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">

            <label for="current_password">Mot de passe actuel</label>
            <input type="password" id="current_password" name="current_password" required>
            <span onclick="togglePassword('current_password')">Afficher</span><br>

            <label for="new_password">Nouveau mot de passe</label>
            <input type="password" id="new_password" name="new_password" required>
            <span onclick="togglePassword('new_password')">Afficher</span><br>

            <label for="confirm_password">Confirmer le nouveau mot de passe</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <span onclick="togglePassword('confirm_password')">Afficher</span><br>

            <button type="submit">Modifier le mot de passe</button>
            <button type="button" onclick="hidePasswordForm()">Annuler</button>
        </form>
    </div>

    <!-- Delete Account Form -->
    <div id="delete-account-form" style="display: none;">
        <h3>Supprimer le compte</h3>
        <form action="index.php?page=delete_account" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.');">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
            <p style="color: red;">Attention : La suppression de votre compte est permanente et supprimera toutes vos données associées.</p>
            <button type="submit">Supprimer mon compte</button>
            <button type="button" onclick="hideDeleteAccountForm()">Annuler</button>
        </form>
    </div>

    <script src="./public/js/utilisateur_edit.js"></script>
</body>
</html>
