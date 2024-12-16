document.addEventListener('DOMContentLoaded', function() {
    var totalPrice = document.getElementById('totalPrice').innerText;

    document.getElementById('confirmPickupBtn').addEventListener('click', function() {
        $.ajax({
            type: "POST",
            url: 'Services/UpdateOrderService.php',
            data: { pickup: 1, order_status: 'Pending' },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status === "success") {
                    window.location.href = 'OrderConfirmation.php';
                } else {
                    alert('Error updating order: ' + data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                alert('An unexpected error occurred. Please try again.');
            }
        });
    });
});

function showPickupModal() {
    var myModal = new bootstrap.Modal(document.getElementById('pickupModal'), {
        keyboard: false
    });
    myModal.show();
}