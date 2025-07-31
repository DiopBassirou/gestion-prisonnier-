<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail du Renvoi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            padding: 30px;
        }
        .profile-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: auto;
        }
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }
        .profile-header img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #007bff;
            margin-right: 25px;
        }
        .info-section i {
            color: #007bff;
            margin-right: 10px;
        }
        .info-section {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<button onclick="history.back()" class="btn btn-outline-primary mb-3">
    <i class="fas fa-arrow-left"></i> Retour
</button>
<div class="profile-card" id="detailContainer">
    <div class="profile-header">
        <img id="photo" src="default.jpg" alt="Photo">
        <div>
            <h4 id="nomPrenom">Nom Prénom</h4>
            <div class="info-section"><i class="fas fa-gavel"></i>Infraction : <span id="infraction"></span></div>
            <div class="info-section"><i class="fas fa-undo"></i>Nombre de renvois : <span id="nbRenvoi">0</span></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="info-section"><i class="fas fa-calendar-alt"></i>Ancienne date : <span id="ancienneDate">-</span></div>
            <div class="info-section"><i class="fas fa-calendar-plus"></i>Nouvelle date : <span id="nouvelleDate">-</span></div>
            <div class="info-section"><i class="fas fa-calendar-plus"></i>Nature : <span id="nature">-</span></div>
        </div>
        <div class="col-md-6">
            <div class="info-section"><i class="fas fa-comments"></i>Motif : <span id="motif">-</span></div>
            <div class="info-section"><i class="fas fa-check-circle"></i>Date décision : <span id="dateDecision">-</span></div>
            <div class="info-section"><i class="fas fa-check-circle"></i>Etablissement : <span id="etablissement">-</span></div>
        </div>
    </div>
</div>

<div class="text-end mt-3">
    <button id="btnHistorique" class="btn btn-info">
        <i class="fas fa-history"></i> Voir l'historique des renvois
    </button>
</div>

<div id="historiqueContainer" class="mt-4" style="display: none;">
    <h5>Historique des renvois :</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ancienne date</th>
                <th>Nouvelle date</th>
                <th>Date décision</th>
                <th>Motif</th>
            </tr>
        </thead>
        <tbody id="historiqueBody"></tbody>
    </table>
</div>

<script src="front_js/detail_renvoi.js"></script>
</body>
</html>
