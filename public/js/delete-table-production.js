document.addEventListener('DOMContentLoaded', function () {

    // Delete process name
    // Event listener for delete buttons
    document.querySelectorAll('.delete-table-production-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const productionId = this.getAttribute('data_id');
            const itemName = this.getAttribute('item_name');
            const productionDate = this.getAttribute('production_date');

            const isConfirmed = confirm(`Apakah anda yakin ingin menghapus data produksi ${itemName} tanggal ${productionDate}?`);

            if (isConfirmed) {
                console.log('User confirmed deletion for:', itemName, productionDate);
                deleteDataProduction(productionId, this);
            } else {
                console.log('User cancelled deletion for:', itemName, productionDate);
            }
        });
    });

    function deleteDataProduction(productionId, buttonElement) {
        // console.log('Attempting to delete item name:', itemName);
        console.log('Attempting to delete id:', productionId);

        fetch(`/table-data/table-production/${productionId}/delete`, {
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
                    window.location.reload(); // Refresh halaman
                } else {
                    console.error('Delete failed:', data.message);
                    alert('Error deleting data: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the user.');
            });
    }

})