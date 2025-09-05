document.addEventListener('DOMContentLoaded', function () {


    // Delete User
    // Event listener for delete buttons
    document.querySelectorAll('.delete-user-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const userId = this.getAttribute('data-id');
            const userName = this.getAttribute('user-name');

            const isConfirmed = confirm(`Are you sure you want to delete user ${userName}?`);

            if (isConfirmed) {
                console.log('User confirmed deletion for:', userName);
                deleteUser(userId, this);
            } else {
                console.log('User cancelled deletion for:', userName);
            }
        });
    });

    function deleteUser(userId, buttonElement) {
        console.log('Attempting to delete user:', userId);

        fetch(`/users/${userId}/delete`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Delete successful:', data.message);
                    alert(data.message);
                    buttonElement.closest('tr').remove();
                } else {
                    console.error('Delete failed:', data.message);
                    alert('Error deleting user: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the user.');
            });
    }

})