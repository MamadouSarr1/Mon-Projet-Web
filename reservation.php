<?php
require_once __DIR__ . '/classes/sessionSet.include.php';
require_once __DIR__ . '/classes/SelectUtilisateur.php';
require_once __DIR__ . '/config.php';        
require_once __DIR__ . '/fonctionMail.php';  
require_once __DIR__ . '/env.php';  
require_once __DIR__ . '/classes/fonctionsLogs.php';
         

session_start();

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header("Location: login.php?message=Veuillez vous connecter pour réserver.");
    exit;
}

// Vérification et assainissement de l'email
$email = filter_var($_SESSION["email"], FILTER_VALIDATE_EMAIL);
if (!$email) {
    $_SESSION['confirmation'] = "Erreur : Email invalide.";
    header("Location: index.php#reservation");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = $_SESSION["email"];
    $destination = filter_input(INPUT_POST, 'destination', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    try {
        $stmt = $pdo->prepare("INSERT INTO reservations (nom, email, destination) VALUES (:nom, :email, :destination)");
        $stmt->execute([
            ':nom' => $nom,
            ':email' => $email,
            ':destination' => $destination
        ]);
    
        journaliser('insertion-bd.log', "Nouvelle réservation insérée par $email pour '$destination'");
    
        // Confirmation à l'utilisateur
        $subject = "Confirmation de votre réservation";
        $message = "Bonjour $nom,\n\nMerci pour votre réservation pour la destination : $destination.\n\nNous avons bien reçu votre demande et nous vous contacterons pour plus de détails.\n\nÀ bientôt sur SenegalVoyages!";
        envoyerMail($email, $subject, $message);
    
        $_SESSION['confirmation'] = "Votre réservation pour <strong>$destination</strong> a été enregistrée avec succès.";
    
        if (defined('ADMIN_EMAIL')) {
            $adminSubject = "Nouvelle réservation reçue";
            $adminMessage = "Un client ($nom - $email) a réservé pour la destination : $destination.";
            envoyerMail(ADMIN_EMAIL, $adminSubject, $adminMessage);
        }
    
    } catch (PDOException $e) {
        $_SESSION['confirmation'] = "Erreur : " . $e->getMessage();
    }
}    

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de Réservation</title>
    <link rel="stylesheet" href="styles.css">
    

</head>
<body>
    <main class="section">
        <h2>Réservation</h2>
        <p><?php echo isset($response) ? htmlspecialchars($response) : ''; ?></p>
        <a href="index.php#reservation" class="btn">Retour</a>
    </main>
</body>
</html>
