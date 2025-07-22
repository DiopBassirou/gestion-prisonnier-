fetch("/fiche_ecrou/public/controller/FicheEcrouController.php")
.then(res=>res.json())
.then(data=>{
    if(data.success){
        let selectLangue=document.getElementById("langue")
        
        data.langue.forEach(langue => {
            let option=document.createElement('option')
            option.value=langue['id_langue'];
            option.innerText=langue['langues']
            selectLangue.appendChild(option)
        });
    }else{
        console.error("Erreur lors de la récupération des langues:", data.message);
    }
})

$(document).ready(function() {
    $('#langue').select2({
      placeholder: "Choisissez une ou plusieurs langues",
      allowClear: true
    });
  });

function genererNumeroEcrou() {
  const numAleatoir = Math.floor(Math.random() * 100000);
   let num="111"+numAleatoir
  return parseInt(num);
}


document.getElementById('form').addEventListener("submit",async(e)=>{
  e.preventDefault();
  const data = {
    num_ecrou:genererNumeroEcrou(),
    nom: document.getElementById('nom').value.trim(),
    prenoms: document.getElementById('prenom').value.trim(),
    surnom: document.getElementById('surnom').value.trim(),
    sexe: document.getElementById('sexe').value,
    date_naissance: document.getElementById('date_naissance').value,
    lieu_naissance: document.getElementById('lieu_naissance').value.trim(),
    fils_de: document.getElementById('fils_de').value.trim(),
    fille_de: document.getElementById('fille_de').value.trim(),
    situation_familiale: document.getElementById('situation_familiale').value.trim(),
    nb_enfants: document.getElementById('nb_enfants').value,
    situation_militaire: document.getElementById('situation_militaire').value.trim(),
    profession: document.getElementById('profession').value.trim(),
    qualifications: document.getElementById('qualifications').value.trim(),
    domicile: document.getElementById('domicile').value.trim(),
    nationalite: document.getElementById('nationalite').value,

    prenom_prevenir: document.getElementById('prenom_prevenir').value.trim(),
    nom_prevenir: document.getElementById('nom_prevenir').value.trim(),
    numero_prevenir: document.getElementById('numero_prevenir').value.trim(),
    adresse_prevenir: document.getElementById('adresse_prevenir').value.trim(),

    // id_etablissement: document.getElementById('id_etablissement').value,
    // id_langue:document.getElementById('langue').value, //$('#langue').val(),
    id_langue:$('#langue').val(),
    niveau_instruction: document.getElementById('niveau_instruction').value
  };
  console.log(data.id_langue);
  
    try {
        const res=await fetch('/fiche_ecrou/public/controller/FicheEcrouController.php',{
            method:"POST",
            headers:{"Content-Type":"application/json"},
            body:JSON.stringify(data)
        })
        const result=await res.json()
        if(result.success){
            console.log(result.message);
            localStorage.setItem("num_ecrou",result.num_ecrou)
            document.getElementById("message").innerHTML = `<div class="alert alert-success">${result.message}</div>`;
            setTimeout(()=>{window.location.href="index.php?page="+result.page_suiv} ,1000)
        }else{
            document.getElementById("message").innerHTML = `<div class="alert alert-danger">${result.message}</div>`;
        }
    } catch (error) {
        console.log("erreur",error);
        
    }
    
})