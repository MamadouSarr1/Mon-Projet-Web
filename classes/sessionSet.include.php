<?php
// ---------- sessionSet.include.php ----------

// Configuration : Ne pas afficher les erreurs à l'écran, mais les journaliser

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/home/sarrh25techinfo4/logs/sarr_h25_techinfo420_ca.php.error.log');
error_reporting(E_ALL); 


define("DUREE_SESSION", time() + 60 * 60); 

require_once __DIR__ . '/GestionnaireSessionBD.php';

// Connexion à la base de données
$host = "localhost";
$dbname = "sarrh25techinfo4_25mars2025";
$username = "sarrh25techinfo4_ecrireSql";
$password = "Informatique.101";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Erreur PDO : " . $e->getMessage());
    die("Une erreur est survenue."); 
}

// Vérifiez si une session est déjà active
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.use_strict_mode', 1);
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', 1); 
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_lifetime', 0);
    ini_set('session.gc_maxlifetime', 1440);

    session_name('my_secure_session');
    session_start();
}
?>
