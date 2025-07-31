document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("form");
  const message = document.getElementById("message");

  // Précharger les langues (depuis base si tu veux plus tard)
  $('#langue').select2({
    placeholder: "Langues parlées",
    tags: true,
    width: '100%'
  });

  // Récupère ecrou depuis l'URL
  const params = new URLSearchParams(window.location.search);
  const numEcrou = params.get("ecrou");
  const page = params.get("page");

  if (numEcrou) {
    fetch(`../controller/ModifiFicheEcrou.php?ecrou=${numEcrou}&page=${page}`)
      .then(res => res.json())
      .then(data => {
          
        if (data.status && data.data) {
          remplirFormulaire(data.data);
        } else {
          message.textContent = "Erreur lors du chargement.";
          message.classList.add("text-danger");
        }
      })
      .catch(err => {
        console.error(err);
        message.textContent = "Erreur réseau.";
        message.classList.add("text-danger");
      });
  }

  function remplirFormulaire(detenu) {
    // Remplir les champs texte
    for (const [cle, valeur] of Object.entries(detenu)) {
      const champ = document.getElementById(cle);
      if (champ) champ.value = valeur;
    }
    detenu.langue = detenu.langue ? detenu.langue.split(',') : [];

    // Langue (select2)
    if (detenu.langue && Array.isArray(detenu.langue)) {
        console.log("verrr");
        
      $('#langue').val(detenu.langue).trigger('change');
    }
    
  }

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const formData = new FormData(form);
    try {
      const res = await fetch(`../controller/ModifiFicheEcrou.php?ecrou=${numEcrou}&page=${page}`, {
        method: "POST",
        body: formData
      });

      const data = await res.json();
      console.log("Réponse POST :", data);
      
      message.textContent = data.message;
      message.className = data.status ? "text-success" : "text-danger";

      if (data.status && data.page_suiv) {
        // Redirige vers la page suivante avec le numéro d’écrou
        setTimeout(() => {
          window.location.href = "index.php?page="+data.page_suiv +"&ecrou="+numEcrou;
        }, 1000);
      }

    } catch (error) {
      console.error("Erreur POST :", error);
      message.textContent = "Erreur lors de l’envoi.";
      message.className = "text-danger";
    }
  });
});
