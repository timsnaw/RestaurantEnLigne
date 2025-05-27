<!-- Navbar Start -->

    <header>
        <div>
            <a href="index.php?page=home"><img src="public/img/logo1.png" class="logo" alt="Logo">
</a>
        </div>

        <button class="nav-toggle" onclick="toggleNavbar()">☰</button>

        <nav id="navbar">
            <a href="index.php?page=home">Accueil</a>

            <div class="dropdown" onclick="toggleDropdown(event)">
                <a href="index.php?page=menu#tab-12" class="dropdown-toggle">Menu</a>
                <div class="dropdown-menu">
                    <?php foreach ($categories as $index => $categorie): ?>
                            <li class="nav-item">
                                <a class="dropdown-link" <?php echo $index === 0 ? 'active' : ''; ?> 
                                   href="index.php?page=menu#tab-<?php echo htmlspecialchars($categorie['categorie_id']); ?>">
                                    <?php echo htmlspecialchars($categorie['nom_categorie']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                </div>
            </div>

            <a href="index.php?page=Apropos">À propos</a>
            <a href="index.php?page=promotions">Promotions</a>
            <a href="index.php?page=contact">Contact</a>
<!--recherche-->
            <form class="search-form" action="#" method="get">
                <input type="text" name="q" class="search-input" placeholder="Rechercher...">
                <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
            </form>
<!--end recherche-->
            <a href="index.php?page=panier" class="btn btn-outline-secondary rounded-pill" style="margin-left: 10px;">
                <i class="fas fa-shopping-cart"></i> Panier
            </a>
            <?php if (!isset($_SESSION['user_id'])): ?>
             <a href="index.php?page=connexion" class="btn btn-outline-secondary rounded-pill" style="margin-left: 10px;">
                            <i class="fas fa-user"></i> connexion
                        </a>
            <?php else: ?>
                <a href="index.php?page=userPage" class="btn btn-outline-secondary rounded-pill" style="margin-left: 10px;">Mon Compte</a>
            <?php endif; ?>

        </nav>
    </header>

    <!-- Navbar End -->
