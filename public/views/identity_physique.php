<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Identité Physique</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h3 class="mb-4">Formulaire d’identité physique</h3>
  <h5 id="message"></h5>

  <form id="form-identite">

    <div class="row mb-3">
      <div class="col-md-6">
        <label for="taille" class="form-label">Taille</label>
        <input type="text" id="taille" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label for="corpulence" class="form-label">Corpulence</label>
        <input type="text" id="corpulence" class="form-control" required>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-4">
        <label for="yeux" class="form-label">Yeux</label>
        <input type="text" id="yeux" class="form-control" required>
      </div>
      <div class="col-md-4">
        <label for="cheveux" class="form-label">Cheveux</label>
        <input type="text" id="cheveux" class="form-control" required>
      </div>
      <div class="col-md-4">
        <label for="teint" class="form-label">Teint</label>
        <input type="text" id="teint" class="form-control" required>
      </div>
    </div>

    <div class="mb-3">
      <label for="signes_particuliers" class="form-label">Signes particuliers</label>
      <textarea id="signes_particuliers" class="form-control" rows="2"></textarea>
    </div>

    <div class="mb-3">
      <label for="photo" class="form-label">Chemin ou URL de la photo</label>
      <input type="text" id="photo" class="form-control" placeholder="ex: ../image/photo.jpg" required>
    </div>
    <div class="mb-3">
        <img src="" id="image"  alt="Aperçu photo" class="img-thumbnail" style="max-width: 200px; "> 
    </div>

    <button type="submit" class="btn btn-primary">Enregistrer l'identité</button>

  </form>

</div>

<script src="front_js/identity_physique.js" defer></script>
</body>
</html>
