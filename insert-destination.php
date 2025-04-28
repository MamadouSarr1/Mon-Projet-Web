<?php
$host = "localhost";
$dbname = "sarrh25techinfo4_25mars2025";
$username = "sarrh25techinfo4_ecrireSql";
$password = "Informatique.101";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $destinations = [
        [
            "nom" => "Dakar",
            "image" => "dakar_city.jpg",
            "description" => "Capitale vibrante, entre plages et culture locale."
        ],
        [
            "nom" => "Saly",
            "image" => "liitoral.jpg",
            "description" => "Des plages paradisiaques à découvrir absolument."
        ],
        [
            "nom" => "Saint-Louis",
            "image" => "saint-louis.jpg",
            "description" => "Plongez dans l'histoire avec son architecture coloniale."
        ],
        [
            "nom" => "Îles",
            "image" => "goree.jpg",
            "description" => "Découvrez la beauté naturelle des îles du Sénégal."
        ],
        [
            "nom" => "Parcs",
            "image" => "cascade.jpg",
            "description" => "Explorez la faune et la flore des parcs nationaux."
        ]
    ];

    foreach ($destinations as $dest) {
        $stmt = $pdo->prepare("INSERT INTO destinations (nom, image, description) VALUES (?, ?, ?)");
        $stmt->execute([$dest["nom"], $dest["image"], $dest["description"]]);
    }

    echo "Les destinations ont été insérées avec succès.";

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
