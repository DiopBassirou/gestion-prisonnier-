    
  const message = document.getElementById("message");

  document.getElementById("form-empreinte").addEventListener("submit", async function (e) {
    e.preventDefault();

    const num_ecrou = localStorage.getItem("num_ecrou"); 

    const data = {
      num_ecrou: num_ecrou,
      main: document.getElementById("main").value,
      doigt: document.getElementById("doigt").value,
      id_sdk: document.getElementById("id_sdk").value.trim()
    };

    try {
      const res = await fetch("/fiche_ecrou/public/controller/EmpreintController.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data),
      });

      const result = await res.json();
      if(result.success){
         document.getElementById("message").innerHTML = `<div class="alert alert-success">${result.message}</div>`;
        setTimeout(()=>{ window.location.href="index.php?page="+result.page_suiv},1000)
      }else{
         document.getElementById("message").innerHTML = `<div class="alert alert-danger">${result.message}</div>`;
      }

    } catch (error) {
      console.log("Erreur lors de l’envoi.");
      console.log(error);
    }
  });
