 

<div id="fiche-modal" class="modal fade" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-xl">
    <div class=" print-area modal-content">
      <div class="modal-header bg-dark text-white py-2">
        <h5 class="modal-title fw-bold">FICHE D'ÉCROU N°<span id="fiche-numero"></span></h5>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col-md-8">
            <div class="border-bottom pb-3 mb-3">
              <h6 class="fw-bold text-primary">IDENTITÉ</h6>
              <div class="row">
                <div class="col-md-6">
                  <p><strong>Nom :</strong> <span id="fiche-nom"></span></p>
                  <p><strong>Prénoms :</strong> <span id="fiche-prenoms"></span></p>
                  <p><strong>Surnom :</strong> <span id="fiche-surnom"></span></p>
                </div>
                <div class="col-md-6">
                  <p><strong>Sexe :</strong> <span id="fiche-sexe"></span></p>
                  <p><strong>Né(e) le :</strong> <span id="fiche-date-naissance"></span></p>
                  <p><strong>À :</strong> <span id="fiche-lieu-naissance"></span></p>
                </div>
              </div>
              <p><strong>Fils/Fille de :</strong> <span id="fiche-parents"></span></p>
            </div>

            <div class="border-bottom pb-3 mb-3">
              <h6 class="fw-bold text-primary">SITUATION</h6>
              <div class="row">
                <div class="col-md-4">
                  <p><strong>Nationalité :</strong> <span id="fiche-nationalite"></span></p>
                </div>
                <div class="col-md-4">
                  <p><strong>Situation familiale :</strong> <span id="fiche-situation-familiale"></span></p>
                </div>
                <div class="col-md-4">
                  <p><strong>Enfants :</strong> <span id="fiche-nb-enfants"></span></p>
                </div>
              </div>
              <p><strong>Profession :</strong> <span id="fiche-profession"></span></p>
              <p><strong>Niveau instruction :</strong> <span id="fiche-niveau-instruction"></span></p>
            </div>

            <div class="mb-3">
              <h6 class="fw-bold text-primary">CONTACT D'URGENCE</h6>
              <p><strong>Personne à prévenir :</strong> <span id="fiche-contact-nom"></span></p>
              <p><strong>Téléphone :</strong> <span id="fiche-contact-tel"></span></p>
              <p><strong>Adresse :</strong> <span id="fiche-contact-adresse"></span></p>
            </div>
          </div>

          <div class="col-md-4">
            <div class="text-center mb-4">
              <div id="fiche-photo" class="border p-1" style="height:200px;background:#f8f9fa;">
                <span class="text-muted">Photo non disponible</span>
              </div>
            </div>
 
            <div class="border-top pt-3">
              <h6 class="fw-bold text-center">EMPLACEMENT DES EMPREINTES</h6>
              <table class="table table-bordered text-center">
                <tr>
                  <td>Pouce Gauche</td>
                  <td>Index Gauche</td>
                  <td>Médius Gauche</td>
                </tr>
                <tr>
                  <td>Annulaire Gauche</td>
                  <td>Auriculaire Gauche</td>
                  <td></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>

<!-- <button onclick="window.print()" class="btn btn-success no-print" style="margin-left: 80px;">Imprimer / Télécharger PDF</button> -->

    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-danger" onclick="fermerModalProprement()">
      Fermer
    </button>
  </div>
  </div>
</div>

  <div class="container mt-4">
  <div class="table-responsive">
    <table id="myTable" class="table table-bordered ">
      <thead class="table-light">
        <tr>
          <th>Num Écrou</th>
          <th>Nom</th>
          <th>Prénoms</th>
          <th>Sexe</th>
          <th>Date Naissance</th>
          <th>Lieu Naissance</th>
          <th>Nationalité</th>
          <th>Établissement</th>
          <th>Details</th>
          <th>Telecharger PDF</th>
          <th>Edit</th>
        </tr>
      </thead>
      <tbody id="tbody">

      </tbody>
    </table>
  </div>
</div>

   <script src="front_js/historique.js" ></script>
