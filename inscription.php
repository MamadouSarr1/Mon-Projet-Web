<?php
require_once __DIR__ . '/classes/sessionSet.include.php';
require_once __DIR__ . '/classes/Connexion.classe.php';
require_once __DIR__ . '/classes/fonctionsLogs.php';

session_start();
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $mot = filter_input(INPUT_POST, 'mot_de_passe', FILTER_UNSAFE_RAW);

    if (!$email || !$nom || !$mot) {
        $message = "Veuillez fournir des informations valides.";
    } else {
        try {
            $connexion = (new Connexion())->getConnexionBd();

            // Vérifie si l'email existe déjà
            $stmt = $connexion->prepare("SELECT COUNT(*) FROM utilisateurs WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetchColumn() > 0) {
                $message = "Cette adresse courriel est déjà utilisée.";
            } else {
                // Insère l'utilisateur
                $motDePasse = password_hash($mot, PASSWORD_DEFAULT);
                $insert = $connexion->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe, date_creation) VALUES (?, ?, ?, NOW())");
                $insert->execute([$nom, $email, $motDePasse]);

                journaliser("insertion-bd.log", "Nouvelle inscription : $email ($nom)");

                $_SESSION['success'] = "Compte créé avec succès ! Vous pouvez maintenant vous connecter.";
                header("Location: login.php");
                exit;
            }
        } catch (Exception $e) {
            $message = "Erreur : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - SenegalVoyages</title>
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
            <li><a href="login.php">Connexion</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="section-center" id="inscription">
        <div class="form-container">
            <h2>Créer un compte</h2>

            <?php if (!empty($message)) : ?>
                <div class="<?= str_contains($message, 'succès') ? 'success' : 'erreur' ?>">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="inscription.php" class="login-form">
                <label for="nom">Nom complet :</label>
                <input type="text" name="nom" id="nom" required placeholder="Votre nom complet">

                <label for="email">Email :</label>
                <input type="email" name="email" id="email" required placeholder="Votre email">

                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" name="mot_de_passe" id="mot_de_passe" required placeholder="Mot de passe">

                <button type="submit" class="btn">S'inscrire</button>
            </form>

            <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
        </div>
    </section>
</main>
</body>
</html>
