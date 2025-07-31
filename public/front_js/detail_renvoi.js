document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const num_ecrou = urlParams.get('ecrou');
    const numero = urlParams.get('numero');

    if (!num_ecrou || !numero) {
        alert("Paramètres manquants dans l'URL");
        return;
    }

    fetch(`../controller/DetailRenvoiController.php?num_ecrou=${num_ecrou}&numero=${numero}`)
        .then(res => res.json())
        .then(data => {
            
            if(!data.success && data.error) {
                document.getElementById("detailContainer").innerHTML = `<h5 id="message">${data.message}</h5>`;
                console.error(data.error);
                return;
            }
            document.getElementById("nomPrenom").textContent = `${data.data.nom} ${data.data.prenoms}`;
            document.getElementById("infraction").textContent = data.data.infraction || "Non précisée";
            document.getElementById("nbRenvoi").textContent = data.data.nb_renvois;
            document.getElementById("ancienneDate").textContent = data.data.ancienne_date || "";
            document.getElementById("nouvelleDate").textContent = data.data.nouvelle_date || "Proces non encore fixé";
            document.getElementById("motif").textContent = data.data.motif_renvoi || "-";
            document.getElementById("nature").textContent = data.data.nature || "-";
            document.getElementById("etablissement").textContent = data.data.etablissement || "-";
            document.getElementById("dateDecision").textContent = data.data.date_decision_renvoi || "Procès non encore fixé";
            
            const photo = data.data.photo ;
            document.getElementById("photo").src = photo;
        })
        .catch(err => {
            console.error(err);
            alert("Erreur de récupération des données");
        });
});


document.getElementById("btnHistorique").addEventListener("click", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const num_ecrou = urlParams.get('ecrou');
    const numero = urlParams.get('numero');

    fetch(`../controller/HistoriqueRenvoisController.php?num_ecrou=${num_ecrou}&numero=${numero}`)
        .then(res => res.json())
        .then(data => {
            if (!data.success || !data.data.length) {
                alert("Aucun historique trouvé.");
                return;
            }

            const tbody = document.getElementById("historiqueBody");
            tbody.innerHTML = "";

            data.data.forEach(r => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>${r.ancienne_date || '-'}</td>
                    <td>${r.nouvelle_date || '-'}</td>
                    <td>${r.date_decision_renvoi || '-'}</td>
                    <td>${r.motif_renvoi || '-'}</td>
                `;
                tbody.appendChild(tr);
            });

            document.getElementById("historiqueContainer").style.display = "block";
        })
        .catch(err => {
            console.error(err);
            alert("Erreur lors de la récupération de l'historique.");
        });
});
