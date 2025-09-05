function openForm() {
  document.getElementById("addForm").style.display = "block";
  document.getElementById("btn-addMasterData").style.opacity = 0.2;
  document.getElementById("tbl-master-data-downtime-category").style.opacity = 0.2;
}

function closePopup() {
  document.getElementById("addForm").style.display = "none";
  document.getElementById("btn-addMasterData").style.opacity = 1;
  document.getElementById("tbl-master-data-downtime-category").style.opacity = 1;
}

function closeForm() {
  document.getElementById("addForm").style.display = "none";
  document.getElementById("btn-addMasterData").style.opacity = 1;
  document.getElementById("tbl-master-data-downtime-category").style.opacity = 1;
}

// function toUpperCase() {
//   const downtimeName = document.getElementById("downtime_name").value;
//   document.getElementById("downtime_name").value = downtimeName.toUpperCase();
// }

document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('addDowntimeCategoryForm');

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    console.log('Form submitted');

    const formData = new FormData(form);

    fetch(addDowntimeCategoryUrl, {
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
        alert(data.message);
        form.reset();
        closeForm();
        // Menambahkan fungsi untuk refresh halaman setelah klik OK pada alert
        window.location.reload();
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while adding the downtime category.');
      });
  });
});

