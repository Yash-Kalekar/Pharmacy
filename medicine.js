// CART
let cartIcon = document.querySelector("#cart-icon");
let cart = document.querySelector(".cart");
let closeCart = document.querySelector("#close-cart");


function closeCartOnClickOutside() {
    document.addEventListener('click', function(event) {
        const cart = document.querySelector('.cart');
        if (event.target !== cart && !cart.contains(event.target) && event.target !== cartIcon) {
            cart.classList.remove('active');
        }
    });
}


//OPEN CART
cartIcon.onclick = () => {
    cart.classList.add("active");
    closeCartOnClickOutside();
};
//CLOSE CART
closeCart.onclick = () => {
    cart.classList.remove("active");
};

// Initialize cart items from local storage
let cartItems = JSON.parse(localStorage.getItem('cart')) || [];
if (document.readyState == "loading") {
    document.addEventListener("DOMContentLoaded", ready);
} else {
    ready();
}

//MAKING FUNCTION
function ready(){
    loadCart();
    //REMOVE ITEMS FROM CART
    var removeCartButtons = document.getElementsByClassName("cart-remove");
    console.log(removeCartButtons)
    for (var i = 0; i < removeCartButtons.length; i++){
        var button = removeCartButtons[i];
        button.addEventListener('click', removeCartItem);
    }
    //QUANTITY CHANGES
    var quantityInputs = document.getElementsByClassName("cart-quantity");
    for (var i = 0; i < quantityInputs.length; i++) {
        var input = quantityInputs[i];
        input.addEventListener("change", quantityChanged);
    }
    //ADD TO CART
    var addCart = document.getElementsByClassName("add-cart");
    for (var i = 0; i < addCart.length; i++) {
        var button = addCart[i];
        button.addEventListener("click", addCartClicked);
    }
    //BUY BUTTON WORK
    document
        .getElementsByClassName("btn-buy")[0]
        .addEventListener("click", buyButtonClicked);

    // Load cart items from local storage
    loadCart();
}

// Load cart items from local storage
function loadCart() {
    var cartContent = document.getElementsByClassName("cart-content")[0];
    cartContent.innerHTML = ''; // Clear existing cart content
    cartItems.forEach(item => {
        addProductToCart(item.title, item.price, item.productImg);
    });
    updatetotal();
}

//BUY BUTTON
function buyButtonClicked() {
    var cartItems = document.getElementsByClassName("cart-box");

    // Check if the cart is empty
    if (cartItems.length === 0) {
        alert("Please add items to the cart before buying.");
    } else {
         window.location.href = "payment.html";
    }
    updatetotal();
}


//REMOVE ITEMS FROM CART
function removeCartItem(event){
    var buttonClicked = event.target
    buttonClicked.parentElement.remove();
    updatetotal(); 
    updateCartStorage();
}

//QUANTITY CHANGES
function quantityChanged(event){
    var input = event.target;
    if (isNaN(input.value) || input.value <= 0) {
        input.value = 1;
    }       
    updatetotal();
    updateCartStorage();
}

// ADD TO CART
function addCartClicked(event) {
    var button = event.target;
    var shopProducts = button.parentElement;
    var title = shopProducts.getElementsByClassName("product-title")[0].innerText;
    var price = shopProducts.getElementsByClassName("price")[0].innerText;
    var productImg = shopProducts.getElementsByClassName("product-img")[0].src;
    addProductToCart(title, price, productImg);
    updatetotal();
    updateCartStorage();
}

function addProductToCart(title, price, productImg) {
    var cartShopBox = document.createElement("div");
    cartShopBox.classList.add('cart-box');
    var cartItems = document.getElementsByClassName("cart-content")[0];
    var cartItemsNames = cartItems.getElementsByClassName("cart-product-title");
    
    for (var i = 0; i < cartItemsNames.length; i++) {
        if (cartItemsNames[i].innerText == title) {
            alert("You have already added this item to the cart");
            return;
        }  
    }

    var cartBoxContent = `
        <img src="${productImg}" alt="" class="cart-img">
        <div class="detail-box">
            <div class="cart-product-title">${title}</div>
            <div class="cart-price">${price}</div>
            <input type="number" value="1" class="cart-quantity">
        </div>
        <!--REMOVE CART-->
        <i class="bx bxs-trash-alt cart-remove"></i>`;

    cartShopBox.innerHTML = cartBoxContent;
    cartItems.appendChild(cartShopBox);

    cartShopBox
        .getElementsByClassName('cart-remove')[0]
        .addEventListener('click', removeCartItem);
    
    cartShopBox
        .getElementsByClassName('cart-quantity')[0]
        .addEventListener('change', quantityChanged);

    updateCartStorage();
}

//UPDATE TOTAL
function updatetotal() {
    var cartContent = document.getElementsByClassName("cart-content")[0];
    var cartBoxes = cartContent.getElementsByClassName("cart-box");
    var total = 0;
    for (var i=0; i < cartBoxes.length; i++) {
        var cartBox = cartBoxes[i];
        var priceElement = cartBox.getElementsByClassName("cart-price")[0];
        var quantityElement = cartBox.getElementsByClassName("cart-quantity")[0];
        var price = parseFloat(priceElement.innerText.replace("₹", ""));
        var quantity = quantityElement.value;
        total = total + price * quantity;
    }   
    //IF PRICE CONTAIN SOME CENTS VALUE
    total = Math.round(total * 100) / 100;

    document.getElementsByClassName("total-price")[0].innerText="₹" + total;
}

// Update cart items in local storage
function updateCartStorage() {
    localStorage.setItem('cart', JSON.stringify(cartItems));
}
// Load cart items from local storage
function loadCart() {
    var cartContent = document.querySelector(".cart-content");
    cartContent.innerHTML = ''; // Clear existing cart content
    cartItems.forEach(item => {
        addProductToCart(item.title, item.price, item.productImg);
    });
    updatetotal();
}
// Function to handle search button click
function search() {
    const searchbox = document.getElementById("search-item").value.toUpperCase();
    const productBoxes = document.getElementsByClassName("product-box");
    let medicineFound = false;

    for (let i = 0; i < productBoxes.length; i++) {
        const productName = productBoxes[i].getElementsByClassName("product-title")[0].innerText.toUpperCase();

        if (productName.includes(searchbox)) {
            productBoxes[i].style.display = "";
            medicineFound = true;
        } else {
            productBoxes[i].style.display = "none";
        }
    }

    // Show "Medicine Not Found" message if no medicine is found
    const notFoundMessage = document.getElementById("medicine-not-found");
    if (!medicineFound) {
        notFoundMessage.style.display = "block";
    } else {
        notFoundMessage.style.display = "none";
    }
}

// Load cart items on page load
loadCart();
