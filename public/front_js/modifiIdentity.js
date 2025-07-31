document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('form-identite');
  const imagePreview = document.getElementById('image');
  const photoInput = document.getElementById('photo');
  const message = document.getElementById('message');

  const urlParams = new URLSearchParams(window.location.search);
  const ecrou = urlParams.get('ecrou');
  const page = 'modifIdentityPysique';

  let anciennePhoto = '';

  // 1. Récupération des données en GET
  fetch(`../controller/ModifiControllerIdentity.php?ecrou=${ecrou}&page=${page}`)
    .then(res => res.json())
    .then(res => {
        console.log(res);
      if (res.status && res.data) {
        const data = res.data;

        // Pré-remplir le formulaire
        document.getElementById('taille').value = data.taille || '';
        document.getElementById('corpulence').value = data.corpulence || '';
        document.getElementById('yeux').value = data.yeux || '';
        document.getElementById('cheveux').value = data.cheveux || '';
        document.getElementById('teint').value = data.teint || '';
        document.getElementById('signes_particuliers').value = data.signes_particuliers || '';

        // Affichage de la photo existante
        console.log(data.photo);
        
        if (data.photo) {
          anciennePhoto = data.photo;
          imagePreview.src = `image/${data.photo}`;
        }
      } else {
        message.textContent = res.message || 'Erreur lors du chargement.';
        message.classList.add('text-danger');
      }
    })
    .catch(err => {
      message.textContent = 'Erreur réseau lors de la récupération.';
      message.classList.add('text-danger');
    });

  // 2. Envoi du formulaire
  form.addEventListener('submit', e => {
    e.preventDefault();

    const formData = new FormData();
    formData.append('taille', document.getElementById('taille').value);
    formData.append('corpulence', document.getElementById('corpulence').value);
    formData.append('yeux', document.getElementById('yeux').value);
    formData.append('cheveux', document.getElementById('cheveux').value);
    formData.append('teint', document.getElementById('teint').value);
    formData.append('signes_particuliers', document.getElementById('signes_particuliers').value);

    const photoFile = photoInput.files[0];
    if (photoFile) {
      formData.append('photo', photoFile);
    } else {
      // Simuler une ancienne photo en cas d'absence de nouveau fichier
      const fileName = anciennePhoto || 'default.png';
      const blob = new Blob([], { type: 'image/png' }); // vide mais exigé pour le format
      const file = new File([blob], fileName);
      formData.append('photo', file);
    }

    fetch(`../controller/ModifiControllerIdentity.php?ecrou=${ecrou}&page=${page}`, {
      method: 'POST',
      body: formData
    })
      .then(res => res.json())
      .then(res => {
        if (res.status) {
          message.textContent = res.message;
          message.classList.remove('text-danger');
          message.classList.add('text-success');

          if (res.page_suiv) {
            setTimeout(() => {
              window.location.href = `./${res.page_suiv}.php?ecrou=${ecrou}`;
            }, 1500);
          }
        } else {
          message.textContent = res.message;
          message.classList.add('text-danger');
        }
      })
      .catch(err => {
        message.textContent = 'Erreur lors de la soumission.';
        message.classList.add('text-danger');
      });
  });
});
