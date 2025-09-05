function openForm() {
  document.getElementById("addForm").style.display = "block";
  document.getElementById("btn-addMasterData").style.opacity = 0.2;
  document.getElementById("tbl-master-data-model-item").style.opacity = 0.2;
}

function closePopup() {
  document.getElementById("addForm").style.display = "none";
  document.getElementById("btn-addMasterData").style.opacity = 1;
  document.getElementById("tbl-master-data-model-item").style.opacity = 1;
}

function closeForm() {
  document.getElementById("addForm").style.display = "none";
  document.getElementById("btn-addMasterData").style.opacity = 1;
  document.getElementById("tbl-master-data-model-item").style.opacity = 1;
}

function toUpperCase() {
  const modelCode = document.getElementById("model_code").value;
  const itemName = document.getElementById("item_name").value;
  document.getElementById("model_code").value = modelCode.toUpperCase();
  document.getElementById("item_name").value = itemName.toUpperCase();
}

document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('addModelItemForm');

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(form);

    fetch(addModelItemUrl, {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    })
      .then(response => {
        if (response.redirected) {
          window.location.href = response.url;
          return;
        }
        return response.json();
      })
      .then(data => {
        if (data && data.message) {
          alert(data.message);
        }
        form.reset();
        closeForm();
        window.location.reload();
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while adding the model item.');
      });
  });
});

