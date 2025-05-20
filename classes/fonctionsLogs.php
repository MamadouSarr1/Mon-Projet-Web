<?php
function journaliser($fichier, $message) {
    $logPath = "/home/sarrh25techinfo4/logs/" . $fichier;
    $date = date('[d/m/Y H:i:s]');
    file_put_contents($logPath, "$date $message\n", FILE_APPEND);
}
?>
