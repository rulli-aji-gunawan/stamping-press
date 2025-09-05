document.addEventListener('DOMContentLoaded', function () {

    // Delete model item
    // Event listener for delete buttons
    document.querySelectorAll('.delete-model-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const modelId = this.getAttribute('data_id');
            const modelCode = this.getAttribute('model_code');
            const itemName = this.getAttribute('item_name');

            const isConfirmed = confirm(`Are you sure you want to delete model ${modelCode} - ${itemName}?`);

            if (isConfirmed) {
                console.log('User confirmed deletion for:', modelCode,  itemName);
                deleteModelItem(modelId, this);
            } else {
                console.log('User cancelled deletion for:', modelCode, itemName);
            }
        });
    });

    function deleteModelItem(modelId, buttonElement) {
        console.log('Attempting to delete model item:', modelId);

        fetch(`/master-data/model-items/${modelId}/delete`, {
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