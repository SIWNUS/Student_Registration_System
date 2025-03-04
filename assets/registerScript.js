document.getElementById('detailsForm').addEventListener('submit', function(event){
    event.preventDefault();

    let formData = new FormData(this);

    fetch('../api/register_api.php', {
        method: 'post',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.success);
            window.location.assign('../pages/login.php');
        } else {
            alert(data.error);
        }
    })
    .catch(error => {
        console.error('ERROR: ', error);
        alert(error)
    })
})
