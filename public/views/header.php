<?php
$titles = [
  "dashboard" => "Tableau de bord",
  "form_fiche_ecrou" => "Ajout d’un détenu",
  "titre_detention" => "Titre de détention",
  "historique" => "Historique",
  "info_detenu" => "Recherche",
  "inscription" => "Ajouter utilisateur"
];
$current_title = $titles[$page] ?? "Gestion Prison";

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($current_title) ?></title>
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
    <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"/>
</head>
<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php?page=dashboard">
        <div class="sidebar-brand-text mx-3">🛡️ Prison</div>
      </a>
      <hr class="sidebar-divider">
      <li class="nav-item"><a class="nav-link" href="index.php?page=dashboard"><i class="fas fa-home"></i> Accueil</a></li>
      <?php if($_SESSION['role']=='admin') :?>
      <li class="nav-item"><a class="nav-link" href="index.php?page=inscription"><i class="fas fa-user-plus"></i> Ajouter user</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?page=form_fiche_ecrou"><i class="fas fa-user"></i> Enregistrer détenu</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?page=titre_detention"><i class="fas fa-file-alt"></i> Titre de détention</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?page=historique"><i class="fas fa-history"></i> Historique</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?page=enrollement"><i class="fas fa-history"></i>Enrollement</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?page=info_detenu"><i class="fas fa-search"></i> Recherche par empreinte</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?page=recherche"><i class="fas fa-search"></i> Recherche</a></li>
      <?php endif ?>
      <?php if($_SESSION['role']=='ministre') :?>
      <li class="nav-item"><a class="nav-link" href="index.php?page=historique"><i class="fas fa-history"></i> Historique</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?page=enrollement"><i class="fas fa-history"></i>Enrollement</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?page=info_detenu"><i class="fas fa-search"></i> Recherche par empreinte</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?page=recherche"><i class="fas fa-search"></i> Recherche</a></li>
      <?php endif ?>
      <?php if($_SESSION['role']=='agent') :?>
      <li class="nav-item"><a class="nav-link" href="index.php?page=form_fiche_ecrou"><i class="fas fa-user"></i> Enregistrer détenu</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?page=historique"><i class="fas fa-history"></i> Historique</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?page=enrollement"><i class="fas fa-history"></i>Enrollement</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?page=info_detenu"><i class="fas fa-search"></i> Recherche par empreinte</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?page=recherche"><i class="fas fa-search"></i> Recherche</a></li>
      <?php endif ?>
      <?php if($_SESSION['role']=='greffier') :?>
      <li class="nav-item"><a class="nav-link" href="index.php?page=titre_detention"><i class="fas fa-file-alt"></i> Titre de détention</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?page=historique"><i class="fas fa-history"></i> Historique</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?page=info_detenu"><i class="fas fa-search"></i> Recherche par empreinte</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?page=recherche"><i class="fas fa-search"></i> Recherche</a></li>
      <?php endif ?>
    </ul>

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <h5 class="ms-3 text-primary"><?= htmlspecialchars($current_title) ?></h5>
          <div class="ms-auto me-4">
            <span class="me-2 text-dark" id="usernameDisplay"></span>
            <a href="deconnexion.php" style="text-decoration: none;color:none"><button class="btn btn-outline-danger btn-sm" id="logoutBtn">Déconnexion</button></a>
          </div>
        </nav>
        <div class="container-fluid">
