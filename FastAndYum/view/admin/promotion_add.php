<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une promotion</title>
    
       <!-- Favicon -->
  <link href="public/img/logo1.png" rel="icon" />

  <!-- Bootstrap CSS -->
  <link href="public/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Custom CSS -->
  <link href="public/css/admin/promotion_add.css" rel="stylesheet" />
</head>
<body>
    <div>
        <h2>Ajouter une promotion</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <p style="color: red;"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <p><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></p>
        <?php endif; ?>
        
        <form method="POST" action="index.php?page=promotion_add">
            <div>
                <label>Plat</label>
                <select name="plat_id" required>
                    <option value="">Choisir un plat</option>
                    <?php foreach ($plats as $plat): ?>
                        <option value="<?php echo htmlspecialchars($plat['plat_id']); ?>">
                            <?php echo htmlspecialchars($plat['titre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label>Taux de réduction (%)</label>
                <input type="number" step="0.01" name="taux_reduction" required>
            </div>
            
            <div>
                <label>Date de début</label>
                <input type="date" name="date_debut" required>
            </div>
            
            <div>
                <label>Date de fin</label>
                <input type="date" name="date_fin" required>
            </div>
            
            <button type="submit">Ajouter</button>
            <a href="index.php?page=promotion_info">Annuler</a>
        </form>
    </div>
</body>
</html>