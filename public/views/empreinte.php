<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Empreinte digitale</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script>if(!localStorage.get("id_user")){
      window.location.href="/"
    }</script>
</head>
<body class="bg-light">

<div class="container mt-5">
  <h3 class="mb-4">Formulaire d’empreinte digitale</h3>
  <h5 id="message"></h5>

  <form id="form-empreinte">
    <div class="row mb-3">
      <div class="col-md-4">
        <label class="form-label">Main *</label>
        <select id="main" class="form-select" required>
          <option value="">Sélectionner</option>
          <option value="gauche">Gauche</option>
          <option value="droite">Droite</option>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Doigt *</label>
        <select id="doigt" class="form-select" required>
          <option value="">Sélectionner</option>
          <option value="pouce">Pouce</option>
          <option value="index">Index</option>
          <option value="majeur">Majeur</option>
          <option value="annulaire">Annulaire</option>
          <option value="auriculaire">Auriculaire</option>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">ID SDK *</label>
        <input type="text" id="id_sdk" class="form-control" placeholder="ex: TEST1234" required>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">Enregistrer</button>
  </form>
</div>

<script src="front_js/empreinte.js" defer></script>
</body>
</html>
