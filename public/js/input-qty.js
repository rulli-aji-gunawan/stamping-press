const inputQty = document.querySelector(".input-qty");
function limitInputLength(inputQty, maxLength) {
  if (inputQty.value.length > maxLength) {
    inputQty.value = inputQty.value.slice(0, maxLength);
  }
};

