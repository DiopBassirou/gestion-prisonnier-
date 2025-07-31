
<div class="container mt-4">
  <div class="table-responsive">
    <div class="row mb-3">
        <div class="col-md-3">
            <!-- je cherche ces titres detention a traver son numero d'ecrou -->
             <label for="num_ecrou">Rechercher par numéro d'écrou:</label>
             <input type="text" class="form-control" id="num_ecrou" >
        </div>
        <div class="col-md-4 ms-auto">
            <!-- je cherche un titre detention specifique a travers son numero -->
            <label for="numero">Rechercher par numéro détention:</label>
            <input type="text" class="form-control" id="numero" >
        </div>
        <div class="col-md-4 ms-auto mt-5 text-end">
            <a style="text-decoration: none;"  class="btn btn-primary btn-sm " href="index.php?page=form_renvoi"><i class="fa fa-plus" aria-hidden="true">Ajouter Audience</i></a>
        </div>
    </div>
    <table id="myTabl" class="table table-bordered ">
      <thead class="table-light" >
        <tr>
          <th>Nature</th>
          <th>Origine</th>
          <th>Infraction</th>
          <th>Date Titre</th>
          <th>Details</th>
        </tr>
      </thead>
      <tbody id="tbody">

      </tbody>
    </table>
    <div id="message"></div>
  </div>
</div>

  <script src="front_js/suivi_des_detention.js"></script>

