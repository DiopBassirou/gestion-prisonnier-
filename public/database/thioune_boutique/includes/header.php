<?php 
// NE METTEZ PAS session_start() ici
require_once 'config.php';
require_once 'functions.php'; // Ce fichier contient isLoggedIn()

$pageTitle = $pageTitle ?? "ThiouneBoutique"; // Titre par défaut
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle.' - ' : '' ?><?= SITE_NAME ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <a href="..">ThiouneBoutique</a>
            </div>
            <nav>
                <ul>
                    <li><a href="../">Accueil</a></li>
                    <li><a href="../products/">Produits</a></li>
                    <?php if(isLoggedIn()): ?>
                        <li><a href="../user/account.php">Mon compte</a></li>
                        <li><a href="../user/logout.php">Déconnexion</a></li>
                    <?php else: ?>
                        <li><a href="../user/login.php">Connexion</a></li>
                        <li><a href="../user/register.php">Inscription</a></li>
                    <?php endif; ?>
                    <li><a href="../cart.php"><i class="fas fa-shopping-cart"></i> Panier (<?= array_sum($_SESSION['cart'] ?? []) ?>)</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container">