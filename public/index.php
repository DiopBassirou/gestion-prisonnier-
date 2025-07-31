<?php
require_once "securite.php";
$page = $_GET['page'] ?? '';

$allowed_pages = ["detail_renvoi","form_renvoi","suivi_des_detention","titreDetProvisoir",'modifIdentityPysique','connexion', 'form_fiche_ecrou', 'condamnation', 'historique', 'info_detenu', 'inscription','identity_physique',"empreinte",'recherche',"enrollement","modifiFiche_ecrou"];

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
