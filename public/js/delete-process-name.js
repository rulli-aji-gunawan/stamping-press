document.addEventListener('DOMContentLoaded', function () {

    // Delete process name
    // Event listener for delete buttons
    document.querySelectorAll('.delete-process-name-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const processId = this.getAttribute('data_id');
            const processName = this.getAttribute('process_name');

            const isConfirmed = confirm(`Apakah anda yakin ingin menghapus process name ${processName}?`);

            if (isConfirmed) {
                console.log('User confirmed deletion for:', processName);
                deleteProcessName(processId, this);
            } else {
                console.log('User cancelled deletion for:', processName);
            }
        });
    });

    function deleteProcessName(processId, buttonElement) {
        console.log('Attempting to delete process name:', processId);

        fetch(`/master-data/process-name/${processId}/delete`, {
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