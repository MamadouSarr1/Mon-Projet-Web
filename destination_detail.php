<?php
// Simulation de récupération des données de la destination
$destination_name = $_GET['destination'] ?? null;
$destination_details = [
    "Dakar" => [
        "image" => "dakar.jpg",
        "description" => "La capitale dynamique, avec l'île de Gorée, la mosquée de la Divinité et le Monument de la Renaissance Africaine."
    ],
    "Saly" => [
        "image" => "images/saly.jpg",
        "description" => "Destination balnéaire avec ses plages paradisiaques, activités nautiques et hôtels de luxe."
    ],
    "Parc National du Niokolo-Koba" => [
        "image" => "images/niokolo_koba.jpg",
        "description" => "Un vaste parc national abritant une faune diversifiée, y compris des lions, des éléphants et des hippopotames."
    ],
    "Réserve de Bandia" => [
        "image" => "images/bandia.jpg",
        "description" => "Une réserve naturelle où vous pouvez observer des rhinocéros, des girafes et d'autres animaux sauvages dans leur habitat naturel."
    ],
    "Île de Gorée" => [
        "image" => "images/goree.jpg",
        "description" => "Une île historique connue pour sa Maison des Esclaves et ses rues pittoresques."
    ],
    "Îles du Saloum" => [
        "image" => "images/saloum.jpg",
        "description" => "Un archipel de mangroves et de lagunes, idéal pour l'écotourisme et l'observation des oiseaux."
    ],
    // Ajoute d'autres destinations ici...
];

if ($destination_name && isset($destination_details[$destination_name])) {
    $destination = $destination_details[$destination_name];
} else {
    echo "Destination non trouvée.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la destination - <?= htmlspecialchars($destination_name) ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <header>
        <nav>
            <div class="logo">SenegalVoyages</div>
            <ul>
                <li><a href="index.html">Accueil</a></li>
                <li><a href="destination.php">Destinations</a></li>
                <li><a href="reservation.html">Réservation</a></li>
                <li><a href="galerie.html">Galerie</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="destination-details">
            <h2><?= htmlspecialchars($destination_name) ?></h2>
            <img src="<?= $destination['image'] ?>" alt="<?= htmlspecialchars($destination_name) ?>">
            <p><?= htmlspecialchars($destination['description']) ?></p>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 SenegalVoyages - Tous droits réservés</p>
    </footer>

</body>
</html>