document.addEventListener('DOMContentLoaded', function() {
    // Select all delete buttons
    const deleteButtons = document.querySelectorAll('.delete');
    
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const email = button.getAttribute('data-email');
            if (confirm("Are you sure you want to delete this student?")) {
                // Append the email as a query parameter
                fetch(`../api/delete_api.php?email=${encodeURIComponent(email)}`, {
                    method: 'GET',
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.success);
                        // Optionally, reload the page to update the list
                        window.location.reload();
                    } else {
                        alert("Error: " + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("An error occurred while deleting the record.");
                });
            }
        });
    });
});
