<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Renvoi de procès</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h3 class="mb-4">Formulaire de renvoi de procès</h3>
  <h5 id="message"></h5>

  <form id="form-renvoi">

    <div class="row mb-3">
      <div class="col-md-6">
        <label for="num_ecrou" class="form-label">Numero ecrou *</label>
        <input type="text" id="num_ecrou" class="form-control">
      </div>
      <div class="col-md-6">
        <label for="" class="form-label">Numero *</label>
        <input type="text" id="numero" class="form-control" required>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label for="nouvelle_date" class="form-label">Nouvelle date *</label>
        <input type="date" id="nouvelle_date" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label for="date_decision_renvoi" class="form-label">Date de décision *</label>
        <input type="date" id="date_decision_renvoi" class="form-control" required>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-12">
        <label for="motif_renvoi" class="form-label">Motif du renvoi</label>
        <textarea id="motif_renvoi" class="form-control" rows="3" placeholder="Ex: Dossier non complet"></textarea>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">Enregistrer le renvoi</button>

  </form>
</div>

<script src="front_js/form_renvoi.js" defer></script>
</body>
</html>
