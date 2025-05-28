<?php

class Router {
    public static function route($view) {
        $basePath = "view/";

        // ✅ Vérifie si c'est un fichier direct (view/home.php)
        if (file_exists($basePath . $view . ".php")) {
            require_once($basePath . $view . ".php");
            return;
        }

        // ✅ Vérifie si c'est un chemin avec sous-dossier (view/admin/dashboard.php)
        $nestedPath = $basePath . $view;
        if (file_exists($nestedPath)) {
            require_once($nestedPath);
            return;
        }

        // ❌ Sinon, 404
        echo "404 - Page '{$view}' not found";
    }
}
