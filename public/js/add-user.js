function openForm() {
  document.getElementById("addForm").style.display = "block";
  document.getElementById("btn-addMasterData").style.opacity = 0.2;
  document.getElementById("tbl-master-data-user").style.opacity = 0.2;
}

function closePopup() {
  document.getElementById("addForm").style.display = "none";
  document.getElementById("btn-addMasterData").style.opacity = 1;
  document.getElementById("tbl-master-data-user").style.opacity = 1;
}

function closeForm() {
  document.getElementById("addForm").style.display = "none";
  document.getElementById("btn-addMasterData").style.opacity = 1;
  document.getElementById("tbl-master-data-user").style.opacity = 1;
}

