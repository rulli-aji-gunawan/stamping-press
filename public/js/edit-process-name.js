document.addEventListener('DOMContentLoaded', function () {
    // Function to convert text to uppercase
    // function toUpperCase(element) {
    //     element.value = element.value.toUpperCase();
    // }

    // Edit process name
    document.querySelectorAll('.edit-process-name-btn').forEach(button => {
        button.addEventListener('click', function () {
            const processNameId = this.getAttribute('data_id');
            console.log(processNameId);
            fetch(`/master-data/process-name/${processNameId}/edit`)
                .then(response => response.json())
                .then(processName => {
                    document.getElementById('editProcessNameId').value = processName.id;
                    document.getElementById('editProcessName').value = processName.process_name;
                    document.getElementById('editForm').style.display = 'block';
                })
                .catch(error => console.error('Error:', error));
        });
    });


    // Close edit process name
    document.querySelector('#editForm .close-popup').addEventListener('click', function () {
        document.getElementById('editForm').style.display = 'none';
    });
    document.querySelector('#editForm .btn-cancel').addEventListener('click', function () {
        document.getElementById('editForm').style.display = 'none';
    });

    // Submit edit form
    document.getElementById('editForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const processNameId = document.getElementById('editProcessNameId').value;
        const formData = new FormData(e.target);

        fetch(`/master-data/process-name/${processNameId}`, {
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
                // Refresh the Process Name table or update the specific row
                updateProcessNameRow(processNameId, data.processName);
            })
        // .catch(error => console.error('Error:', error));
    });
})

function updateProcessNameRow(processNameId, processNameData) {
    const button = document.querySelector(`button.edit-process-name-btn[data_id="${processNameId}"]`);
    if (!button) return;
    const row = button.closest('tr');
    if (row) {
        row.querySelector('td:nth-child(2) p').textContent = processNameData.process_name;
        row.querySelector('td:nth-child(3) p').textContent = formatDateTime(processNameData.created_at);
        row.querySelector('td:nth-child(4) p').textContent = formatDateTime(processNameData.updated_at);
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