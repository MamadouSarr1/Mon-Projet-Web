<?php
$host = "localhost";
$dbname = "sarrh25techinfo4_25mars2025";
$username = "sarrh25techinfo4_ecrireSql";
$password = "Informatique.101";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    echo "Connexion réussie à la base de données.";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
