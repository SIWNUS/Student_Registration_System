document.getElementById('credentialForm').addEventListener('submit', function(event){
    event.preventDefault();

    let formData = new FormData(this);

    fetch('../api/password_api.php', {
        method: 'post',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.success);
            window.location.assign('../pages/user_details.php');
        } else {
            alert(data.error);
        }
    })
    .catch(error => {
        console.error('ERROR: ', error);
        alert(error)
    })
})
