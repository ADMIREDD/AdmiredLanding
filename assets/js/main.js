function generateQuota() {
    const formdata = new FormData();
    formdata.append("FECHA", "2024-08-05");
    formdata.append("ESTADO", "pendiente");
    formdata.append("FECHA_LIMITE", "2024-10-05");
    formdata.append("PRECIO", "50000");

    fetch('http://localhost:8080/api/cuotas_administracion/create', {
        method: 'POST',
       
        body: formdata // El cuerpo de la solicitud
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Success:', data);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}    
