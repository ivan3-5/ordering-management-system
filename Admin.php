<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['UserRole'] !== 'admin') {
    header('Location: homepage.php');
    exit();
}

require_once 'Services/OrderService.php';
$orderService = new OrderService();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderId'])) {
    $orderService->completeOrder($_POST['orderId']);
    header('Location: Admin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="css/Admin.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="Photos/image logo.png" alt="Logo">
            </div>
            <div class="admin-sign">
                ADMIN
            </div>
        </nav>
    </header>
    
    <div class="container">
        <aside class="sidebar">
            <button class="nav-button" data-content="dashboard">DASHBOARD</button>
            <button class="nav-button" data-content="orders">ORDERS</button>
            <button class="nav-button" data-content="customer-service">CUSTOMER SERVICE</button>
            <button class="nav-button" data-content="delivery">DELIVERY</button>
            <button class="nav-button" data-content="menu-list">MENU LIST</button>
            <button class="logout" id="logout-button" onclick="logout()">LOGOUT</button>
        </aside>
        

        <!-- Main content area starts here -->

        <div class="content">
            <!-- Dashboard Section -->
            <div id="dashboard" class="content-section dashboard">
                <h2>Dashboard</h2>


            <!-- Statistics Section -->
            <div class="statistics">
                <div class="stat-box">
                    <h4>Total Orders This Month</h4>
                    <p id="totalOrders">100</p>
                </div>
                <div class="stat-box">
                    <h4>Total Earnings This Month</h4>
                    <p id="totalEarnings">$5000</p>
                </div>
                <div class="stat-box">
                    <h4>Total Tickets This Month</h4>
                    <p id="totalTickets">150</p>
                </div>
                <div class="stat-box">
                    <h4>Total Refunds This Month</h4>
                    <p id="totalRefunds">20</p>
                </div>
            </div>


                <!-- Graph Section -->
                <div class="graph-section">
                <h3>Yearly Orders Overview</h3>
                <!-- Yearly Orders Graph -->
                <canvas id="yearlyOrdersGraph" width="400" height="200"></canvas>
                    

                <!-- Monthly Orders Graph -->
                <h3>Monthly Orders Overview</h3>
                <canvas id="monthlyOrdersGraph" width="400" height="200"></canvas>

                <!-- Quarterly Orders Graph -->
                <h3>Quarterly Orders Overview</h3>
                <canvas id="quarterlyOrdersGraph" width="400" height="200"></canvas>
                 </div>           
            </div>



            <!-- Orders Section -->
            <div id="orders" class="content-section">
                <h2>Orders</h2>
                <button id="completeOrderBtn">Complete Order</button>
                <table id="orderHistoryTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Order Name</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Order Description</th>
                            <th>Status</th>
                            <th>Order ID</th>
                            <th>User ID</th>
                            <th>Date Created</th>
                            <th>Date Updated</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $orderService->getOrders(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Customer Service Section -->
            <div id="customer-service" class="content-section">
                <h2>Customer Service</h2>
                <p>Manage customer inquiries, feedback, and support requests here.</p>
                
                <!-- Ticket System Form -->
                <form id="ticket-form">
                    <div class="form-group">
                        <label for="customer-name">Customer Name</label>
                        <input type="text" id="customer-name" name="customer-name" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="ticket-subject">Subject</label>
                        <input type="text" id="ticket-subject" name="ticket-subject" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="ticket-message">Message</label>
                        <textarea id="ticket-message" name="ticket-message" required class="form-control" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="ticket-status">Status</label>
                        <select id="ticket-status" name="ticket-status" class="form-control">
                            <option value="open">Open</option>
                            <option value="in-progress">In Progress</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Ticket</button>
                </form>

                <!-- View Submitted Tickets -->
                <div id="submitted-tickets" class="mt-5">
                    <h3>Submitted Tickets</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Ticket ID</th>
                                <th>Customer Name</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dynamic content will go here -->
                        </tbody>
                    </table>
                </div>
            </div>

            


            <!-- Delivery Section -->
            <div id="delivery" class="content-section">
                <h2>Delivery</h2>
                <p>Manage delivery status and orders here.</p>
                
                <!-- Delivery Status Form -->
                <form class="delivery-status">
                    <label for="orderId">Order ID</label>
                    <input type="text" id="orderId" placeholder="Enter Order ID" required />
                    
                    <label for="status">Delivery Status</label>
                    <select id="status" required>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    
                    <button type="submit" id="updateStatusBtn">Update Delivery Status</button>
                </form>
            </div>



            <!-- Menu List Section -->
            <div id="menu-list" class="content-section">
                <h2>Menu List</h2>
                <p>Manage and update the menu items here.</p>

                    <!-- Form to Add Product -->
                <form id="add-product-form">
                    <label for="product-name">Product Name:</label>
                    <input type="text" id="product-name" name="product-name" required>

                    <label for="product-category">Category:</label>
                    <select id="product-category" name="category" required>
                        <option value="" disabled selected>Select a Category</option>
                        <option>COffeee</option>
                        <option>Pastries</option>
                        <!-- Categories will be dynamically added here -->
                    </select>

                    <label for="product-price">Price ($):</label>
                    <input type="number" id="product-price" name="product-price" required>

                    <button type="submit">Add Product</button>
                </form>

                    <!-- List of Products -->
                    <div id="product-list">
                    <h3>Product List</h3>
                    <ul id="products"></ul>

                <!-- Add menu editing features, options to add/remove items -->

                </div>
            </div>
        <!-- Main content area ends here -->
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

// DSAHBOARD

// yearly orders graph
const yearlyCtx = document.getElementById('yearlyOrdersGraph').getContext('2d');
const yearlyOrdersGraph = new Chart(yearlyCtx, {
    type: 'line', // Line graph
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], // Months of the year
        datasets: [{
            label: 'Orders This Year',
            data: [120, 200, 150, 300, 400, 500, 600, 700, 800, 950, 1100, 1200], // Example data for orders each month
            borderColor: 'rgb(75, 192, 192)', // Line color
            backgroundColor: 'rgba(75, 192, 192, 0.2)', // Fill color under the line
            fill: true,
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// monthly orders graph
const monthlyCtx = document.getElementById('monthlyOrdersGraph').getContext('2d');
const monthlyOrdersGraph = new Chart(monthlyCtx, {
    type: 'line',
    data: {
        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'], //  data for weeks
        datasets: [{
            label: 'Orders This Month',
            data: [30, 45, 60, 80], // Example for weekly orders in a month
            borderColor: 'rgb(54, 162, 235)', 
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            fill: true,
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// quarterly orders graph
const quarterlyCtx = document.getElementById('quarterlyOrdersGraph').getContext('2d');
const quarterlyOrdersGraph = new Chart(quarterlyCtx, {
    type: 'line',
    data: {
        labels: ['September', 'October', 'November', 'December'], // quarters 
        datasets: [{
            label: 'Orders This Quarter',
            data: [120, 150, 180, 220], // quarterly orders
            borderColor: 'rgb(153, 102, 255)',
            backgroundColor: 'rgba(153, 102, 255, 0.2)',
            fill: true,
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});


    // ORDERS 

                // add a new completed order to the table
                document.getElementById('completeOrderBtn').addEventListener('click', () => {

            const newOrderId = '#00' + (Math.floor(Math.random() * 1000) + 1); // Random order ID
            const newCustomer = 'New Customer';  // customer name
            const newStatus = 'Completed';       // order status
            const newDate = new Date().toISOString().split('T')[0];  // Current date

            // Create a new table row

            // Add new order data to row
            newRow.innerHTML = `
                <td>${newOrderId}</td>
                <td>${newCustomer}</td>
                <td>${newStatus}</td>
                <td>${newDate}</td>
            `;

            // adds new value to currrent sequence
            document.querySelector('#orderHistoryTable tbody').appendChild(newRow);
        });


        // change content based on button click
        const buttons = document.querySelectorAll('.nav-button');
        const sections = document.querySelectorAll('.content-section');

        
        buttons.forEach(button => {
            button.addEventListener('click', (e) => {
                // Hide all sections
                sections.forEach(section => section.style.display = 'none');
                
                // Get the content to show based on button data-content
                const contentId = e.target.getAttribute('data-content');
                const contentToShow = document.getElementById(contentId);
                
                // Show the selected content
                if (contentToShow) {
                    contentToShow.style.display = 'block';
                }
                    });
                });

        // Set default content (Dashboard) to display on load
        document.getElementById('dashboard').style.display = 'block';


        // categories
const existingCategories = ['Beverages', 'Pastries', 'Snacks', 'Entrees'];

// load categories into the dropdown
function loadCategories() {
    const categorySelect = document.getElementById('product-category');
    existingCategories.forEach(category => {
        const option = document.createElement('option');
        option.value = category;
        option.textContent = category;
        categorySelect.appendChild(option);
    });
}


// Add event listener to handle product form submission
document.getElementById('add-product-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const productName = document.getElementById('product-name').value;
    const productCategory = document.getElementById('product-category').value;
    const productPrice = document.getElementById('product-price').value;

    // Validate form input
    if (!productName || !productCategory || !productPrice) {
        alert('Please fill out all fields');
        return;
    }

    // Add product to the list
    const productList = document.getElementById('products');
    const listItem = document.createElement('li');
    listItem.textContent = `${productName} - ${productCategory} - $${productPrice}`;
    productList.appendChild(listItem);

    // Reset form fields
    document.getElementById('add-product-form').reset();
});

// Load categories on page load
window.onload = loadCategories;


const fetchDashboardData = () => {
    // data
    const data = {
        totalOrders: 120,  
        totalEarnings: 5400,  
        totalTickets: 15,   
        totalRefunds: 3    
    };

    document.getElementById('totalOrders').textContent = data.totalOrders;
    document.getElementById('totalEarnings').textContent = data.totalEarnings;
    document.getElementById('totalTickets').textContent = data.totalTickets;
    document.getElementById('totalRefunds').textContent = data.totalRefunds;
};

// function to update statistics when the page loads
window.onload = fetchDashboardData;


document.getElementById('completeOrderBtn').addEventListener('click', function() {
    const orderId = prompt("Enter the Order ID to complete:");
    if (orderId) {
        const rows = document.querySelectorAll('#orderHistoryTable tbody tr');
        rows.forEach(row => {
            const orderIdCell = row.querySelector('td:first-child');
            if (orderIdCell.textContent === orderId) {
                row.querySelector('td:nth-child(3)').textContent = 'Completed'; 
                alert('Order ' + orderId + ' has been completed!');
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const completeOrderBtn = document.getElementById('completeOrderBtn');
    const rows = document.querySelectorAll('#orderHistoryTable tbody tr');

    // Disable buttons for completed orders on page load
    rows.forEach(row => {
        const statusCell = row.querySelector('td:nth-child(6)'); // Assuming the status is in the 6th column
        const actionCell = row.querySelector('td:nth-last-child(1)'); // Assuming the action is in the last column

        if (statusCell.textContent.trim() === 'Completed') {
            const button = actionCell.querySelector('button');
            if (button) {
                button.classList.add('disabled-button');
                button.disabled = true;
            }
        }
    });

    // Add event listener to the complete order button
    completeOrderBtn.addEventListener('click', function() {
        const orderId = prompt("Enter the Order ID to complete:");
        if (orderId) {
            rows.forEach(row => {
                const orderIdCell = row.querySelector('td:first-child');
                if (orderIdCell.textContent === orderId) {
                    const statusCell = row.querySelector('td:nth-child(6)');
                    statusCell.textContent = 'Completed';

                    const button = row.querySelector('td:nth-last-child(1) button');
                    if (button) {
                        button.classList.add('disabled-button');
                        button.disabled = true;
                    }

                    alert('Order ' + orderId + ' has been completed!');
                }
            });
        }
    });
});

    </script>

    <script type="text/javascript">
        // document.addEventListener('DOMContentLoaded', function() {
        //     document.getElementById('user-name').addEventListener('click', function() {
        //         var logoutButton = document.getElementById('logout-button');
        //         if (logoutButton.style.display === 'none') {
        //             logoutButton.style.display = 'block';
        //         } else {
        //             logoutButton.style.display = 'none';
        //         }
        //     });
        // });

        function logout() {
            if (confirm('Are you sure you want to log out?')) {
                window.location.href = 'Services/User/LogoutService.php';
            }
        }
    </script>
    <script>
        document.querySelectorAll('.complete-order-btn').forEach(button => {
            button.addEventListener('click', function() {
                const orderId = this.getAttribute('data-id');
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'Admin.php';
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'orderId';
                input.value = orderId;
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            });
        });

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
    </script>
    <script src="js/jquery-3.7.1.min.js"></script>

</body>
</html>
