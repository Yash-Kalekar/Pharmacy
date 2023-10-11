  // Function to show the popup
  function showPopup() {
    document.getElementById("popup").style.display = "block";
  }

  // Function to close the popup
  function closePopup() {
    document.getElementById("popup").style.display = "none";
    window.location.href = "medicine.html";
  }

  // Function to validate the form before showing the popup
  function validateForm() {
    var cardHolder = document.querySelector(".card input");
    var cardNumber = document.querySelector(".card input[data-mask]");
    var expiryDate = document.querySelector(".card-item input[name='expiry-data']");
    var cvc = document.querySelector(".card-item input[data-mask]");

    if (cardHolder.value === "" || cardNumber.value === "" || expiryDate.value === "" || cvc.value === "") {
      alert("Please fill in all required fields.");
      return false;
    }

    // You can add more specific validation rules here if needed.

    showPopup();
    return false;
  }

  // Event listener for the Pay button
  document.getElementById("payBtn").addEventListener("click", validateForm);

  // Event listener for the popup close button
  document.getElementById("popup-close-btn").addEventListener("click", closePopup);
  // Event listener for the popup close icon
  document.getElementById("popup-close").addEventListener("click", closePopup);