document.getElementById("form-renvoi").addEventListener("submit", async (e) => {
  e.preventDefault();

  const data = {
    num_ecrou: document.getElementById("num_ecrou").value.trim(),
    numero: document.getElementById("numero").value.trim(),
    nouvelle_date: document.getElementById("nouvelle_date").value,
    date_decision_renvoi: document.getElementById("date_decision_renvoi").value,
    motif_renvoi: document.getElementById("motif_renvoi").value.trim()
  };

  const res = await fetch("../controller/FormRenvoiController.php", {
    method: "POST",
    headers: {"Content-Type": "application/json"},
    body: JSON.stringify(data)
  });

  const result = await res.json();
  if(result.success){
      document.getElementById("message").innerHTML = `<div class="alert alert-success">${result.message}</div>`;
      setTimeout(() => window.location.href = "index.php?page=" + result.page_suiv, 1000);
    } else {
      document.getElementById("message").innerHTML = `<div class="alert alert-danger">${result.message}</div>`;
      console.log("Erreur:", result.erreur);
      
    }
});
