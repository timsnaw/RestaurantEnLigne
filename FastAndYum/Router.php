<?php

class Router {
    public static function route($view) {
        $viewPath = "view/{$view}.php";

        if (file_exists($viewPath)) {
            require_once($viewPath);
        } else {
            echo "404 - Page not found";
        }
    }
}
 
