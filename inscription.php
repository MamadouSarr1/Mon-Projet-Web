<?php
require_once __DIR__ . '/classes/sessionSet.include.php';
require_once __DIR__ . '/classes/Connexion.classe.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $motDePasse = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

    try {
        $connexion = (new Connexion())->getConnexionBd();

        $stmt = $connexion->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe, date_creation) VALUES (:nom, :email, :mdp, NOW())");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mdp', $motDePasse);

        if ($stmt->execute()) {
            $message = "Compte créé avec succès ! Vous pouvez maintenant vous connecter.";
        } else {
            $message = "Erreur lors de la création du compte.";
        }
    } catch (Exception $e) {
        $message = "Erreur : " . $e->getMessage();
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
            <img class="logoImage" src="logo2-2.png" alt="SenegalVoyages Logo" />
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
                <div class="erreur"><?= htmlspecialchars($message) ?></div>
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
