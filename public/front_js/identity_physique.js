document.getElementById("photo").addEventListener("change", (e) => {
  const file = e.target.files[0];
  if (file) {
    const img = document.getElementById("image");
    img.src = URL.createObjectURL(file); // apercu
    img.style.display = 'block';
  }
});

document.getElementById("form-identite").addEventListener("submit", function(e) {
  e.preventDefault();

  const formData = new FormData();
  formData.append("photo", document.getElementById("photo").files[0]);
  formData.append("taille", document.getElementById("taille").value.trim());
  formData.append("corpulence", document.getElementById("corpulence").value.trim());
  formData.append("yeux", document.getElementById("yeux").value.trim());
  formData.append("cheveux", document.getElementById("cheveux").value.trim());
  formData.append("teint", document.getElementById("teint").value.trim());
  formData.append("signes_particuliers", document.getElementById("signes_particuliers").value.trim());

  fetch("/fiche_ecrou/public/controller/IdentitePhysiqueController.php", {
    method: "POST",
    body: formData
  })
  .then(res => res.json())
  .then(result => {
    if(result.success){
      document.getElementById("message").innerHTML = `<div class="alert alert-success">${result.message}</div>`;
      setTimeout(() => window.location.href = "index.php?page=" + result.page_suiv, 1000);
    } else {
      document.getElementById("message").innerHTML = `<div class="alert alert-danger">${result.message}</div>`;
    }
  })
  .catch(e => console.log(e));
});
