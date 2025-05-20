<?php
require_once __DIR__ . '/classes/sessionSet.include.php';
require_once __DIR__ . '/classes/SelectUtilisateur.php';
require_once 'config.php';
session_start();

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Sécurisation de l'entrée GET
    $id = filter_input(INPUT_GET, 'destination', FILTER_VALIDATE_INT);
    if (!$id) {
        echo "<p style='color:red;text-align:center;'>Destination invalide.</p>";
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM destinations WHERE id = ?");
    $stmt->execute([$id]);
    $destination = $stmt->fetch();

    if (!$destination) {
        echo "<p style='color:red;text-align:center;'>Destination non trouvée.</p>";
        exit;
    }

} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails - <?= htmlspecialchars($destination["nom"]) ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <nav class="navbar">
        <div class="logo">
            <img class="logoImage" src="images/logo2-2.png" alt="SenegalVoyages Logo">
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="destination.php">Destinations</a></li>
            <li><a href="reservation.php">Réservation</a></li>
            <li><a href="galerie.html">Galerie</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>
</header>

<main>
    <section id="destination-details">
    <img src="images/<?= htmlspecialchars($destination['image']) ?>" alt="Image de la destination">

        <div class="description">
            <p><?= nl2br(htmlspecialchars($destination['description'])) ?></p>
            <a href="index.php#destinations">← Retour aux destinations</a>
        </div>

        <?php if (!empty($_SESSION['auth']) && $_SESSION['auth'] === true): ?>
            <form id="reservation-form" method="POST" action="reservation.php" style="margin-top: 20px;">
                <input type="hidden" name="destination_id" value="<?= htmlspecialchars($destination['id']) ?>">
                <input type="hidden" name="nom" value="<?= htmlspecialchars($_SESSION['nom']) ?>">
                <input type="hidden" name="email" value="<?= htmlspecialchars($_SESSION['email']) ?>">
                <button type="submit" style="padding: 10px 20px; background-color: green; color: white; border: none; cursor: pointer;">
                    Réserver cette destination
                </button>
            </form>
        <?php else: ?>
            <p style="color: red; margin-top: 20px;">
                Vous devez être connecté pour réserver cette destination. <a href="login.php">Connectez-vous ici</a>.
            </p>
        <?php endif; ?>
    </section>
</main>

<footer style="text-align:center; padding:20px; background:#333; color:white;">
    &copy; 2025 SenegalVoyages - Tous droits réservés
</footer>

</body>
</html>
