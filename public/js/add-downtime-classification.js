function openForm() {
  document.getElementById("addForm").style.display = "block";
  document.getElementById("btn-addMasterData").style.opacity = 0.2;
  document.getElementById("tbl-master-data-downtime-classification").style.opacity = 0.2;
}

function closePopup() {
  document.getElementById("addForm").style.display = "none";
  document.getElementById("btn-addMasterData").style.opacity = 1;
  document.getElementById("tbl-master-data-downtime-classification").style.opacity = 1;
}

function closeForm() {
  document.getElementById("addForm").style.display = "none";
  document.getElementById("btn-addMasterData").style.opacity = 1;
  document.getElementById("tbl-master-data-downtime-classification").style.opacity = 1;
}

function properCase(text) {
  return text.toLowerCase()
    .split(' ')
    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
    .join(' ');
}

function toProperCase() {
  const DowntimeClassification = document.getElementById("downtime_classification").value;
  document.getElementById("downtime_classification").value = properCase(DowntimeClassification);
}

document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('addDowntimeClassificationForm');

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    console.log('Form submitted');

    const formData = new FormData(form);

    fetch(addDowntimeClassificationUrl, {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    })
      .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        console.log('Response data:', data);
        // alert(data.message);
        form.reset();
        closeForm();
        // Menambahkan fungsi untuk refresh halaman setelah klik OK pada alert
        window.location.reload();
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while adding the model item.');
      });
  });
});

