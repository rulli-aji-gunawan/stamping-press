document.addEventListener('DOMContentLoaded', function () {

    // Edit downtime classification
    document.querySelectorAll('.edit-downtime-classification-btn').forEach(button => {
        button.addEventListener('click', function () {
            const DowntimeClassificationId = this.getAttribute('data_id');
            console.log(DowntimeClassificationId);
            fetch(`/master-data/downtime-classification/${DowntimeClassificationId}/edit`)
                .then(response => response.json())
                .then(DowntimeClassification => {
                    document.getElementById('editDowntimeClassificationId').value = DowntimeClassification.id;
                    document.getElementById('editDowntimeClassification').value = DowntimeClassification.downtime_classification;
                    document.getElementById('editForm').style.display = 'block';
                })
                .catch(error => console.error('Error:', error));
        });
    });


    // Close edit downtime classification
    document.querySelector('#editForm .close-popup').addEventListener('click', function () {
        document.getElementById('editForm').style.display = 'none';
    });
    document.querySelector('#editForm .btn-cancel').addEventListener('click', function () {
        document.getElementById('editForm').style.display = 'none';
    });

    // Submit edit form
    document.getElementById('editForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const DowntimeClassificationId = document.getElementById('editDowntimeClassificationId').value;
        const formData = new FormData(e.target);

        fetch(`/master-data/downtime-classification/${DowntimeClassificationId}`, {
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
                updateDowntimeClassificationRow(DowntimeClassificationId, data.DowntimeClassification);
            })
    });
})

function updateDowntimeClassificationRow(DowntimeClassificationId, DowntimeClassificationData) {
    const button = document.querySelector(`button.edit-downtime-classification-btn[data_id="${DowntimeClassificationId}"]`);
    if (!button) return;
    const row = button.closest('tr');
    if (row) {
        row.querySelector('td:nth-child(2) p').textContent = DowntimeClassificationData.downtime_classification;
        row.querySelector('td:nth-child(3) p').textContent = formatDateTime(DowntimeClassificationData.created_at);
        row.querySelector('td:nth-child(4) p').textContent = formatDateTime(DowntimeClassificationData.updated_at);
        // Update kolom lain sesuai kebutuhan
    }

    // document.getElementById('editForm').reset();
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