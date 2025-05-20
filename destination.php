<?php
require_once __DIR__ . '/config.php'; // contient ma connexion PDO

try {
    $stmt = $pdo->query("SELECT id, nom, image, description FROM destinations");
    $destinations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p style='color:red; text-align:center;'>Erreur de connexion : " . htmlspecialchars($e->getMessage()) . "</p>";
    $destinations = [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinations Touristiques</title>
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
            <li><a href="destination.php" class="active">Destinations</a></li>
            <li><a href="reservation.php">Réservation</a></li>
            <li><a href="galerie.html">Galerie</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>
</header>

<main>
    <section id="destinations" class="section">
        <div class="container">
            <h2 class="section-title">Découvrez les plus belles destinations du Sénégal</h2>
            <p class="section-description">Explorez les merveilles du Sénégal à travers nos destinations incontournables.</p>
            <div id="index-destination-list" class="destination-list">
            <?php foreach ($destinations as $destination) : ?>
                <a href="destination_details.php?destination=<?= urlencode($destination['id']) ?>" 
                class="destination-card" 
                style="background-image: url('images/<?= htmlspecialchars($destination['image']) ?>');">
                    <h3><?= htmlspecialchars($destination['nom']) ?></h3>
                    <p><?= htmlspecialchars(mb_strimwidth($destination['description'], 0, 100, "...")) ?></p>
                </a>
            <?php endforeach; ?>

            </div>
        </div>
    </section>
</main>

<footer>
    <p>&copy; 2025 SenegalVoyages - Tous droits réservés</p>
</footer>

</body>
</html>
