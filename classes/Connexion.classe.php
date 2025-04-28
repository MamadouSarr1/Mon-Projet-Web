<?php
// ---------- Connexion.php ----------
class Connexion
{
    public function getConnexionBd(): PDO
    {
        $hote = 'localhost';
        $bd = 'sarrh25techinfo4_25mars2025';
        $usager = 'sarrh25techinfo4_ecrireSql';
        $motDePasse = 'Informatique.101';

        try {
            $dsn = "mysql:host=$hote;dbname=$bd;charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            return new PDO($dsn, $usager, $motDePasse, $options);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }
}

