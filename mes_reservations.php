<?php
require_once __DIR__ . '/classes/sessionSet.include.php';
require_once __DIR__ . '/classes/SelectUtilisateur.php';
require_once __DIR__ . '/config.php'; 

session_start();

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header("Location: login.php");
    exit;
}

$email = filter_var($_SESSION['email'], FILTER_SANITIZE_EMAIL);
$nom = htmlspecialchars($_SESSION['nom']);
$reservations = [];
$erreur = null;

try {
    $stmt = $pdo->prepare("SELECT destination FROM reservations WHERE email = :email ORDER BY id DESC");
    $stmt->execute([':email' => $email]);

    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $erreur = "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Réservations</title>
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

<main class="section">
    <div class="form-container">
        <h2>Mes Réservations</h2>
        <p>Bienvenue, <strong><?= $nom ?></strong> ! Voici vos destinations réservées :</p>

        <?php if ($erreur): ?>
            <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
        <?php elseif (!empty($reservations)): ?>
            <ul>
                <?php foreach ($reservations as $res): ?>
                    <li><?= htmlspecialchars($res['destination']) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Vous n'avez encore effectué aucune réservation.</p>
        <?php endif; ?>

        <a class="btn" href="index.php">Retour à l'accueil</a>
    </div>
</main>
</body>
</html>
