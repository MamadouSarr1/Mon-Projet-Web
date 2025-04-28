<?php
require_once __DIR__ . '/classes/sessionSet.include.php';
session_start();

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header("Location: login.php");
    exit;
}

$nom = htmlspecialchars($_SESSION['nom']);
$email = htmlspecialchars($_SESSION['email']);
$role = $_SESSION['role'] ?? 'user';

$host = "localhost";
$dbname = "sarrh25techinfo4_25mars2025";
$username = "sarrh25techinfo4_ecrireSql";
$password = "Informatique.101";

$reservations = [];

if ($role === 'admin') {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->query("SELECT * FROM reservations ORDER BY id DESC");
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $erreur = "Erreur : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Réservations</title>
    <link rel="stylesheet" href="styles.css"> <!-- ✅ Lien vers ton fichier CSS -->
</head>
<body>

<header>
    <nav class="navbar">
        <div class="logo">
            <img src="logo2-2.png" alt="Logo" class="logoImage">
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </nav>
</header>

<main class="admin-page">
<section class="section espace-sup">

        <div class="form-container">
            <h2>Bienvenue, <?= $nom ?> !</h2>
            <p>Adresse courriel : <?= $email ?></p>
            <p>Vous êtes maintenant dans l’espace sécurisé d’administration.</p>
        </div>
    </section>

    <?php if ($role === 'admin'): ?>
        <section class="section espace-sup">

            <div class="form-container">
                <h2>Réservations enregistrées</h2>

                <?php if (!empty($reservations)): ?>
                    <table class="destination-table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Destination</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservations as $res): ?>
                                <tr>
                                    <td><?= htmlspecialchars($res['nom']) ?></td>
                                    <td><?= htmlspecialchars($res['email']) ?></td>
                                    <td><?= htmlspecialchars($res['destination']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Aucune réservation enregistrée.</p>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>
</main>

</body>
</html>
