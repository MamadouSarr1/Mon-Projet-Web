<?php
require_once __DIR__ . '/config.php'; // Séparer la connexion PDO

try {
    // Tableau de destinations à insérer
    $destinations = [
        [
            "nom" => "Dakar",
            "image" => "images/dakar_city.jpg",
            "description" => "Capitale vibrante, entre plages et culture locale."
        ],
        [
            "nom" => "Saly",
            "image" => "images/liitoral.jpg",
            "description" => "Des plages paradisiaques à découvrir absolument."
        ],
        [
            "nom" => "Saint-Louis",
            "image" => "images/saint-louis.jpg",
            "description" => "Plongez dans l'histoire avec son architecture coloniale."
        ],
        [
            "nom" => "Îles",
            "image" => "images/goree.jpg",
            "description" => "Découvrez la beauté naturelle des îles du Sénégal."
        ],
        [
            "nom" => "Parcs",
            "image" => "images/cascade.jpg",
            "description" => "Explorez la faune et la flore des parcs nationaux."
        ]
    ];

    // Requête préparée
    $stmt = $pdo->prepare("INSERT INTO destinations (nom, image, description) VALUES (:nom, :image, :description)");

    foreach ($destinations as $dest) {
        $stmt->bindParam(':nom', $dest["nom"]);
        $stmt->bindParam(':image', $dest["image"]);
        $stmt->bindParam(':description', $dest["description"]);
        $stmt->execute();
    }


    echo "Les destinations ont été insérées avec succès.";

} catch (PDOException $e) {
    echo "Erreur : " . htmlspecialchars($e->getMessage());
}
?>
