
document.getElementById('form-titre').addEventListener('submit', async (e) => {
  e.preventDefault();

  const data = {
    num_ecrou:document.getElementById('num_ecrou').value,
    nature: document.getElementById('nature').value,
    numero: document.getElementById('numero').value,
    date_titre: document.getElementById('date_titre').value,
    origine: document.getElementById('origine').value,
    infraction: document.getElementById('infraction').value,
  };
  try{
      const response = await fetch('../controller/TitreDetProvisoirController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      });
      const result = await response.json();
      if(result.success){
          document.getElementById("message").innerHTML = `<div class="alert alert-success">${result.message}</div>`;
          setTimeout(()=>{ window.location.href="index.php?page="+result.page_suiv},1000)
        }else{ 
            document.getElementById("message").innerHTML = `<div class="alert alert-danger">${result.message}</div>`;
        }
  }catch(e){console.log(e);}

});
