window.productQuantityChange = function(element) {
  let value = parseInt(String(element.value), 10); // Retrieve the current value from the element
  if (isNaN(value)) {
    value = 10; // Default to 10 if the input is not a valid number
  }

  // Ensure the quantity is a multiple of 10
  let quantity = Math.round(value / 10) * 10;
  if (value < 10) {
    quantity = 10;
  }

  element.value = quantity; // Update the input field with the adjusted value

  // Show an alert if the quantity is 70
  if (quantity === 70) {
    alert('Great Choice');
  }
};
