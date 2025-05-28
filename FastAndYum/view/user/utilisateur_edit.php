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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Modifier le Profil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            color: #333;
            margin: 20px;
        }
        h2, h3 {
            color: #2c3e50;
        }
        form {
            background: #fff;
            padding: 20px 25px;
            border-radius: 8px;
            max-width: 500px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 8px 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }
        textarea {
            resize: vertical;
            height: 80px;
        }
        button {
            background-color: #2980b9;
            border: none;
            color: white;
            padding: 10px 18px;
            margin-top: 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #1c5980;
        }
        a {
            margin-left: 15px;
            color: #2980b9;
            text-decoration: none;
            font-weight: bold;
            vertical-align: middle;
        }
        a:hover {
            text-decoration: underline;
        }
        p {
            font-size: 14px;
        }
        p[style*="color: green"] {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            max-width: 500px;
        }
        p[style*="color: red"] {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            max-width: 500px;
        }
        img {
            margin-top: 10px;
            border-radius: 6px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        /* Checkbox label inline */
        label input[type="checkbox"] {
            margin-right: 8px;
            vertical-align: middle;
        }
        /* Smaller spans for "Afficher" */
        span {
            cursor: pointer;
            color: #2980b9;
            font-size: 13px;
            margin-left: 8px;
            user-select: none;
        }
        /* Forms that toggle */
        #password-form, #delete-account-form {
            max-width: 500px;
            background: #fff;
            padding: 20px 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <h2>Modifier le Profil</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <p style="color: green;">
            <?php 
                echo htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8'); 
                unset($_SESSION['message']); 
            ?>
        </p>
    <?php elseif (isset($_SESSION['error'])): ?>
        <p style="color: red;">
            <?php 
                echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); 
                unset($_SESSION['error']); 
            ?>
        </p>
    <?php endif; ?>

    <form action="index.php?page=update_user" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>" />

        <label for="username">Nom d'utilisateur</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required />

        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user['prenom'] ?? ''); ?>" />

        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($user['nom'] ?? ''); ?>" />

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required />

        <label for="telephone">Téléphone</label>
        <input type="text" id="telephone" name="telephone" value="<?php echo htmlspecialchars($user['telephone'] ?? ''); ?>" />

        <label for="adresse">Adresse</label>
        <textarea id="adresse" name="adresse"><?php echo htmlspecialchars($user['adresse'] ?? ''); ?></textarea>

        <label for="image_client">Image de profil</label>
        <input type="file" id="image_client" name="image_client" accept="image/jpeg,image/png,image/gif" />
        <?php if (!empty($user['image_client'])): ?>
            <img src="<?php echo htmlspecialchars('public/img/' . $user['image_client']); ?>" alt="Image de profil" width="100" />
        <?php endif; ?>

        <label>
            <input type="checkbox" id="show-password-form" onchange="togglePasswordForm()" /> Modifier le mot de passe
        </label>

        <label>
            <input type="checkbox" id="show-delete-account-form" onchange="toggleDeleteAccountForm()" /> Supprimer le compte
        </label>

        <button type="submit">Mettre à jour</button>
        <a href="index.php?page=utilisateur_info">Annuler</a>
    </form>

    <div id="password-form" style="display: none;">
        <h3>Changer le mot de passe</h3>
        <form action="index.php?page=update_password" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>" />

            <label for="current_password">Mot de passe actuel</label>
            <input type="password" id="current_password" name="current_password" required />
            <span onclick="togglePassword('current_password')">Afficher</span>

            <label for="new_password">Nouveau mot de passe</label>
            <input type="password" id="new_password" name="new_password" required />
            <span onclick="togglePassword('new_password')">Afficher</span>

            <label for="confirm_password">Confirmer le nouveau mot de passe</label>
            <input type="password" id="confirm_password" name="confirm_password" required />
            <span onclick="togglePassword('confirm_password')">Afficher</span>

            <button type="submit">Modifier le mot de passe</button>
            <button type="button" onclick="hidePasswordForm()">Annuler</button>
        </form>
    </div>

    <div id="delete-account-form" style="display: none;">
        <h3>Supprimer le compte</h3>
        <form action="index.php?page=delete_account" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.');">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>" />
            <p style="color: red;">Attention : La suppression de votre compte est permanente et supprimera toutes vos données associées.</p>
            <button type="submit">Supprimer mon compte</button>
            <button type="button" onclick="hideDeleteAccountForm()">Annuler</button>
        </form>
    </div>

    <script src="./public/js/utilisateur_edit.js"></script>
</body>
</html>
