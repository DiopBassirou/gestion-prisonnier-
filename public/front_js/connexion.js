document.getElementById("form").addEventListener("submit",async(e)=>{
    e.preventDefault();
    const data={
        "password":document.getElementById("password").value.trim(),
        "email":document.getElementById("email").value.trim()
    }
    try{
        const res=await fetch("/fiche_ecrou/public/controller/ConnexionController.php",{
            method:"POST",
            headers:{"Content-Type":"application/json"},
            body:JSON.stringify(data)
        })
        const result=await res.json()
        console.log(result);
        if(result.success){
            localStorage.setItem("nom_utilisateur",result.nom_utilisateur)
            window.location.href="index.php?page=historique"
          let  message=document.getElementById('message')
          message.innerHTML=result.message
          message.style.color="green"
        }else{
            let  message=document.getElementById('message')
            message.innerHTML=result.message
        }       
    }catch(error){
        console.log(error); 
    }
})