$(document).ready(function() {
    getOrderCount();

    $('#logout-button').on('click', function() {
        $.ajax({
            type: "POST",
            url: 'Services/LogoutService.php',
            success: function(response) {
                console.log('Logged out and cart cleared: ', response);
                window.location.href = 'homepage.php'; 
            }
        });
    });
});

function getOrderCount() {
    $.ajax({
        type: "POST",
        url: 'Services/GetOrderCountService.php',
        success: function(response) {
            try {
                const count = JSON.parse(response);
                $('#orderCount').text(count);
            } catch (e) {
                console.error('Error parsing JSON:', e);
                console.log('Response:', response);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
        }
    });
}

let currentItemId = '';

function openOrderWindow(productName, productPrice, productDescription, productImage, itemId) {
    $('#orderName').text(productName);
    $('#totalPrice').text(productPrice.toFixed(2));
    $('#orderDescription').text(productDescription);
    $('#orderImg').attr('src', productImage);
    $('#itemId').val(itemId);
    $('#orderWindow').show();
}

function addToCart() {
    const quantity = parseInt(document.getElementById("quantity").value);     
    const orderName = document.getElementById("orderName").innerText;
    const totalPrice = parseFloat(document.getElementById("totalPrice").innerText);
    const orderDescription = document.getElementById("orderDescription").innerText;
    const orderImg = document.getElementById("orderImg").src; 
    const itemId = $('#itemId').val();

    $.ajax({
        type: "POST",
        url: 'Services/AddToCartService.php',
        data: { quantity, orderName, totalPrice, orderDescription, orderImg, itemId },
        dataType: 'json',
        success: function(data) {
            console.log('Raw Response:', data);

            if (data.status === "success") {
                closeOrderWindow();
                alert('Item added to cart.');
                getOrderCount();
            } else {
                alert('Error adding item to cart: ' + data.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            if (xhr.responseJSON && xhr.responseJSON.message) {
                alert('Error: ' + xhr.responseJSON.message);
            } else {
                alert('An unexpected error occurred. Please try again.');
            }
        }
    });
}

function closeOrderWindow() {
    $('#orderWindow').hide();
}

function adjustQuantity(change) {
    const quantityInput = $('#quantity');
    let quantity = parseInt(quantityInput.val());
    quantity += change;
    if (quantity < 1) quantity = 1;
    quantityInput.val(quantity);
}