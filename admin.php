<?php
require_once __DIR__ . '/classes/sessionSet.include.php';
require_once __DIR__ . '/config.php'; 
session_start();

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true || ($_SESSION['role'] ?? 'user') !== 'admin') {
    header("Location: login.php");
    exit;
}

$nom = htmlspecialchars($_SESSION['nom']);
$email = htmlspecialchars($_SESSION['email']);

$reservations = [];
$erreur = null;

try {
    $stmt = $pdo->query("SELECT * FROM reservations ORDER BY id DESC");
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $erreur = "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Réservations</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>

<header>
    <nav class="navbar">
        <div class="logo">
            <img src="images/logo2-2.png" alt="Logo" class="logoImage">
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

    <section class="section espace-sup">
        <div class="form-container">
            <h2>Réservations enregistrées</h2>

            <?php if ($erreur): ?>
                <p style="color: red;"><?= htmlspecialchars($erreur) ?></p>
            <?php elseif (!empty($reservations)): ?>
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
</main>

</body>
</html>
