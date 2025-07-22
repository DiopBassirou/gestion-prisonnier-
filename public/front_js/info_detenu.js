document.getElementById("form-recherche").addEventListener("submit", async function (e) {
  e.preventDefault();
  const data = {
    main: document.getElementById("main").value,
    doigt: document.getElementById("doigt").value,
    id_sdk: document.getElementById("id_sdk").value.trim()
  };

  const resultatDiv = document.getElementById("resultat");
  const resultatDi = document.getElementById("resulta");
  resultatDiv.innerHTML = "<p>Recherche en cours...</p>";

  try {
    const res = await fetch("/fiche_ecrou/public/controller/InfoDetenu.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data)
    });

    const result = await res.json();
    if (!result.status) {
      resultatDiv.innerHTML = `<div class='alert alert-danger'>${result.message}</div>`;
      return;
    }

    const d = result.data;
    console.log(d);
    
    const langues = d.langues.map(l => `<span class='badge bg-info badge-langue'>${l}</span>`).join('');
    const photo = d.photo ? `<img src="${d.photo}" class="img-thumbnail mb-3" style="width: 200px; height: 200px; object-fit: cover;">` : "<em>Pas de photo</em>";

    resultatDiv.innerHTML = `
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">${d.nom} ${d.prenoms} (${d.num_ecrou})</h5>
          ${photo}
          <p><strong>Sexe :</strong> ${d.sexe} | <strong>Date naissance :</strong> ${d.date_naissance}</p>
          <p><strong>Profession :</strong> ${d.profession}</p>
          <p><strong>Langues :</strong> ${langues}</p>
          <p><strong>Infraction :</strong> ${d.infraction || 'Non précisé'}</p>
          <p><strong>Durée peine :</strong> ${d.duree_peine || 'Non précisé'}</p>
          <p><strong>Date Condamnation :</strong> ${d.date_condamnation || 'Non précisé'}</p>
          <p><strong>Date Liberation :</strong> ${d.date_liberation || 'Non précisé'}</p>
        </div>
      </div>
    `;
    resultatDi.innerHTML = `
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">${d.nom} ${d.prenoms} (${d.num_ecrou})</h5>
          ${photo}
          <p><strong>Sexe :</strong> ${d.sexe} | <strong>Date naissance :</strong> ${d.date_naissance}</p>
          <p><strong>Profession :</strong> ${d.profession}</p>
          <p><strong>Langues :</strong> ${langues}</p>
          <p><strong>Infraction :</strong> ${d.infraction || 'Non précisé'}</p>
          <p><strong>Durée peine :</strong> ${d.duree_peine || 'Non précisé'}</p>
          <p><strong>Date Condamnation :</strong> ${d.date_condamnation || 'Non précisé'}</p>
          <p><strong>Date Liberation :</strong> ${d.date_liberation || 'Non précisé'}</p>
        </div>
      </div>
    `;
  } catch (err) {
    console.log("Erreur lors de la requête");
  }
});
