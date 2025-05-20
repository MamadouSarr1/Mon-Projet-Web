<?php
require_once __DIR__ . '/classes/sessionSet.include.php';
require_once __DIR__ . '/classes/SelectUtilisateur.php';
session_start();
session_unset();
session_destroy();
header("Location: index.php");
exit;
