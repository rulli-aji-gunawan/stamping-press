document.addEventListener('DOMContentLoaded', function () {

    // Delete downtime classification
    // Event listener for delete buttons
    document.querySelectorAll('.delete-downtime-classification-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const downtimeClassificationId = this.getAttribute('data_id');
            const downtimeClassificationName = this.getAttribute('dt_classification_name');

            const isConfirmed = confirm(`Apakah anda yakin ingin menghapus downtime classification ${downtimeClassificationName}?`);

            if (isConfirmed) {
                console.log('User confirmed deletion for:', downtimeClassificationName);
                deletedowntimeClassificationName(downtimeClassificationId, this);
            } else {
                console.log('User cancelled deletion for:', downtimeClassificationName);
            }
        });
    });

    function deletedowntimeClassificationName(downtimeClassificationId, buttonElement) {
        console.log('Attempting to delete downtime classification:', downtimeClassificationId);

        fetch(`/master-data/downtime-classification/${downtimeClassificationId}/delete`, {
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