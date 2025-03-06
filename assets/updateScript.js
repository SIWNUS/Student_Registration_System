document.getElementById('updateForm').addEventListener('submit', function(event){
    event.preventDefault();

    let formData = new FormData(this);

    fetch('../api/update_api.php', {
        method: 'post',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.success);
            window.location.assign('../pages/dashboard.php');
        } else {
            document.getElementById('message').innerText = data.error;
        }
    })
    .catch(error => {
        console.error('ERROR: ', error);
        alert(error)
    })
})
