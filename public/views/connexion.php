<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Connexion - Gestion Pénitentiaire</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url('https://images.unsplash.com/photo-1581093588401-7c02c811f51b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1500&q=80') no-repeat center center fixed;
      background-size: cover;
      height: 100vh;
      backdrop-filter: blur(2px);
    }

    .overlay {
      background-color: rgba(0, 0, 0, 0.6);
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      z-index: 1;
    }

    .login-container {
      z-index: 2;
      position: relative;
    }

    .card {
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 12px;
    }

    .title-text {
      font-weight: bold;
      color: #0d6efd;
      text-align: center;
    }

    .intro-text {
      text-align: center;
      color: #555;
      font-size: 0.95rem;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

<div class="overlay"></div>

<div class="container d-flex justify-content-center align-items-center min-vh-100 login-container">
  <div class="card shadow-lg p-4" style="width: 100%; max-width: 420px;">
    <h4 class="title-text mb-3">Système de Gestion Pénitentiaire</h4>
    <p class="intro-text">Accès sécurisé à la plateforme d’administration des détenus et fiches d’écrou.</p>

    <form method="POST" id="form">
      <div class="mb-3">
        <label for="email" class="form-label">Adresse e-mail</label>
        <input type="email" class="form-control" id="email" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" required>
      </div>

      <div id="message" class="form-text text-danger mb-3"></div>

      <button type="submit" class="btn btn-primary w-100">Se connecter</button>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="front_js/connexion.js" defer></script>
</body>
</html>
