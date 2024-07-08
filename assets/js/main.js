function generateQuote(id, docNumber) {
  const result = document.getElementById("result")

  fetch(`http://localhost:8080/api/cuotas_administracion/show/${id}`, {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => response.json())
    .then((data) => {
      const { data:cuote  } = data
      console.log(cuote)
      result.innerHTML = `
        <h1>ID</h1> <p>${cuote.ID}</p> 
        <h1>NUMERO DOCUMENTO</h1> <p> ${docNumber} </p>
        <h1>FECHA</h1> <p>${new Date(cuote.FECHA).toLocaleDateString('es-Co')} </p>
        
        <h1>FECHA LIMITE</h1> <p> ${new Date(cuote.FECHA_LIMITE).toLocaleDateString('es-Co')} </p> 
        <h1>PRECIO</h1> <p> $${cuote.PRECIO} </p> </br>
       <button type="button" class="btn btn-secondary mt-3" onclick="printContent()">Imprimir Cuota</button>
      `;
      
      
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

function createPQR(userId) {
  const mensaje = document.getElementById("mensaje").value;
  //demas campos

  const formData = new FormData();
  formData.append("DETALLE", mensaje);
  formData.append("ESTADO_ID", 0);
  formData.append("PQR_TIPO", 1);
  formData.append("USUARIO_ID", userId);

  fetch(`http://localhost:8080/api/pqr/create`, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
        if(data) {
            window.location.href = "?c=usuarios&m=cuota";
        }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

