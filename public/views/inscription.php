<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h3 class="mb-4 text-center text-primary">Formulaire d'inscription</h3>
  <h5 id="message" class="text-center text-danger mb-3"></h5>

  <form id="form">
    <div class="row mb-3">
      <div class="col-md-6">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" id="nom" name="nom" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label for="prenom" class="form-label">Prénom</label>
        <input type="text" id="prenom" name="prenom" class="form-control" required>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" id="password" name="password" class="form-control" required>
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-md-6">
        <label for="role" class="form-label">Rôle</label>
        <select class="form-select" id="role" name="role" required>
          <option value="">-- Sélectionnez un rôle --</option>
          <option value="admin">Admin</option>
          <option value="agent">Agent</option>
          <option value="greffier">Greffier</option>
          <option value="psychologue">Psychologue</option>
          <option value="directeur">Directeur</option>
          <option value="ministre">Ministre</option>
          <option value="medecin">Medecin</option>
          <option value="visiteur">Visiteur</option>
        </select>
      </div>
      <div class="col-md-6 ">
        <label for="role" class="form-label">Etablissement</label>
        <select class="form-select" id="id_etablissement"  required>
          <option value="">Sélectionnez un etablissement</option>
        </select>
      </div>
    </div>

    <div class="text-center">
      <button type="submit" class="btn btn-success px-4">S’inscrire</button>
    </div>
  </form>
</div>

<script src="front_js/inscription.js" defer></script>
</body>
</html>
