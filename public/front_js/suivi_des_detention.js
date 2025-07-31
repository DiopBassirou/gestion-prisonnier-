let tbody=document.getElementById("tbody")
//pour chercher ces titres detention a traver son numero d'ecrou
document.getElementById("num_ecrou").addEventListener("input", function() {
    document.getElementById("numero").value = ""; // Supprimer la valeur de numero lorsque num_ecrou est utilisé
    tbody.innerHTML = ""; // Effacer le corps du tableau avant de récupérer de nouvelles données
    let num_ecrou = this.value.trim();
    fetch("../controller/SuiviDetentionsController.php?num_ecrou="+num_ecrou)
    .then(res=>res.json())
    .then(data=>{
    console.log(data);
    if(data.success){
        let d=data.data
        d.forEach(element => {
            let tr=document.createElement("tr")
            tr.innerHTML =`
                <td >${element.nature}</td>  
                <td >${element.origine} </td>  
                <td >${element.infraction}</td>
                <td >${element.date_titre}</td>
                <td >
                    <a style="text-decoration: none;"  class="btn btn-success btn-sm " href="index.php?page=detail_renvoi&ecrou=${element.num_ecrou}&numero=${element.numero}">Details</a>
                </td> 
                
                `
            tbody.appendChild(tr)
        
        });
            document.getElementById("message").innerHTML = "";
    }else{
            tbody.innerHTML = "";
            document.getElementById("message").innerHTML = `<div class="alert alert-success">${data.message}</div>`;
    }
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        $('#myTabl').DataTable();
    } else {
        console.error("DataTables n'est pas chargé !");
    } 
    })
})

//pour chercher un titre detention specifique a travers son numero
document.getElementById("numero").addEventListener("input", function() {
    document.getElementById("num_ecrou").value = ""; // Supprimer la valeur de num_ecrou lorsque numero est utilisé
    tbody.innerHTML = ""; // Effacer le corps du tableau avant de récupérer de nouvelles données
    let numero = this.value.trim();
    fetch("../controller/SuiviDetentionsController.php?numero="+numero)
    .then(res=>res.json())
    .then(data=>{
    console.log(data);
    if(data.success){
        let element=data.data
        console.log(data);
        
        console.log(element);
        
            let tr=document.createElement("tr")
            tr.innerHTML =`
                <td >${element.nature}</td>  
                <td >${element.origine} </td>  
                <td >${element.infraction}</td>
                <td >${element.date_titre}</td>
                <td >
                    <a style="text-decoration: none;"  class="btn btn-success btn-sm " href="index.php?page=detail_renvoi&ecrou=${element.num_ecrou}&numero=${element.numero}">Details</a>
                </td>
                
                `
            tbody.appendChild(tr)
        
            document.getElementById("message").innerHTML = "";
    }else{
            tbody.innerHTML = "";
            document.getElementById("message").innerHTML = `<div class="alert alert-success">${data.message}</div>`;
    }
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        $('#myTabl').DataTable();
    } else {
        console.error("DataTables n'est pas chargé !");
    } 
    })
    
})

window.addEventListener("DOMContentLoaded", () => {
    const num_ecrou_input = document.getElementById("num_ecrou");
    const numero_input = document.getElementById("numero");

    // Si num_ecrou a une valeur, on relance la recherche
    if (num_ecrou_input.value.trim() !== "") {
        num_ecrou_input.dispatchEvent(new Event("input"));
    }

    // Sinon, si numero a une valeur, on relance la recherche
    else if (numero_input.value.trim() !== "") {
        numero_input.dispatchEvent(new Event("input"));
    }
});
 

// window.addEventListener("pageshow", () => {
//     const num_ecrou_input = document.getElementById("num_ecrou");
//     const numero_input = document.getElementById("numero");

//     if (num_ecrou_input.value.trim() !== "") {
//         num_ecrou_input.dispatchEvent(new Event("input"));
//     } else if (numero_input.value.trim() !== "") {
//         numero_input.dispatchEvent(new Event("input"));
//     }
// });
