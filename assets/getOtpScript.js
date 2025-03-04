console.log("script.js loaded");

document.getElementById('getOtp').addEventListener('submit', function(event){
    event.preventDefault();

    let formData = new FormData(this);

    fetch('../api/send_otp.php', {
        method: 'post',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.success);
            window.location.assign('../pages/verify_otp.php');
        } else {
            alert(data.error);
        }
    })
    .catch(error => {
        console.error('ERROR: ', error);
        alert(error)
    })
})
