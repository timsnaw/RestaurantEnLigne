<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier la promotion</title>
    <style>
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
    <!-- Favicon -->
  <link href="/FastAndYumProject/FastAndYum/public/img/logo1.png" rel="icon" />

  <!-- Bootstrap CSS -->
  <link href="/FastAndYumProject/FastAndYum/public/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Custom CSS -->
  <link href="/fastandyam/FastAndYum/public/css/admin/promotion_edit.css" rel="stylesheet" />
</head>
<body>
    <div>
        <h2>Modifier la promotion</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <p style="color: red;"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <p><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></p>
        <?php endif; ?>
        <?php if ($promotionInfo): ?>
            <form method="POST" action="index.php?page=promotion_edit&promo_id=<?php echo htmlspecialchars($promotionInfo['promo_id']); ?>">
                <div>
                    <label>Plat</label>
                    <select name="plat_id" required>
                        <option value="">Choisir un plat</option>
                        <?php foreach ($plats as $plat): ?>
                            <option value="<?php echo htmlspecialchars($plat['plat_id']); ?>" 
                                    <?php echo $promotionInfo['plat_id'] == $plat['plat_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($plat['titre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label>Taux de réduction (%)</label>
                    <input type="number" step="0.01" name="taux_reduction" 
                           value="<?php echo htmlspecialchars($promotionInfo['taux_reduction']); ?>" required>
                </div>
                <div>
                    <label>Date de début</label>
                    <input type="date" name="date_debut" 
                           value="<?php echo htmlspecialchars($promotionInfo['date_debut']); ?>" required>
                </div>
                <div>
                    <label>Date de fin</label>
                    <input type="date" name="date_fin" 
                           value="<?php echo htmlspecialchars($promotionInfo['date_fin']); ?>" required>
                </div>
                <button type="submit">Modifier</button>
                <a href="index.php?page=promotion_info">Annuler</a>
            </form>
        <?php else: ?>
            <p>Promotion introuvable.</p>
            <a href="index.php?page=promotion_info">Retour</a>
        <?php endif; ?>
    </div>
</body>
</html>