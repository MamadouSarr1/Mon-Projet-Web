<?php
// Simulation d'une base de données avec un tableau PHP
$destinations = [
    [
        "nom" => "Dakar",
        "image" => "https://source.unsplash.com/400x300/?dakar,city",
        "description" => "La capitale dynamique, avec l'île de Gorée, la mosquée de la Divinité et le Monument de la Renaissance Africaine."
    ],
    [
        "nom" => "Saly",
        "image" => "https://source.unsplash.com/400x300/?beach,africa",
        "description" => "Destination balnéaire avec ses plages paradisiaques, activités nautiques et hôtels de luxe."
    ],
    [
        "nom" => "Saint-Louis",
        "image" => "https://source.unsplash.com/400x300/?history,africa",
        "description" => "Ville historique classée à l’UNESCO, célèbre pour ses maisons coloniales et son festival de jazz."
    ],
    [
        "nom" => "Parc du Niokolo-Koba",
        "image" => "https://source.unsplash.com/400x300/?nature,park",
        "description" => "Un sanctuaire pour la faune africaine, idéal pour les amateurs de safari et de nature."
    ],
    [
        "nom" => "Lac Rose",
        "image" => "https://source.unsplash.com/400x300/?lake,pink",
        "description" => "Un lac unique au monde avec ses eaux roses dues à la forte salinité et aux micro-organismes."
    ],
    [
        "nom" => "Désert de Lompoul",
        "image" => "https://source.unsplash.com/400x300/?desert,dunes",
        "description" => "Un paysage saharien magnifique avec ses dunes de sable doré et ses bivouacs sous les étoiles."
    ]
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinations Touristiques</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <header>
        <nav>
            <div class="logo">SenegalVoyages</div>
            <ul>
                <li><a href="index.html">Accueil</a></li>
                <li><a href="destination.php" class="active">Destinations</a></li>
                <li><a href="reservation.html">Réservation</a></li>
                <li><a href="galerie.html">Galerie</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="destinations">
            <h2>Découvrez les plus belles destinations du Sénégal</h2>
            <p>Explorez les merveilles du Sénégal à travers nos destinations incontournables.</p>

            <div class="destination-container">
                <?php foreach ($destinations as $destination) : ?>
                    <div class="destination-card">
                        <img src="<?= $destination['image'] ?>" alt="<?= $destination['nom'] ?>">
                        <h3><?= $destination['nom'] ?></h3>
                        <p><?= $destination['description'] ?></p>
                        <a href="#" class="btn">Découvrir</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 SenegalVoyages - Tous droits réservés</p>
    </footer>

    <script>
        // Gestion du changement de fond de navigation lors du scroll
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                document.querySelector('header').classList.add('scrolled');
            } else {
                document.querySelector('header').classList.remove('scrolled');
            }
        });
    </script>

</body>
</html>
