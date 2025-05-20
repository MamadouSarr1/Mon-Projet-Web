<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
<?php
require_once 'env.php';

require_once 'fonctionMail.php';  
$destinataire = "2305274@cegepat.qc.ca";
//$destinataire = getenv("SMS");
$code = rand(100000,999999);
$sujet = "Confirmation de votre réservation"; 
session_start();
$_SESSION['code'] = $code;

if (envoyerMail($destinataire, $sujet, "Votre code est : ".$code)) {
    echo "<p>Message envoyé à ". $destinataire."</p>";
} else {
    echo "<p>Message non envoyé à ". $destinataire."</p>";
}



?>
    </body>
</html>