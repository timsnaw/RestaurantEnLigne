<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Informations de commande</title>
</head>
<body>
    <div>
        <h2>Informations de commande</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <p style="color:red;"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <p style="color:green;"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></p>
        <?php endif; ?>
        <form method="GET" action="">
            <input type="hidden" name="page" value="commandes_info">
            <div>
                <div style="width:40%;">
                    <label>Rechercher par ID de commande :</label>
                    <input type="text" name="search_commande_id" value="<?php echo isset($_GET['search_commande_id']) ? htmlspecialchars($_GET['search_commande_id']) : ''; ?>">
                </div>
                <div>
                    <input type="submit" value="Rechercher">
                </div>
            </div>
        </form>
        <form method="GET" action="index.php">
            <input type="hidden" name="page" value="commandes_info">
            <div>
                <div style="width:25%;">
                    <label>Filtrer par état :</label>
                    <select name="etat_commande">
                        <option value="">Tous</option>
                        <option value="1" <?php echo isset($_GET['etat_commande']) && $_GET['etat_commande'] == 1 ? 'selected' : ''; ?>>En cours</option>
                        <option value="2" <?php echo isset($_GET['etat_commande']) && $_GET['etat_commande'] == 2 ? 'selected' : ''; ?>>En livraison</option>
                        <option value="3" <?php echo isset($_GET['etat_commande']) && $_GET['etat_commande'] == 3 ? 'selected' : ''; ?>>Livrée</option>
                        <option value="4" <?php echo isset($_GET['etat_commande']) && $_GET['etat_commande'] == 4 ? 'selected' : ''; ?>>Annulée</option>
                    </select>
                </div>
                <div style="width:25%;">
                    <label>Filtrer par période :</label>
                    <select name="period" onchange="this.form.submit()">
                        <option value="day" <?php echo isset($_GET['period']) && $_GET['period'] == 'day' ? 'selected' : ''; ?>>Jour</option>
                        <option value="month" <?php echo isset($_GET['period']) && $_GET['period'] == 'month' ? 'selected' : ''; ?>>Mois</option>
                        <option value="year" <?php echo isset($_GET['period']) && $_GET['period'] == 'year' ? 'selected' : ''; ?>>Année</option>
                    </select>
                </div>
                <div style="width:15%;">
                    <label>Année :</label>
                    <select name="filter_year">
                        <?php
                        $current_year = date('Y');
                        $selected_year = isset($_GET['filter_year']) ? $_GET['filter_year'] : $current_year;
                        for ($y = $current_year - 5; $y <= $current_year + 5; $y++):
                        ?>
                            <option value="<?php echo $y; ?>" <?php echo $selected_year == $y ? 'selected' : ''; ?>><?php echo $y; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <?php
                $selected_period = isset($_GET['period']) ? $_GET['period'] : 'day';
                $selected_month = isset($_GET['filter_month']) ? $_GET['filter_month'] : ($selected_period == 'day' || $selected_period == 'month' ? date('m') : '');
                $selected_day = isset($_GET['filter_day']) ? $_GET['filter_day'] : ($selected_period == 'day' ? date('d') : '');
                ?>
                <?php if ($selected_period == 'month' || $selected_period == 'day'): ?>
                    <div style="width:15%;">
                        <label>Mois :</label>
                        <select name="filter_month">
                            <?php for ($m = 1; $m <= 12; $m++): ?>
                                <option value="<?php echo sprintf('%02d', $m); ?>" <?php echo $selected_month == sprintf('%02d', $m) ? 'selected' : ''; ?>><?php echo sprintf('%02d', $m); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                <?php endif; ?>
                <?php if ($selected_period == 'day'): ?>
                    <div style="width:15%;">
                        <label>Jour :</label>
                        <select name="filter_day">
                            <?php for ($d = 1; $d <= 31; $d++): ?>
                                <option value="<?php echo sprintf('%02d', $d); ?>" <?php echo $selected_day == sprintf('%02d', $d) ? 'selected' : ''; ?>><?php echo sprintf('%02d', $d); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                <?php endif; ?>
                <div>
                    <input type="submit" value="Filtrer">
                </div>
            </div>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>État</th>
                    <th>Paiement</th>
                    <th>Adresse de livraison</th>
                    <th>ID client</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($commandes)): ?>
                    <tr>
                        <td colspan="7">Aucune commande trouvée.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($commandes as $commande): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($commande['commande_id']); ?></td>
                            <td><?php echo htmlspecialchars($commande['date_commande'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($commande['etat_label']); ?></td>
                            <td><?php echo htmlspecialchars($commande['paiement_status']); ?></td>
                            <td><?php echo htmlspecialchars($commande['adresse']); ?></td>
                            <td><?php echo htmlspecialchars($commande['user_id']); ?></td>
                            <td>
                                <a href="index.php?page=commandes_details&commande_id=<?php echo $commande['commande_id']; ?>">Voir</a>
                                <a href="index.php?page=commandes_delete&commande_id=<?php echo $commande['commande_id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>