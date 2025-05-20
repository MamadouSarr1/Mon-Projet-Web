<?php
session_start(); 

require_once __DIR__ . '/classes/sessionSet.include.php';
require_once __DIR__ . '/classes/SelectUtilisateur.php';
require_once __DIR__ . '/classes/fonctionsLogs.php';

$message = $_SESSION['error'] ?? '';
$successMessage = $_SESSION['success'] ?? '';
unset($_SESSION['error'], $_SESSION['success']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $motDePasse = filter_input(INPUT_POST, 'mot_de_passe', FILTER_DEFAULT);

    if ($email && $motDePasse) {
        $selectUser = new SelectUtilisateur($email);
        $utilisateur = $selectUser->select();

        if ($utilisateur && password_verify($motDePasse, $utilisateur->getMdp())) {
            $_SESSION['auth'] = true;
            $_SESSION['email'] = $utilisateur->getCourriel();
            $_SESSION['nom'] = $utilisateur->getNom();
            $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['role'] = method_exists($utilisateur, 'getRole') ? $utilisateur->getRole() : 'user';

            journaliser("acces-reussis.log", "Connexion réussie : $email - IP : " . $_SERVER['REMOTE_ADDR']);

            if ($_SESSION['role'] === 'admin') {
                header("Location: admin.php");
            } else {
                $_SESSION['reservation_access'] = true;
                $_SESSION['welcome'] = "Bienvenue " . $_SESSION['nom'] . ", vous êtes connecté !";
                header("Location: mes_reservations.php");
            }
            exit;
        } else {
            journaliser("acces-refuses.log", "Échec de connexion : $email - IP : " . $_SERVER['REMOTE_ADDR']);
            $_SESSION['error'] = "Identifiants incorrects.";
            header("Location: login.php");
            exit;
        }
    } else {
        $message = "Veuillez remplir tous les champs correctement.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
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
            <li><a href="login.php" class="active">Connexion</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="section-center" id="connexion">
        <div class="form-container">
            <h2>Connexion utilisateur</h2>

            <?php if (!empty($successMessage)) : ?>
                <div class="success"><?= htmlspecialchars($successMessage) ?></div>
            <?php endif; ?>

            <?php if (!empty($message)) : ?>
                <div class="erreur"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <form method="post" class="login-form">
                <label for="email">Adresse courriel :</label>
                <input type="email" name="email" id="email" required>

                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" name="mot_de_passe" id="mot_de_passe" required>

                <button type="submit" class="btn">Se connecter</button>
            </form>

            <p>Pas encore de compte ? <a href="inscription.php">Inscrivez-vous</a></p>
        </div>
    </section>
</main>

</body>
</html>
