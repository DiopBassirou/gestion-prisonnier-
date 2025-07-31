fetch("../controller/enrollementController.php")
.then(res=>res.json())
.then(data=>{
  console.log(data);
  if(data.success){
      let tbody=document.getElementById("tbody")
      let d=data.data
      d.forEach(element => {
          let tr=document.createElement("tr")
          tr.innerHTML =`
              <td >${element.nomUser} ${element.prenomUser}</td>
              <td >${element.role}</td>  
              <td >${element.prenoms} ${element.nom}</td>  
              <td >${element.main}</td>
              <td >${element.doigt}</td>
              <td >${element.date_enregistrement}</td>
          
          `
          tbody.appendChild(tr)
      
      });
    }else{
          document.getElementById("message").innerHTML = `<div class="alert alert-success">${data.message}</div>`;
    }
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
      $('#myTabl').DataTable();
    } else {
      console.error("DataTables n'est pas chargé !");
    }

    
})