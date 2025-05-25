<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateur</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <!-- Style pour la page utilisateur -->
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
        }

        .menu {
            width: 250px;
            background-color: #f8f9fa;
            padding: 20px;
            border-right: 1px solid #ddd;
        }

        .menu h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .menu ul {
            list-style-type: none;
            padding-left: 0;
        }

        .menu ul li {
            margin-bottom: 10px;
        }

        .menu a {
            text-decoration: none;
            color: #333;
        }

        .menu a:hover {
            text-decoration: underline;
        }

        .content {
            flex: 1;
            padding: 20px;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body>
    <div class="menu">
        <a href="index.php?page=utilisateur_info" target="content-frame"><h2>Utilisateur</h2></a>
        <ul>
            <li><a href="index.php?page=utilisateur_info" target="content-frame">Informations utilisateur</a></li>
            <li><a href="index.php?page=commande_user_info" target="content-frame">Mes commandes</a></li>
        </ul>
        <a href="index.php?page=logout_user" class="btn btn-danger" style="width: 100%;">Déconnecter</a>
    </div>
    <div class="content">
        <iframe name="content-frame" src="index.php?page=utilisateur_info"></iframe>
    </div>
</body>
</html>
