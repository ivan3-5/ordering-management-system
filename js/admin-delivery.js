// Function to handle delivery status form submission
document.querySelector('.delivery-status').addEventListener('submit', function(event) {
    event.preventDefault();

    const orderId = document.getElementById('orderId').value;
    const status = document.getElementById('status').value;

    $.ajax({
        type: "POST",
        url: 'Services/UpdateDeliveryStatusService.php',
        data: { orderId, status },
        success: function(response) {
            const data = JSON.parse(response);
            if (data.status === "success") {
                alert('Delivery status updated successfully!');
                loadDeliveries();
            } else {
                alert('Failed to update delivery status.');
            }
        }
    });
});

// Function to load delivery orders
function loadDeliveries() {
    $.ajax({
        type: "GET",
        url: 'Services/GetDeliveryOrdersService.php',
        success: function(response) {
            const deliveries = JSON.parse(response);
            const deliveryTable = document.querySelector('#deliveryOrdersTable tbody');
            deliveryTable.innerHTML = '';
            deliveries.forEach(delivery => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${delivery.orderID}</td>
                    <td>${delivery.customerName}</td>
                    <td>${delivery.status}</td>
                    <td>${delivery.dateCreated}</td>
                    <td>${delivery.dateUpdated}</td>
                `;
                deliveryTable.appendChild(row);
            });
        }
    });
}

// Load deliveries on page load
window.onload = loadDeliveries;