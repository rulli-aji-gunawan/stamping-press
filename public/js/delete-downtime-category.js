document.addEventListener('DOMContentLoaded', function () {

    // Delete Downtime Category
    // Event listener for delete buttons
    document.querySelectorAll('.delete-downtime-category-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const downtimeCategoryId = this.getAttribute('data_id');
            const downtimeName = this.getAttribute('downtime_name');
            const downtimeType = this.getAttribute('downtime_type');

            const isConfirmed = confirm(`Are you sure you want to delete Downtime Category? ${downtimeName} - ${downtimeType}?`);

            if (isConfirmed) {
                console.log('User confirmed deletion for:', downtimeName, downtimeType);
                deleteDowntimeCategory(downtimeCategoryId, this);
            } else {
                console.log('User cancelled deletion for:', downtimeName, downtimeType);
            }
        });
    });

    function deleteDowntimeCategory(downtimeCategoryId, buttonElement) {
        console.log('Attempting to delete Downtime Category:', downtimeCategoryId);

        fetch(`/master-data/downtime-category/${downtimeCategoryId}/delete`, {
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
                    alert('Error deleting Downtime Category: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the Downtime Category.');
            });
    }

})