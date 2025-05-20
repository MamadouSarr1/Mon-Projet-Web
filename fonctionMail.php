<?php
function envoyerMail($to, $subject, $message) {
    $headers = 
        'From: sarrh25techinfo4@techinfo420.ca' . "\r\n" .
        'Reply-To: sarrh25techinfo4@techinfo420.ca' . "\r\n" .
        'Content-Type: text/plain; charset=UTF-8' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    return mail($to, $subject, $message, $headers);
}

?>