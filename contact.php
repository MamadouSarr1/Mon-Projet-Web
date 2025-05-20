<?php
require_once 'config.php';

$message = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nom = htmlspecialchars(trim($_POST["nom"]));
        $email = htmlspecialchars(trim($_POST["email"]));
        $contenu = htmlspecialchars(trim($_POST["message"]));

        $sql = "INSERT INTO messages_contact (nom, email, message) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $email, $contenu]);

        $message = "<span style='color:green;'>Votre message a été envoyé avec succès.</span>";
    }
} catch (PDOException $e) {
    $message = "<span style='color:red;'>Erreur : " . $e->getMessage() . "</span>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - SenegalVoyages</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <img class="logoImage" src="images/logo2-2.png" alt="SenegalVoyages Logo" />
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

    <section id="contact" class="section">
        <h2>Contactez-nous</h2>
        <p>Pour toute question, écrivez-nous à <strong>contact@senegalvoyages.com</strong> ou remplissez le formulaire ci-dessous :</p>

        <form method="POST" action="contact.php" id="contact-form">
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" placeholder="Votre nom complet" required>
            </div>

            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" placeholder="Votre email" required>
            </div>

            <div class="form-group">
                <label for="message">Message :</label>
                <textarea id="message" name="message" placeholder="Votre message" required></textarea>
            </div>

            <button type="submit">Envoyer</button>
        </form>

        <div id="responseMessage">
            <?php if (!empty($message)) echo $message; ?>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 SenegalVoyages - Tous droits réservés</p>
    </footer>
</body>
</html>
