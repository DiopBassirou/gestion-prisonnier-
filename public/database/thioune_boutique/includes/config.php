<?php
// Paramètres de connexion
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'thioune_boutique');

// Connexion PDO
try {
    $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Paramètres du site
define('SITE_NAME', 'ThiouneBoutique');
define('SITE_URL', 'http://localhost/thioune_boutique');
define('CURRENCY', 'FCFA');

// Initialisation de la session
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialisation du panier
if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>