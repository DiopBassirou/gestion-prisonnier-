<?php
session_start();
if (!isset($_SESSION['id_user'])) {
   // header("Location :views/connexion.php ");
   include "views/connexion.php";
   exit;
} 
?>