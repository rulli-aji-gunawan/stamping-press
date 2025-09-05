document.addEventListener('DOMContentLoaded', function () {
    // Function to convert text to uppercase
    function toUpperCase(element) {
        element.value = element.value.toUpperCase();
    }

    // Edit Model
    document.querySelectorAll('.edit-downtime-category-btn').forEach(button => {
        button.addEventListener('click', function () {
            const downtimeCategoryId = this.getAttribute('data_id');
            console.log(downtimeCategoryId);
            fetch(`/master-data/downtime-category/${downtimeCategoryId}/edit`)
                .then(response => response.json())
                .then(downtimeCategory => {
                    document.getElementById('editDowntimeCategoryId').value = downtimeCategory.id;
                    document.getElementById('editDowntimeCategoryName').value = downtimeCategory.downtime_name;
                    document.getElementById('editDowntimeCategoryType').value = downtimeCategory.downtime_type;
                    document.getElementById('editForm').style.display = 'block';
                })
                .catch(error => console.error('Error:', error));
        });
    });


    // Close edit modal
    document.querySelector('#editForm .close-popup').addEventListener('click', function () {
        document.getElementById('editForm').style.display = 'none';
    });
    document.querySelector('#editForm .btn-cancel').addEventListener('click', function () {
        document.getElementById('editForm').style.display = 'none';
    });

    // Submit edit form
    document.getElementById('editForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const downtimeCategoryId = document.getElementById('editDowntimeCategoryId').value;
        const formData = new FormData(e.target);

        fetch(`/master-data/downtime-category/${downtimeCategoryId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-HTTP-Method-Override': 'PUT'
            }
        })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                document.getElementById('editForm').style.display = 'none';
                // Refresh the Model table or update the specific row
                updateDowntimeCategoryRow(downtimeCategoryId, data.downtimeCategory);

            })
            .catch(error => console.error('Error:', error));
    });
})

function updateDowntimeCategoryRow(downtimeCategoryId, downtimeCategoryData) {
    const row = document.querySelector(`button.edit-downtime-category-btn[data_id="${downtimeCategoryId}"]`).closest('tr');
    if (row) {
        row.querySelector('td:nth-child(2) p').textContent = downtimeCategoryData.downtime_name;
        row.querySelector('td:nth-child(3) p').textContent = downtimeCategoryData.downtime_type;
        row.querySelector('td:nth-child(4) p').textContent = formatDateTime(downtimeCategoryData.created_at);
        row.querySelector('td:nth-child(5) p').textContent = formatDateTime(downtimeCategoryData.updated_at);
        // Update kolom lain sesuai kebutuhan
    }

    document.getElementById('editForm').reset();
    document.getElementById('editForm').style.display = 'none';

}

function closeForm() {
    document.getElementById('editForm').style.display = 'none';
}

function formatDateTime(dateTimeString) {
    if (!dateTimeString) return '';
    const date = new Date(dateTimeString);
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    const seconds = String(date.getSeconds()).padStart(2, '0');

    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}