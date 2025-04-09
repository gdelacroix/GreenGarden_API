<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Réponse immédiate aux pré-requêtes CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}


ini_set('display_errors', 1); // Affiche les erreurs à l'écran
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED & ~E_USER_WARNING & ~E_USER_DEPRECATED);


require_once __DIR__ . '/../routes/web.php';