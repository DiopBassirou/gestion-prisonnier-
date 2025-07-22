
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajout d’un détenu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h3 class="mb-4">Formulaire de saisie d’un détenu</h3>
  <form  method="POST" id="form">
    <div class="row mb-3">
      <div class="col-md-6">
        <label>Nom *</label>
        <input type="text" name="nom" id="nom" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label>Prénoms *</label>
        <input type="text" name="prenoms" id="prenom" class="form-control" required>
      </div>
    </div>

    <div class="mb-3">
      <label>Surnom</label>
      <input type="text" name="surnom" id="surnom" class="form-control">
    </div>

    <div class="row mb-3">
      <div class="col-md-4">
        <label>Sexe *</label>
        <select name="sexe" id="sexe" class="form-select" required>
          <option value="">Choisir</option>
          <option value="M">Masculin</option>
          <option value="F">Féminin</option>
        </select>
      </div>
      <div class="col-md-4">
        <label>Date de naissance</label>
        <input type="date" name="date_naissance" id="date_naissance" class="form-control">
      </div>
      <div class="col-md-4">
        <label>Lieu de naissance</label>
        <input type="text" name="lieu_naissance" id="lieu_naissance" class="form-control">
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label>Fils de</label>
        <input type="text" name="fils_de" id="fils_de" class="form-control">
      </div>
      <div class="col-md-6">
        <label>Fille de</label>
        <input type="text" name="fille_de" id="fille_de" class="form-control">
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label>Situation familiale</label>
        <input type="text" name="situation_familiale" id="situation_familiale" class="form-control">
      </div>
      <div class="col-md-6">
        <label>Nombre d'enfants</label>
        <input type="number" name="nb_enfants" id="nb_enfants" class="form-control" min="0"  required>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label>Profession</label>
        <input type="text" name="profession" id="profession" class="form-control">
      </div>
      <div class="col-md-6">
        <label>Situation militaire</label>
        <input type="text" name="situation_militaire" id="situation_militaire" class="form-control">
      </div>
    </div>
    <div class="mb-3">
      <label>Qualifications</label>
      <textarea name="qualifications" id="qualifications" class="form-control" rows="2"></textarea>
    </div>

    <div class="mb-3">
      <label>Domicile</label>
      <textarea name="domicile" id="domicile" class="form-control" rows="2"></textarea>
    </div>

    <div class="mb-3">
      <label>Nationalité *</label>
      <select name="nationalite" id="nationalite"  class="form-select" required>
        <option value="">Choisir</option>
        <option value="Sénégalaise">Sénégalaise</option>
        <option value="Malienne">Malienne</option>
        <option value="Guinéenne">Guinéenne</option>
        <option value="Autre">Autre</option>
      </select>
    </div>

    <hr>

    <h5 class="mt-4">Personne à prévenir</h5>

    <div class="row mb-3">
      <div class="col-md-4">
        <label>Prénom</label>
        <input type="text" name="prenom_prevenir" id="prenom_prevenir" class="form-control">
      </div>
      <div class="col-md-4">
        <label>Nom</label>
        <input type="text" name="nom_prevenir" id="nom_prevenir" class="form-control">
      </div>
      <div class="col-md-4">
        <label>Numéro de téléphone</label>
        <input type="text" name="numero_prevenir" id="numero_prevenir" class="form-control">
      </div>
    </div>

    <div class="mb-3">
      <label>Adresse</label>
      <textarea name="adresse_prevenir" id="adresse_prevenir" class="form-control" rows="2"></textarea>
    </div>
    <div class="row mb-3">
      <div class="col-md-4">
        <select id="langue" multiple name="langue[]" class="form-select"  required>
        </select>
      </div>
      <div class="col-md-4">
        <div class="mb-3">
            <select class="form-select" name="niveau_instruction" id="niveau_instruction" required>
              <option value=""> Sélectionnez un niveau d'instruction</option>
              <option value="Aucune instruction">Aucune instruction</option>
              <option value="École coranique">École coranique</option>
              <option value="Primaire">Primaire</option>
              <option value="Moyen">Moyen</option>
              <option value="Secondaire">Secondaire</option>
              <option value="Baccalauréat">Baccalauréat</option>
              <option value="Université">Université</option>
              <option value="Formation professionnelle">Formation professionnelle</option>
              <option value="Alphabétisation">Alphabétisation</option>
              <option value="Autre">Autre</option>
            </select>
          </div>
      </div>
    </div>
    
  <h5 id="message"></h5>

    <button type="submit" class="btn btn-primary">Enregistrer le détenu</button>
  </form>

  <!-- ✅ jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- ✅ Select2 CSS + JS  -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- ✅ Ton propre script (doit venir après select2) -->
<script src="front_js/form_fiche_ecrou.js"></script>



