document.getElementById('form-recherche').addEventListener('submit', async function(e) {
  e.preventDefault();

  const formData = new FormData(this);
  const data = {};

  // Ne garde que les champs non vides
  for (let [key, value] of formData.entries()) {
   // if(key=="date_entree_min"){console.log("key:",key,"val:",value);}
    if (value.trim() !== '') {
     // console.log("key:",key,"val:",value)
      data[key] = value.trim();
      console.log(data);
      
    }
  }

  try {
    const res = await fetch('../controller/RechercheController.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });

    const result = await res.json();
    const resultDiv = document.getElementById('table-resultats');
    resultDiv.innerHTML = '';
    console.log(result);
    console.log(result.data);

    if (result.success && result.data.length > 0) {
      const table = document.createElement('table');
      table.className = 'table table-striped';

      const thead = `
        <thead>
          <tr>
            <th>Num Écrou</th>
            <th>Nom</th>
            <th>Prénoms</th>
            <th>Sexe</th>
            <th>Date Naiss</th>
            <th>Nationalité</th>
            <th>Date entrée</th>
            <th>Date sortie</th>
            <th>Infraction</th>
          </tr>
        </thead>
      `;

      const rows = result.data.map(detenu => `
        <tr>
          <td>${detenu.num_ecrou}</td>
          <td>${detenu.nom}</td>
          <td>${detenu.prenoms}</td>
          <td>${detenu.sexe}</td>
          <td>${detenu.date_naissance ?? ''}</td>
          <td>${detenu.nationalite ?? ''}</td>
          <td>${detenu.date_entree ?? ''}</td>
          <td>${detenu.date_liberation ?? ''}</td>
          <td>${detenu.infraction ?? ''}</td>
        </tr>
      `).join('');

      table.innerHTML = thead + `<tbody>${rows}</tbody>`;
      resultDiv.appendChild(table);
    } else {
      resultDiv.innerHTML = `<div class="alert alert-warning">Aucun résultat trouvé.</div>`;
    }

  } catch (err) {
    console.error(err);
    
  }
});
