<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Recherche de détenus</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
  <h3 class="mb-3">Recherche avancée des détenus</h3>
  <form id="form-recherche" class="border p-4 rounded shadow-sm">
    <div class="row mb-3">
      <div class="col-md-4">
        <label>Numero ecrou</label>
        <input type="text" name="num_ecrou" class="form-control">
      </div>
      <div class="col-md-3">
        <label>Nom</label>
        <input type="text" name="nom" class="form-control">
      </div>
      <div class="col-md-3">
        <label>Prénoms</label>
        <input type="text" name="prenoms" class="form-control">
      </div>
      <div class="col-md-3">
        <label>Sexe</label>
        <select name="sexe" class="form-select">
          <option value="">Tous</option>
          <option value="M">Masculin</option>
          <option value="F">Féminin</option>
        </select>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-3">
        <label>Âge min</label>
        <input type="number" name="age_min" class="form-control">
      </div>
      <div class="col-md-3">
        <label>Âge max</label>
        <input type="number" name="age_max" class="form-control">
      </div>
      <div class="col-md-3">
        <label>Lieu de naissance</label>
        <input type="text" name="lieu_naissance" class="form-control">
      </div>
      <div class="col-md-3">
        <label>Nationalité</label>
        <select name="nationalite" class="form-select">
          <option value="">Toutes</option>
          <option value="Sénégalaise">Sénégalaise</option>
          <option value="Malienne">Malienne</option>
          <option value="Guinéenne">Guinéenne</option>
          <option value="Autre">Autre</option>
        </select>
      </div>

    </div>

    <div class="row mb-3">
      <div class="col-md-4">
        <label>Profession</label>
        <input type="text" name="profession" class="form-control">
      </div>
      <div class="col-md-4">
        <label>Niveau d'instruction</label>
        <input type="text" name="niveau_instruction" class="form-control">
      </div>
      <div class="col-md-4">
        <label>Situation familiale</label>
        <input type="text" name="situation_familiale" class="form-control">
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-4">
        <label>Date d’entrée min</label>
        <input type="date" name="date_entree_min" class="form-control">
      </div>
      <div class="col-md-4">
        <label>Date d’entrée max</label>
        <input type="date" name="date_entree_max" class="form-control">
      </div>
      <div class="col-md-4">
        <label>Date de sortie (max)</label>
        <input type="date" name="date_liberation_max" class="form-control">
      </div>
    </div>

    <button type="submit" class="btn btn-primary">Rechercher</button>
    <button type="reset" class="btn btn-danger ms-5">Reset</button>
  </form>

  <div class="mt-5" id="resultats">
    <h5>Résultats :</h5>
    <div id="table-resultats"></div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="front_js/recherche.js" defer></script>
</body>
</html>
