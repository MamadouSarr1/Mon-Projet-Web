<?php
session_start();

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header("Location: login.php?message=Veuillez vous connecter pour réserver.");
    exit;
}

$host = "localhost";
$dbname = "sarrh25techinfo4_25mars2025";
$username = "sarrh25techinfo4_ecrireSql";
$password = "Informatique.101";

$response = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = htmlspecialchars(trim($_POST["nom"]));
    $email = $_SESSION["email"];
    $destination = htmlspecialchars(trim($_POST["destination"]));

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("INSERT INTO reservations (nom, email, destination) VALUES (?, ?, ?)");
        $stmt->execute([$nom, $email, $destination]);

        $_SESSION['confirmation'] = "Votre réservation pour <strong>$destination</strong> a été enregistrée avec succès.";
    } catch (PDOException $e) {
        $_SESSION['confirmation'] = "Erreur : " . $e->getMessage();
    }

    header("Location: index.php#reservation");
    exit;
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de Réservation</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        main.section {
            max-width: 600px;
            margin: 80px auto;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #006747;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2rem;
            color: #333;
            margin-bottom: 30px;
        }

        a.btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #006747;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s ease;
        }

        a.btn:hover {
            background-color: #004d39;
        }
    </style>
</head>
<body>
    <main class="section">
        <h2>Réservation</h2>
        <p><?php echo $response; ?></p>
        <a href="index.php#reservation" class="btn">Retour</a>
    </main>
</body>
</html>
