<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> page connexion </title>
</head>
<body>
	<div>
    <h2>Connexion Administrateur</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div>
            <?php echo htmlspecialchars($_SESSION['error']); ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="POST" action="index.php?page=admin_login">
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" required>
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" required>
        </div>

        <input type="submit" name="connexion" value="connexion">
    </form>
</div>
</body>
</html>