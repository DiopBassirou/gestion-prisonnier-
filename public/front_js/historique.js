const tbody=document.getElementById("tbody")
let modal//cette variable control l'ouverture et la fermeture de l'afficher des details d'un 
fetch("../controller/HistoriqueController.php")
.then(res=>res.json())
.then(data=>{
    const tbody = document.getElementById("tbody");
    data.data.forEach(d => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${d.num_ecrou}</td>
        <td>${d.nom}</td>
        <td>${d.prenoms}</td>
        <td>${d.sexe}</td>
        <td>${d.date_naissance}</td>
        <td>${d.lieu_naissance}</td>
        <td>${d.nationalite}</td>
        <td>${d.nom_etablissement}</td>
        <td>
            <button class="btn btn-sm btn-info" onclick="afficherFiche(${d.num_ecrou})">Détails</button>
        </td>
        <td>
            <a style="text-decoration: none;"  class="btn btn-danger btn-sm " href="views/bassirou.php?ecrou=${d.num_ecrou}" target="_blank">PDF</a>
        </td>
        <td>
            <a style="text-decoration: none;"  class="btn btn-danger btn-sm " href="index.php?page=modifiFiche_ecrou&ecrou=${d.num_ecrou}">Modifier</a>
        </td>
      `;
      tbody.appendChild(tr);
    });
        // ✅ Initialisation DataTables ici, après que toutes les lignes soient ajoutées
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
      $('#myTable').DataTable();
    } else {
      console.error("DataTables n'est pas chargé !");
    }

})

function afficherFiche(num_ecrou) {
  fetch(`controller/HistoriqueController.php?ecrou=${num_ecrou}`)
    .then(res => res.json())
    .then(data => {
      // Vérification des données
      if (!data.data) throw new Error('Données manquantes');

      // 
      const d = data.data;//data.data= donnees recue au niveau du serveur (le backend)
      
      //cette fonction me permet d'afficher les details d'un detenu
      const setField = (id, value) => {
        document.getElementById(id).textContent = value || 'Non renseigné';
        if(id=="fiche-nb-enfants"){ document.getElementById(id).textContent = value || 0;}
      };

      // Identité
      setField('fiche-numero', d.num_ecrou);
      setField('fiche-nom', d.nom);
      setField('fiche-prenoms', d.prenoms);
      setField('fiche-surnom', d.surnom);
      setField('fiche-sexe', d.sexe === 'M' ? 'Masculin' : 'Féminin');
      setField('fiche-date-naissance', d.date_naissance);
      setField('fiche-lieu-naissance', d.lieu_naissance);
      setField('fiche-parents', `${d.fils_de || ''} ${d.fille_de ? `et ${d.fille_de}` : ''}`.trim());

      // Situation
      setField('fiche-nationalite', d.nationalite);
      setField('fiche-situation-familiale', d.situation_familiale);
      setField('fiche-nb-enfants', d.nb_enfants);
      setField('fiche-profession', d.profession);
      setField('fiche-niveau-instruction', d.niveau_instruction);

      // Contacts
      setField('fiche-contact-nom', `${d.prenom_prevenir} ${d.nom_prevenir}`);
      setField('fiche-contact-tel', d.numero_prevenir);
      setField('fiche-contact-adresse', d.adresse_prevenir);

      // Photo
      if (d.photo) {
        let cheminNettoye = d.photo.replace("../", "");

        document.getElementById('fiche-photo').innerHTML = `
          <img src="${cheminNettoye}" class="img-fluid h-100" style="object-fit:cover;">
        `;
      }

      // Affichage modal
      const modalEl = document.getElementById('fiche-modal');
      if (modalEl) {
        modal = new bootstrap.Modal(modalEl);
        modal.show();
      } else {
        console.error("La modal #fiche-modal n'existe pas");
      }      
    }).catch(error => {
      console.error("Erreur:", error);
      alert("Erreur de chargement : " + error.message);
    });

}
// 
function fermerModalProprement() {
  if (modal) {
    modal.hide();
  }
}


