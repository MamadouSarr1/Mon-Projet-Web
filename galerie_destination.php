<?php
$destination = $_GET['dest'] ?? '';

$galleries = [
    "dakar" => [
        "title" => "Galerie - Dakar",
        "images" => [
            "images/dakar1.jpg",
            "images/dakar_mbao.jpg",
            "images/dakar_vu.jpg",
            "images/renaissance.jpg",
            "images/dkr.jpg",
            "images/belle_image.jpg",
            "images/belle_image2.jpg",
            "images/belle_image1.jpg",
            "images/monum.jpg",
        ]
    ],
    "saly" => [
        "title" => "Galerie - Saly",
        "images" => [
            "images/saly_plage.jpg",
            "images/saly2.jpg",
            "images/saly3.jpg",
            "images/saly4.jpg",
        ]
    ],
    "saint-louis" => [
        "title" => "Galerie - Saint-Louis",
        "images" => [
            "images/st-louis1.jpg",
            "images/st-louis2.jpg",
            "images/st-louis3.jpg",
            "images/st-louis4.jpg",
            "images/st-louis5.jpg",
            "images/sud.jpg",
            "images/lac-rose1.jpg",
        ]
    ],
    "iles" => [
        "title" => "Galerie - Îles",
        "images" => [
            "images/ile_madeleine.jpg",
            "images/ile_joal.jpg",
            "images/ile_ngor.jpg",
            "images/puits_sels.jpg",
            "images/ngor.jpg",
            "images/lac-rose.jpg",
            "images/ile4.jpg",
        ]
    ],
    "parcs" => [
        "title" => "Galerie - Parcs",
        "images" => [
            "images/parc.jpg",
            "images/parc2.jpg",
            "images/parc3.jpg",
            "images/parc4.jpg",
            "images/parc5.jpg",
            "images/parc6.jpg",
            "images/parc7.jpg",
            "images/parc8.jpg",
        ]
    ]
];

if (!isset($galleries[$destination])) {
    echo "Destination inconnue.";
    exit;
}

$data = $galleries[$destination];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($data['title']) ?></title>
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>

<div class="gallery-wrapper">
    <h1><?= htmlspecialchars($data['title']) ?></h1>
    <div class="gallery-grid">
        <?php foreach ($data['images'] as $img): ?>
            <img src="<?= htmlspecialchars($img) ?>" alt="<?= basename($img, '.jpg') ?>">
        <?php endforeach; ?>
    </div>
</div>

<!-- Lightbox -->
<div id="lightbox">
    <span class="close">&times;</span>
    <img class="lightbox-content" id="lightbox-img">
    <div id="caption"></div>
    <a class="prev">&#10094;</a>
    <a class="next">&#10095;</a>
</div>

<script>
    const lightbox = document.getElementById("lightbox");
    const lightboxImg = document.getElementById("lightbox-img");
    const caption = document.getElementById("caption");
    const images = Array.from(document.querySelectorAll(".gallery-grid img"));
    const close = document.querySelector(".close");
    const prev = document.querySelector(".prev");
    const next = document.querySelector(".next");
    let currentIndex = 0;

    function showImage(index) {
        const img = images[index];
        lightboxImg.src = img.src;
        caption.textContent = `Image ${index + 1} sur ${images.length} : ${img.alt}`;
        currentIndex = index;
        lightbox.style.display = "flex";
    }

    images.forEach((img, index) => {
        img.addEventListener("click", () => showImage(index));
    });

    close.addEventListener("click", () => lightbox.style.display = "none");

    next.addEventListener("click", () => {
        currentIndex = (currentIndex + 1) % images.length;
        showImage(currentIndex);
    });

    prev.addEventListener("click", () => {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        showImage(currentIndex);
    });

    window.addEventListener("click", (e) => {
        if (e.target === lightbox) {
            lightbox.style.display = "none";
        }
    });

    window.addEventListener("keydown", (e) => {
        if (lightbox.style.display === "flex") {
            if (e.key === "ArrowRight") {
                next.click();
            } else if (e.key === "ArrowLeft") {
                prev.click();
            } else if (e.key === "Escape") {
                close.click();
            }
        }
    });
</script>
</body>
</html>
