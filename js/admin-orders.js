// Function to handle order completion
document.getElementById('completeOrderBtn').addEventListener('click', function() {
    const orderId = prompt("Enter the Order ID to complete:");
    if (orderId) {
        const rows = document.querySelectorAll('#orderHistoryTable tbody tr');
        rows.forEach(row => {
            const orderIdCell = row.querySelector('td:first-child');
            if (orderIdCell.textContent === orderId) {
                row.querySelector('td:nth-child(6)').textContent = 'Completed'; 
                alert('Order ' + orderId + ' has been completed!');
            }
        });
    }
});

// Function to handle order completion via AJAX
document.getElementById('orderHistoryTable').addEventListener('click', function(event) {
    if (event.target.classList.contains('complete-order-btn')) {
        const orderId = event.target.getAttribute('data-id');
        $.ajax({
            type: "POST",
            url: 'Services/CompleteOrderService.php',
            data: { orderId: orderId },
            success: function(response) {
                const data = JSON.parse(response);
                if (data.status === "success") {
                    alert('Order ' + orderId + ' has been completed!');
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert('Failed to complete the order.');
                }
            }
        });
    }
});

// Function to disable buttons for completed orders on page load
document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('#orderHistoryTable tbody tr');
    rows.forEach(row => {
        const statusCell = row.querySelector('td:nth-child(6)'); // Assuming the status is in the 6th column
        if (statusCell.textContent.trim() === 'Completed') {
            const button = row.querySelector('td:nth-last-child(1) button');
            if (button) {
                button.classList.add('disabled-button');
                button.disabled = true;
            }
        }
    });
});