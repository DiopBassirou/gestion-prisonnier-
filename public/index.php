<?php
require_once "securite.php";
$page = $_GET['page'] ?? '';

$allowed_pages = ['connexion', 'form_fiche_ecrou', 'titre_detention', 'historique', 'info_detenu', 'inscription','identity_physique',"empreinte",'recherche',"enrollement"];

if (!in_array($page, $allowed_pages)) {
    $page = 'historique';
};

if(!isset($_GET['page']))
{
    include "views/connexion.php";
}else{
    include "views/header.php";
    include "views/$page.php";
    include "views/footer.php";

}
?>
