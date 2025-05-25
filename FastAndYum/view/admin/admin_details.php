<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Détails Administrateur</title>
</head>
<body>
    <div>
        <h2>Détails de l'administrateur</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <div><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <?php if (isset($adminInfo) && $adminInfo): ?>
            <table border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <th>ID</th>
                    <td><?php echo htmlspecialchars($adminInfo['user_id']); ?></td>
                </tr>
                <tr>
                    <th>Prénom</th>
                    <td><?php echo htmlspecialchars($adminInfo['prenom']); ?></td>
                </tr>
                <tr>
                    <th>Nom</th>
                    <td><?php echo htmlspecialchars($adminInfo['nom']); ?></td>
                </tr>
                <tr>
                    <th>Nom d'utilisateur</th>
                    <td><?php echo htmlspecialchars($adminInfo['username']); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($adminInfo['email']); ?></td>
                </tr>
                <tr>
                    <th>Date d'inscription</th>
                    <td><?php echo htmlspecialchars($adminInfo['date_inscription'] ?? 'N/A'); ?></td>
                </tr>
            </table>
            <a href="index.php?page=admin_edit&user_id=<?php echo $adminInfo['user_id']; ?>">Modifier</a>
            <a href="index.php?page=admin_delete&user_id=<?php echo $adminInfo['user_id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet administrateur ?');">Supprimer</a>
            <a href="index.php?page=admin_info">Retour aux informations</a>
        <?php else: ?>
            <p>Aucun détail sur l'administrateur disponible.</p>
            <a href="index.php?page=admin_info">Retour aux informations</a>
        <?php endif; ?>
    </div>
</body>
</html>