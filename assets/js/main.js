function generateQuota() {
    const data = {
        ID: 1, // Sustituye con el ID correcto
        FECHA: '2024-06-24', // Sustituye con la fecha correcta
        ESTADOS: 'Activo', // Sustituye con el estado correcto
        FECHA_LIMITE: '2024-07-24', // Sustituye con la fecha límite correcta
        PRECIO: 1000 // Sustituye con el precio correcto
    };

    fetch('http://localhost:8080/api/cuotas_administracion/create', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer YOUR_ACCESS_TOKEN', 
            'X-Custom-Header': 'CustomHeaderValue'
            // Otros encabezados si son necesarios
        },
        body: JSON.stringify(data) // El cuerpo de la solicitud
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
