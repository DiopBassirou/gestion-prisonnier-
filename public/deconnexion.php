<?php
    session_start(); 
    // Détruire toutes les données de session
    $_SESSION = []; // Vide le tableau
    session_unset(); // Supprime toutes les variables de session
    session_destroy(); // Détruit la session
    header("Location:index.php");
    exit;
?>