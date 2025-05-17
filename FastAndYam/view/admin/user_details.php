<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <title>Détails de l'utilisateur</title>
</head>
<body>
    <div>
        <h2>Détails de l'utilisateur</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (isset($userInfo) && $userInfo): ?>
            <table border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <th>Identifiant</th>
                    <td><?php echo htmlspecialchars($userInfo['user_id']); ?></td>
                </tr>
                <tr>
                    <th>Nom d'utilisateur</th>
                    <td><?php echo htmlspecialchars($userInfo['username']); ?></td>
                </tr>
                <tr>
                    <th>Prénom</th>
                    <td><?php echo htmlspecialchars($userInfo['prenom']); ?></td>
                </tr>
                <tr>
                    <th>Nom</th>
                    <td><?php echo htmlspecialchars($userInfo['nom']); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($userInfo['email']); ?></td>
                </tr>
                <tr>
                    <th>Téléphone</th>
                    <td><?php echo htmlspecialchars($userInfo['telephone']); ?></td>
                </tr>
                <tr>
                    <th>Adresse</th>
                    <td><?php echo htmlspecialchars($userInfo['adresse']); ?></td>
                </tr>
                <tr>
                    <th>Image de profil</th>
                    <td>
                        <?php if ($userInfo['image_client'] !== '1'): ?>
                            <img src="public/images/<?php echo htmlspecialchars($userInfo['image_client']); ?>" alt="Image de profil" style="max-width: 100px;">
                        <?php else: ?>
                            Image par défaut
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Date d'inscription</th>
                    <td><?php echo htmlspecialchars($userInfo['date_inscription'] ?? 'N/A'); ?></td>
                </tr>
            </table>

            <h3>Avis</h3>
            <?php if (empty($avis)): ?>
                <p>Aucune Avis trouvée.</p>
            <?php else: ?>
                <table border="1" cellpadding="5" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Avis</th>
                            <th>Commentaire</th>
                            <th>Date</th>
                            <th>ID Plat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($avis as $remark): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($remark['avis_id']); ?></td>
                                <td><?php echo htmlspecialchars($remark['commentaire']); ?></td>
                                <td><?php echo htmlspecialchars($remark['date_avis']); ?></td>
                                <td><?php echo htmlspecialchars($remark['plat_id']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <p>
                <a href="index.php?page=user_edit&user_id=<?php echo $userInfo['user_id']; ?>">Modifier</a>
                &nbsp;|&nbsp;
                <a href="index.php?page=user_delete&user_id=<?php echo $userInfo['user_id']; ?>" onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">Supprimer</a>
            </p>
        <?php else: ?>
            <p>Aucun détail disponible pour cet utilisateur.</p>
        <?php endif; ?>

        <p><a href="index.php?page=user_info">Retour à la liste</a></p>
    </div>
</body>
</html>
