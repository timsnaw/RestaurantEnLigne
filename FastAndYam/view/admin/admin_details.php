<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <title>Détails Administrateur</title>
</head>
<body>
    <div >
        <h2>Détails de l'administrateur</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <div ><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <?php if (isset($adminInfo) && $adminInfo): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <td><?php echo htmlspecialchars($adminInfo['admin_id']); ?></td>
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
            <a href="index.php?page=admin_edit&admin_id=<?php echo $adminInfo['admin_id']; ?>" >Modifier</a>
            <a href="index.php?page=admin_delete&admin_id=<?php echo $adminInfo['admin_id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet administrateur ?');">Supprimer</a>
        <?php else: ?>
            <p>Aucun détail sur l'administrateur disponible.</p>
        <?php endif; ?>
        <a href="index.php?page=admin_info" >Retour aux informations</a>
    </div>
</body>
</html>
