fetch("/fiche_ecrou/public/controller/InscriptionController.php")
.then(res=>res.json())
.then(data=>{
    if(data.success){
        let select=document.getElementById("id_etablissement")

        data.etablissement.forEach(etablissement => {
            let option=document.createElement('option')
            option.value=etablissement['id_etablissement'];
            option.innerText=etablissement['nom_etablissement']
            select.appendChild(option)
        });
    }
})

document.getElementById('form').addEventListener("submit",async(e)=> {
    e.preventDefault();
    const data={
            "prenom":document.getElementById('prenom').value.trim(),
            "nom":document.getElementById('nom').value.trim(),
            "password":document.getElementById('password').value.trim(),
            "email":document.getElementById('email').value.trim(),
            "role":document.getElementById('role').value.trim(),
            "id_etablissement": document.getElementById('id_etablissement').value
        };
    try{
        
         const res=await fetch("/fiche_ecrou/public/controller/InscriptionController.php",{
            method:"POST",
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        const result=await res.json()
                   
            if(result.success){
           // window.location.href=""
            document.getElementById("message").innerHTML = `<div class="alert alert-success">${result.message}</div>`;
            setTimeout(()=>{ window.location.href="index.php?page="+result.page_suiv},1000)
                      
            }else{
            let message=document.getElementById('message');
            message.innerHTML=result.error
            }
    }
    catch(Error){
        console.log("erreur serveur",Error)
    };
})