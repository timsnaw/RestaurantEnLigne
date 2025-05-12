<?php
// data base configuration 
$host = 'localhost';
$dbname = 'fastandyam';
$username = 'root';
$password = '';
// exception au cas d'error de connexion 
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Échec de la connexion a la base de données : " . $e->getMessage());
}
?>