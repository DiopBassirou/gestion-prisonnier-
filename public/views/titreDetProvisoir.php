<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Titre de détention</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h3 class="mb-4">Formulaire du titre de détention</h3>
  <h5 id="message"></h5>

  <form id="form-titre">
<div class="row mb-3">
      <div class="col-md-6">
        <label for="nature" class="form-label">Num_ecrou *</label>
        <input type="text" id="num_ecrou" class="form-control" required>
      </div>
    </div>
    
    <div class="row mb-3">
      <div class="col-md-6">
        <label for="nature" class="form-label">Nature *</label>
        <input type="text" id="nature" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label for="numero" class="form-label">Numéro *</label>
        <input type="text" id="numero" class="form-control" required>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label for="date_titre" class="form-label">Date du titre *</label>
        <input type="date" id="date_titre" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label for="origine" class="form-label">Origine *</label>
        <input type="text" id="origine" class="form-control" required>
      </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <label for="infraction" class="form-label">Infraction *</label>
            <textarea id="infraction" class="form-control" rows="2" required></textarea>
        </div>
    </div>



    <button type="submit" class="btn btn-primary">Enregistrer le titre</button>

  </form>
</div>

<script src="front_js/titreDetProvisoir.js" defer></script>
</body>
</html>
