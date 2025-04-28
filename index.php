<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SenegalVoyages - Explorez le Sénégal</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <nav>
        <div class="logo">
            <img class="logoImage" src="logo2-2.png" alt="SenegalVoyages Logo" />
        </div>
        <ul>
            <li><a href="#accueil">Accueil</a></li>
            <li><a href="#destinations">Destinations</a></li>
            <li><a href="#reservation">Réservation</a></li>
            <li><a href="galerie.html">Galerie</a></li>
            <li><a href="contact.php">Contact</a></li>

            <?php if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true): ?>
                <li><a href="inscription.php">Inscription</a></li>
                <li><a href="login.php">Connexion</a></li>
            <?php else: ?>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <li><a href="admin.php">Administration</a></li>
                <?php endif; ?>
                <li><a href="logout.php">Déconnexion</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<!-- Section Accueil -->
<section id="accueil" class="hero">
    <div class="video-background">
        <video id="backgroundVideo" muted loop>
            <source src="video1.mp4" type="video/mp4">
        </video>
    </div>
    <div class="hero-content">
        <h1>Vivez l'Afrique, Découvrez le Sénégal</h1>
        <p>Explorez les plus belles destinations et réservez votre aventure en toute simplicité.</p>
        <a href="#presentationVideo" class="btn" id="playPresentationButton">Voir la vidéo de présentation</a>
        <video id="presentationVideo" controls width="100%" style="display: none;">
            <source src="presentation.mp4" type="video/mp4">
        </video>
    </div>
</section>

<?php if (!empty($_SESSION['welcome'])): ?>
    <div class="response-message success" style="color: green; font-weight: bold; margin-bottom: 15px;">
        <?= $_SESSION['welcome']; ?>
    </div>
    <?php unset($_SESSION['welcome']); ?>
<?php endif; ?>

<?php
$host = "localhost";
$dbname = "sarrh25techinfo4_25mars2025";
$username = "sarrh25techinfo4_ecrireSql";
$password = "Informatique.101";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT id, nom, image, description FROM destinations LIMIT 5");
    $destinations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erreur : " . $e->getMessage() . "</p>";
    $destinations = [];
}
?>

<!-- Section Destinations -->
<section id="destinations" class="section">
    <h2>Destinations Populaires</h2>
    <div id="index-destination-list" class="destination-list">
        <?php foreach ($destinations as $destination): ?>
            <a href="destination_details.php?destination=<?= $destination['id'] ?>" 
               class="destination-card" 
               style="background-image: url('<?= htmlspecialchars($destination['image']) ?>');">
                <h3><?= htmlspecialchars($destination['nom']) ?></h3>
                <p><?= htmlspecialchars($destination['description']) ?></p>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<!-- Section Réservation -->
<section id="reservation" class="section" <?= isset($_SESSION['reservation_access']) ? 'style="scroll-margin-top:120px;"' : '' ?>>
    <h2>Réservez Votre Aventure</h2>
    <?php if (!empty($_SESSION['confirmation'])): ?>
    <div class="response-message success" style="color: green; font-weight: bold; margin-bottom: 15px;">
        <?= $_SESSION['confirmation']; ?>
    </div>
    <?php unset($_SESSION['confirmation']); ?>
    <?php endif; ?>

    <?php if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true): ?>
        <p style="color: red; font-weight: bold; margin-top: 20px;">
            Vous devez être connecté pour réserver une aventure. <a href="login.php" style="color: blue;">Connectez-vous ici</a> ou <a href="inscription.php" style="color: blue;">inscrivez-vous</a> pour commencer.
        </p>
        <?php unset($_SESSION['reservation_access']); ?>
    <?php else: ?>
        <form id="reservation-form" method="POST" action="reservation.php">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($_SESSION['nom']) ?>" readonly required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($_SESSION['email']) ?>" readonly required>

            <label for="destination">Choisissez une destination :</label>
            <select id="destination" name="destination">
                <option value="Dakar">Dakar</option>
                <option value="Saly">Saly</option>
                <option value="Saint-Louis">Saint-Louis</option>
                <option value="Îles">Îles</option>
                <option value="Parcs">Parcs</option>
            </select>

            <button type="submit">Réserver</button>
        </form>
        <div id="responseMessage"></div>
    <?php endif; ?>
</section>

<!-- Section Contact -->
<section id="contact" class="section">
    <h2>Contactez-nous</h2>
    <p>Pour toute question, écrivez-nous à <strong>contact@senegalvoyages.com</strong></p>
</section>

<footer>
    <p>&copy; 2025 SenegalVoyages - Tous droits réservés</p>
</footer>

<script>
    document.getElementById('playPresentationButton').addEventListener('click', function(event) {
        event.preventDefault();
        var video = document.getElementById('presentationVideo');
        var backgroundVideo = document.getElementById('backgroundVideo');
        var button = document.getElementById('playPresentationButton');
        backgroundVideo.style.display = 'none';
        video.style.display = 'block';
        video.play();
        button.textContent = 'Retour à la vidéo d\'accueil';
        button.removeEventListener('click', playPresentationVideo);
        button.addEventListener('click', returnToBackgroundVideo);
    });

    function returnToBackgroundVideo(event) {
        var video = document.getElementById('presentationVideo');
        var backgroundVideo = document.getElementById('backgroundVideo');
        var button = document.getElementById('playPresentationButton');
        video.pause();
        video.style.display = 'none';
        backgroundVideo.style.display = 'block';
        backgroundVideo.play();
        button.textContent = 'Voir la vidéo de présentation';
        button.removeEventListener('click', returnToBackgroundVideo);
        button.addEventListener('click', playPresentationVideo);
    }
    <?php if (isset($_SESSION['reservation_access'])): ?>
            window.onload = () => {
                document.getElementById("reservation")?.scrollIntoView({ behavior: "smooth" });
            };
        <?php 
            unset($_SESSION['reservation_access']); 
        endif; ?>
</script>
</body>
</html>
