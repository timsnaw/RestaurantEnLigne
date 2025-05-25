<?php
require 'Router.php';

$url = $_GET['url'] ?? 'home'; 
Router::route($url);

