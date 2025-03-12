<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification si les champs sont remplis
    if (isset($_POST["nom"], $_POST["email"], $_POST["destination"])) {
        $nom = htmlspecialchars(trim($_POST["nom"]));
        $email = htmlspecialchars(trim($_POST["email"]));
        $destination = htmlspecialchars(trim($_POST["destination"]));

        // Validation de l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<p>L'adresse e-mail que vous avez entrée n'est pas valide.</p>";
        } else {
            // Affichage des informations de confirmation
            echo "<h1>Merci pour votre réservation, $nom !</h1>";
            echo "<p>Vous avez réservé un circuit pour : <strong>$destination</strong></p>";
            echo "<p>Une confirmation sera envoyée à : <strong>$email</strong></p>";
        }
    } else {
        echo "<p>Veuillez remplir tous les champs du formulaire.</p>";
    }
}
?>
