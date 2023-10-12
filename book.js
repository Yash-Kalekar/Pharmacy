// CART
let cartIcon = document.querySelector("#cart-icon");
let cart = document.querySelector(".cart");
let closeCart = document.querySelector("#close-cart");

// OPEN CART
cartIcon.addEventListener("click", () => {
    cart.classList.add("active");
});

// CLOSE CART
closeCart.addEventListener("click", () => {
    cart.classList.remove("active");
});

$(document).ready(function () {
    $("#dat").datepicker();

    // Initialize the appointments array from local storage
    let appointments = JSON.parse(localStorage.getItem("appointments")) || [];

    // Function to update the local storage with the current appointments
    function updateLocalStorage() {
        localStorage.setItem("appointments", JSON.stringify(appointments));
    }

    $("#consultant").change(function () {
        if ($(this).val() === "other") {
            $("#other-consultant-row").show();
        } else {
            $("#other-consultant-row").hide();
        }
    });

    $("#appointment-form").submit(function (e) {
        e.preventDefault(); // Prevent form submission

        // Check if any required field is empty
        if (
            $("#full-name").val() === "" ||
            $("#mobile-number").val() === "" ||
            $("#email").val() === "" ||
            $("#appointment-date").val() === "" ||
            ($("#consultant").val() === "" || ($("#consultant").val() === "other" && $("#other-consultant").val() === "")) ||
            $("#city").val() === "" ||
            $("#age").val() === "" ||
            $("#gender").val() === ""
        ) {
            alert("Please fill in all required fields.");
        } else {
            // Create an appointment object as before
            const consultantValue = $("#consultant").val();
            let appointment = {};

            if (consultantValue === "other") {
                const customConsultantName = $("#other-consultant").val();
                if (customConsultantName) {
                    appointment.consultant = customConsultantName;
                } else {
                    appointment.consultant = "Custom Consultant (Not Specified)";
                }
            } else {
                appointment.consultant = $("#consultant option:selected").text();
            }

            appointment.name = $("#full-name").val();
            appointment.mobile = $("#mobile-number").val();
            appointment.email = $("#email").val();
            appointment.date = $("#appointment-date").val();
            appointment.city = $("#city").val();
            appointment.age = $("#age").val();
            appointment.gender = $("#gender").val();

            // Add the appointment to the appointments array
            appointments.push(appointment);

            // Update local storage with the updated appointments
            updateLocalStorage();

            // Display the appointment in the cart
            displayAppointmentInCart(appointment);

            // Reset the form
            $("#appointment-form")[0].reset();

            // Show the "appointment booked successfully" alert
            alert("Appointment booked successfully!");
        }
    });

    // Function to display an appointment in the cart
    function displayAppointmentInCart(appointment) {
        const cartContent = document.querySelector(".cart-content");
        const cartItem = document.createElement("div");
        cartItem.classList.add("cart-box");

        // Create the appointment details content
        const appointmentDetails = `
            <div class="detail-box">
                <div class="cart-product-title">Name: ${appointment.name}</div>
                <div class="cart-product-title">Date: ${appointment.date}</div>
                <div class="cart-product-title">Consultant: ${appointment.consultant}</div>
            </div>
            <i class="bx bxs-trash-alt cart-remove"></i>`;

        cartItem.innerHTML = appointmentDetails;
        cartContent.appendChild(cartItem);

        // Add a click event listener for appointment cancellation
        const removeButton = cartItem.querySelector(".cart-remove");
        removeButton.addEventListener("click", function () {
            // Remove the appointment from the appointments array
            const index = appointments.indexOf(appointment);
            if (index !== -1) {
                appointments.splice(index, 1);
                // Update local storage after removal
                updateLocalStorage();
            }
            // Remove the appointment from the cart
            cartItem.remove();
        });
    }
});
