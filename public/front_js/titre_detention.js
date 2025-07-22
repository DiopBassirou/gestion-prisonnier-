
document.getElementById('form-titre').addEventListener('submit', async (e) => {
  e.preventDefault();

  const data = {
    num_ecrou:document.getElementById('num_ecrou').value,
    nature: document.getElementById('nature').value,
    numero: document.getElementById('numero').value,
    date_titre: document.getElementById('date_titre').value,
    origine: document.getElementById('origine').value,
    infraction: document.getElementById('infraction').value,
    date_condamnation: document.getElementById('date_condamnation').value,
    juridiction: document.getElementById('juridiction').value,
    duree_peine: document.getElementById('duree_peine').value,
    date_liberation: document.getElementById('date_liberation').value,
  };
  try{
      const response = await fetch('/fiche_ecrou/public/controller/TitreDetentionController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      });
      const result = await response.json();
      if(result.success){
        //  alert("le numero d'ecrou de ce detenu est:"+ num_ecrou)
          document.getElementById("message").innerHTML = `<div class="alert alert-success">${result.message}</div>`;
          setTimeout(()=>{ window.location.href="index.php?page="+result.page_suiv},1000)
        }else{ document.getElementById("message").innerHTML = `<div class="alert alert-danger">${result.message}</div>`;}
  }catch(e){console.log(e);}

});
