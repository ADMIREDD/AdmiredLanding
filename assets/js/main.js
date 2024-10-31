async function fetchUnidadResidencialId(userId) {
  try {
    const response = await fetch(`http://localhost:8080/api/unidades_residenciales/user/${userId}`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });
    const data = await response.json();

    if (data && data.data && data.data.ID) {
      return data.data.ID;
    } else {
      console.error("No se encontró el ID de la unidad residencial.");
      return null;
    }
  } catch (error) {
    console.error("Error al obtener el ID de la unidad residencial:", error);
    return null;
  }
}

function generateQuote(id, docNumber) {
  const result = document.getElementById("result");

  fetch(`http://localhost:8080/api/cuotas_administracion/show/${id}`, {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => response.json())
    .then((data) => {
      console.log("Respuesta completa de la API:", data); // Registro de la respuesta completa de la API para depuración

      const cuote = data.data || data; // Ajuste para acceder a los datos según la estructura de la API

      if (cuote && cuote.ID) { // Verifica que `cuote` tenga un `ID`
        result.innerHTML = `
          <h1>ID</h1> <p>${cuote.ID}</p> 
          <h1>NUMERO DOCUMENTO</h1> <p>${docNumber}</p>
          <h1>FECHA</h1> <p>${new Date(cuote.FECHA_MES).toLocaleDateString('es-CO')}</p>
          <h1>FECHA LIMITE</h1> <p>${new Date(cuote.FECHA_PAGO).toLocaleDateString('es-CO')}</p> 
          <h1>PRECIO</h1> <p>$${parseFloat(cuote.VALOR).toLocaleString('es-CO', { minimumFractionDigits: 2 })}</p>
          <h1>ESTADO</h1> <p>${cuote.ESTADO || 'No disponible'}</p>
          <h1>APTO</h1> <p>${cuote.NO_APTO || 'No disponible'}</p>
          <button type="button" class="btn btn-secondary mt-3" onclick="printContent()">Imprimir Cuota</button>
        `;
      } else {
        result.innerHTML = `<p>No se encontró la cuota de administración.</p>`;
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      result.innerHTML = `<p>Ocurrió un error al obtener la cuota de administración.</p>`;
    });
}



