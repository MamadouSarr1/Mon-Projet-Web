<?php
define("DB_HOST", "localhost");
define("DB_NAME", "sarrh25techinfo4_25mars2025");
define("DB_USER", "sarrh25techinfo4_ecrireSql");
define("DB_PASS", "Informatique.101");


$host = 'localhost';
$dbname = 'sarrh25techinfo4_25mars2025';
$username = 'sarrh25techinfo4_ecrireSql';
$password = 'Informatique.101';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
