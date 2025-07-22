 //cette fonction me permet d'avoir une apercue de l'image du detenu que je vais inserer
 document.getElementById("photo").addEventListener("input",(e)=>{
     const url=document.getElementById("photo").value.trim()
     let img=document.getElementById("image")
     if(url){
        img.src=url;
        img.style.display = 'block';
    }else {
        img.style.display = 'none';
    }
 })

 document.getElementById("form-identite").addEventListener("submit", function(e) {
    e.preventDefault();
    const data = {
      num_ecrou: localStorage.getItem("num_ecrou"),
      taille: document.getElementById("taille").value.trim(),
      corpulence: document.getElementById("corpulence").value.trim(),
      yeux: document.getElementById("yeux").value.trim(),
      cheveux: document.getElementById("cheveux").value.trim(),
      teint: document.getElementById("teint").value.trim(),
      signes_particuliers: document.getElementById("signes_particuliers").value.trim(),
      photo: document.getElementById("photo").value.trim()
    };
    fetch("/fiche_ecrou/public/controller/IdentitePhysiqueController.php", {
      method: "POST",
      headers: {"Content-Type": "application/json"},
      body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(result => {
      if(result.success){
        document.getElementById("message").innerHTML = `<div class="alert alert-success">${result.message}</div>`;
        setTimeout(()=>{ window.location.href="index.php?page="+result.page_suiv},1000)
      }else{
        document.getElementById("message").innerHTML = `<div class="alert alert-danger">${result.message}</div>`;
      }
    })
    .catch(e => {
            console.log(e);
    });
  });
