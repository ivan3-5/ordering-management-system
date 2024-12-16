$(document).ready(function() {
    loadInitialData();
});

function loadInitialData() {
    
    const currentDate = new Date();

    const year = currentDate.getFullYear();
    const month = String(currentDate.getMonth() + 1).padStart(2, '0');
    const day = String(currentDate.getDate()).padStart(2, '0');

    const formattedDate = `${year}-${month}-${day}`;

    document.getElementById("dateToday").innerHTML = `Date: ${formattedDate}`;
}

function removeFromCart(itemId) {
    if (confirm('Are you sure you want to remove this item from the cart?')) {
        $.ajax({
            type: "POST",
            url: 'Services/RemoveFromCartService.php',
            data: { itemId: itemId },
            success: function(response) {
                const data = JSON.parse(response);
                if (data.status === 'success') {
                    location.reload();
                } else {
                    alert('Failed to remove item from cart.');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                alert('An unexpected error occurred. Please try again.');
            }
        });
    }
}

function deleteOrder(orderId) {
    $.ajax({
        type: "POST",
        url: 'Services/DeleteOrderSerivce.php',
        data: { orderId },
        success: function(response) {
            console.log(response);
            location.reload();
        }
    });
}