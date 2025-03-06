document.getElementById('validateOtp').addEventListener('submit', function(event) {
    event.preventDefault();

    let formData = new FormData(this);

    fetch('../api/validate_api.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.success);
            window.location.assign('../pages/credentials.php');
        } else {
            document.getElementById('message').innerText = data.error;
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert("Fetch error: " + error);
    });
});