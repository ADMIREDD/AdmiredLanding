function generateQuote(id) {

    fetch(`http://localhost:8080/api/cuotas_administracion/show/${id}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('quoteResult').innerText = JSON.stringify(data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
};

document.getElementById('pqrForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);
    const data = {};
    formData.forEach((value, key) => {
        data[key] = value;
    });

    fetch('http://localhost:8080/api/create', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('pqrResult').innerText = 'PQR creada exitosamente';
    })
    .catch(error => {
        console.error('Error:', error);
    });
});




  
