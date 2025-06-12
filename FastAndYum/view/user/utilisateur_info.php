<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profil Utilisateur</title>

    <!-- Favicon -->
    <link href="public/img/logo1.png" rel="icon" />

    <!-- Libraries -->
    <link href="public/lib/animate/animate.min.css" rel="stylesheet" />
    <link href="public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

    <!-- Bootstrap -->
    <link href="public/css/bootstrap.min.css" rel="stylesheet" />
 <link href="public/css/user/user_info.css" rel="stylesheet"> 
    <!-- Custom CSS -->
    <link href="public/css/fastyum.css" rel="stylesheet" />

    
</head>
<body class="user_details">

<div class="card-custom">

    <h2>Profil de l'utilisateur</h2>

    <div class="profile-section">


        <div class="profile-left">
            <img
                class="profile-img"
                src="./public/img/<?php echo htmlspecialchars($user['image_client'] ?? 'default.png'); ?>"
                alt="Image de profil"
                width="150" height="150"
            />
            <a href="index.php?page=utilisateur_edit" class="btn-orange">Modifier le profil</a>
        </div>

        <!-- Colonne droite : nom + username + tableau infos -->
        <div class="profile-right">
            <div class="name">
                <?php echo htmlspecialchars($user['prenom'] ?? 'Prénom non défini') . ' ' . htmlspecialchars($user['nom'] ?? 'Nom non défini'); ?>
            </div>
            <div class="username">
                @<?php echo htmlspecialchars($user['username']); ?>
            </div>

            <div class="table-responsive">
                <table>
                    <tbody>
                    <tr>
                        <th>Email</th>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Téléphone</th>
                        <td><?php echo htmlspecialchars($user['telephone'] ?? 'Non défini'); ?></td>
                    </tr>
                    <tr>
                        <th>Adresse</th>
                        <td><?php echo htmlspecialchars($user['adresse'] ?? 'Non définie'); ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Messages session -->
    <?php if (isset($_SESSION['message'])): ?>
        <p class="session-message success"><?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?></p>
    <?php elseif (isset($_SESSION['error'])): ?>
        <p class="session-message error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
    <?php endif; ?>

</div>

<script src="public/js/bootstrap.bundle.min.js"></script>
</body>
</html>
