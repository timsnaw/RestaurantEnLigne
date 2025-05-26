<!-- Navbar Start -->

    <header>
        <div>
            <a href="/FastAndYumProject/FastAndYum/index.php?url=home"><img src="/FastAndYumProject/FastAndYum/public/img/logo1.png" class="logo" alt="Logo">
</a>
        </div>

        <button class="nav-toggle" onclick="toggleNavbar()">☰</button>

        <nav id="navbar">
            <a href="/FastAndYumProject/FastAndYum/index.php?url=home">Accueil</a>

            <div class="dropdown" onclick="toggleDropdown(event)">
                <a href="/FastAndYumProject/FastAndYum/index.php?url=menu" class="dropdown-toggle">Menu</a>
                <div class="dropdown-menu">
                    <a href="/FastAndYumProject/FastAndYum/index.php?url=menu#tab-2" class="dropdown-link" data-tab="#tab-2">Tacos</a>
                    <a href="/FastAndYumProject/FastAndYum/index.php?url=menu#tab-1" class="dropdown-link" data-tab="#tab-1">Pizza</a>
                    <a href="/FastAndYumProject/FastAndYum/index.php?url=menu#tab-3" class="dropdown-link" data-tab="#tab-3">Burgers</a>
                    <a href="/FastAndYumProject/FastAndYum/index.php?url=menu#tab-4" class="dropdown-link" data-tab="#tab-4">Salades</a>
                    <a href="/FastAndYumProject/FastAndYum/index.php?url=menu#tab-5" class="dropdown-link" data-tab="#tab-5">Jus et Cocktails</a>
                </div>
            </div>

            <a href="index.php?url=Apropos">À propos</a>
            <a href="index.php?url=promotions">Promotions</a>
            <a href="index.php?url=contact">Contact</a>
<!--recherche-->
            <form class="search-form" action="#" method="get">
                <input type="text" name="q" class="search-input" placeholder="Rechercher...">
                <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
            </form>
<!--end recherche-->
            <a href="index.php?url=panier" class="btn btn-outline-secondary rounded-pill" style="margin-left: 10px;">
                <i class="fas fa-shopping-cart"></i> Panier
            </a>

            <a href="index.php?url=register" class="btn btn-outline-secondary rounded-pill" style="margin-left: 10px;">
                <i class="fas fa-user"></i> Register
            </a>
        </nav>
    </header>

    <!-- Navbar End -->
