<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./public/css/bootstrap.min.css">
    <link rel="stylesheet" href="./public/css/admin.css">
    <title>Administration</title>
</head>
<body>
    <div class="menu">
        <a href="index.php?page=statistique" target="content-frame"><h2>Administration</h2></a>
        <ul>
        <li><a href="index.php?page=admin_info" target="content-frame">Informations Administrateur</a></li>
        <li><a href="index.php?page=user_info" target="content-frame">Informations Utilisateur</a></li>
        <li><a href="index.php?page=categorie_info" target="content-frame">Informations Catégorie</a></li>
        <li><a href="index.php?page=commandes_info" target="content-frame">Informations Commandes</a></li>
        <li><a href="index.php?page=plats" target="content-frame">Informations Plats</a></li>
        <li><a href="index.php?page=promotion_info" target="content-frame">Informations Promotion</a></li>
    </ul>
    <a href="index.php?page=logout" class="btn btn-danger" style="width: 100%;">Déconnecter</a>
    </div>
    <div class="content">
        <iframe name="content-frame" src="index.php?page=statistique"></iframe>
    </div>
</body>
</html>
