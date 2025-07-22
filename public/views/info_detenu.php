<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Recherche de détenu par empreinte</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
  <style>
    .badge-langue {
      margin-right: 5px;
    }
  </style>
</head>
<body class="bg-light">

<div class="container mt-5">
  <h3 class="mb-4">Recherche de détenu par empreinte</h3>

  <form id="form-recherche" class="row g-3">
    <div class="col-md-4">
      <label for="main" class="form-label">Main</label>
      <select id="main" class="form-select" required>
        <option value="">Choisir</option>
        <option value="gauche">Gauche</option>
        <option value="droite">Droite</option>
      </select>
    </div>
    <div class="col-md-4">
      <label for="doigt" class="form-label">Doigt</label>
      <select id="doigt" class="form-select" required>
        <option value="">Choisir</option>
        <option value="pouce">Pouce</option>
        <option value="index">Index</option>
        <option value="majeur">Majeur</option>
        <option value="annulaire">Annulaire</option>
        <option value="auriculaire">Auriculaire</option>
      </select>
    </div>
    <div class="col-md-4">
      <label for="id_sdk" class="form-label">ID SDK</label>
      <input type="text" class="form-control" id="id_sdk" required>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Rechercher</button>
    </div>
  </form>
  <div id="resultat" class="mt-4"></div>
</div>
<button onclick="window.print()" class="btn btn-success" style="margin-left: 80px;">Imprimer / Télécharger PDF</button>

<script src="front_js/info_detenu.js"></script>
</body>
</html>
