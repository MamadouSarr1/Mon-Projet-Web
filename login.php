<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ob_start(); // Démarre un tampon de sortie


require_once __DIR__ . '/classes/sessionSet.include.php';
require_once __DIR__ . '/classes/SelectUtilisateur.php';

$message = "";

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

            // Redirection selon le rôle
            if ($_SESSION['role'] === 'admin') {
                header("Location: admin.php");
            } else {
                $_SESSION['reservation_access'] = true;
                header("Location: index.php#reservation");
            }
            exit;
        } else {
            $logPath = __DIR__ . "/logs/login.log";
            if (!is_dir(dirname($logPath))) {
                mkdir(dirname($logPath), 0777, true);
            }
            error_log("[" . date("d/m/Y H:i:s") . "] Login invalide pour $email - IP: " . $_SERVER['REMOTE_ADDR'] . "\n", 3, $logPath);
            $_SESSION['error'] = "Identifiants incorrects.";
            header('Location: login.php');
            exit;
        }
    } else {
        $message = "Champs invalides.";
    }
}

ob_end_flush(); // Vide le tampon de sortie
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
            <img src="logo2-2.png" alt="Logo" class="logoImage">
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

            <?php if (!empty($message)) : ?>
                <div class="erreur"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <form method="post" class="login-form">
                <div class="form-group">
                    <label for="email">Adresse courriel :</label>
                    <input type="email" name="email" id="email" required>
                </div>

                <div class="form-group">
                    <label for="mot_de_passe">Mot de passe :</label>
                    <input type="password" name="mot_de_passe" id="mot_de_passe" required>
                </div>

                <button type="submit" class="btn">Se connecter</button>
            </form>
        </div>
    </section>
</main>
</body>
</html>
