// console.log(document.getElementById('num_ecrou').value)
function getTitreDetentionByNumEcrouAndNumero(numEcrou, numero) {
  fetch(`../controller/CondamnationController.php?num_ecrou=${numEcrou}&numero=${numero}`)
  .then(res => res.json())
  .then(data => {  
      
    if(data.success){
        document.getElementById('num_ecrou').value = data.data.num_ecrou || '';
        document.getElementById('nature').value = data.data.nature || '';
        document.getElementById('numero').value = data.data.numero || '';
        document.getElementById('date_titre').value = data.data.date_titre || '';
        document.getElementById('origine').value = data.data.origine || '';
        document.getElementById('infraction').value = data.data.infraction || '';
        document.getElementById('date_condamnation').value = data.data.date_condamnation || '';
        document.getElementById('juridiction').value = data.data.juridiction || '';
        document.getElementById('duree_peine').value = data.data.duree_peine || '';
        document.getElementById('date_liberation').value = data.data.date_liberation || '';
        document.getElementById('message').innerHTML = "";  
    }else {
        document.getElementById('message').innerHTML = `<div class="alert alert-danger">${data.message}</div>`; 
        document.getElementById('nature').value =  '';
        document.getElementById('date_titre').value =  '';
        document.getElementById('origine').value ='';
        document.getElementById('infraction').value ='';
        document.getElementById('date_condamnation').value ='';
        document.getElementById('juridiction').value = '';
        document.getElementById('duree_peine').value ='';
        document.getElementById('date_liberation').value = ''; 
    }
  })
  .catch(err => console.error('Erreur lors de la récupération des données:', err));
}

document.getElementById('numero').addEventListener('input', function() {
  const numero = this.value;
  const numEcrou=document.getElementById('num_ecrou').value;
  getTitreDetentionByNumEcrouAndNumero(numEcrou, numero);       
})

document.getElementById('num_ecrou').addEventListener('input', function() {
  const numEcrou = this.value;
  const numero = document.getElementById('numero').value; 
  getTitreDetentionByNumEcrouAndNumero(numEcrou, numero);    
})


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
      const response = await fetch('../controller/CondamnationController.php', {
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
