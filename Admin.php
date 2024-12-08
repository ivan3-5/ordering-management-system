<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Navbar Styling */
    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 80px;
        padding: 0 20px;
        background-color: #C6A988; /* Dark background */
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 1000; /* Ensure the navbar stays on top */
    }

    .logo img {
        height: 50px; /* Adjust the logo size */
    }

    /* Admin Box Styling */
    .admin-sign {
        background-color: #9D673A;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: bold;
        text-align: center;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
    }

/* Sidebar Styling */
.sidebar {
    padding: 5px;
    position: fixed;
    top: 80px; /* Offset from the header */
    left: 0;
    width: 250px; /* Width of the sidebar */
    height: 100%; /* Full height */
    background-color: #C6A988; /* Dark background */
    color: white;
    padding-top: 20px;
    box-shadow: 2px 0 6px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    gap: 15px; /* Add gap between buttons */
    z-index: 999; /* Ensure sidebar stays under the navbar */
}

/* Sidebar Button Styling */
.nav-button {
    font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
    border: 1px black solid;
    background-color: #C6A988;
    color: white;
    padding: 15px;
    font-size: 16px;
    cursor: pointer;
    width: 100%;
    text-align: center;  /* Center the text */
    transition: background-color 0.3s;
    border-radius: 5px;
    display: flex; /* Use flexbox for better centering */
    justify-content: center; /* Horizontally center */
    align-items: center; /* Vertically center */
}

.nav-button:hover {
    background-color: #9D673A;
}

/* Sidebar Logout Button Styling */
.logout {
    border: 1px black solid;
    background-color: #C6A988;
    font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
    color: white;
    padding: 15px;
    font-size: 16px;
    cursor: pointer;
    width: 100%;
    text-align: center;  /* Center the text */
    transition: background-color 0.3s;
    border-radius: 5px;
    display: flex; /* Use flexbox for better centering */
    justify-content: center; /* Horizontally center */
    align-items: center; /* Vertically center */
}

.logout:hover {
    background-color: #c9302c;
}

/* Adjust content area to prevent overlap */
.container {
    margin-left: 250px; /* Adjust space for the sidebar */
    margin-top: 80px; /* Space for the header */
    padding: 20px;
}


        /* Main Content Area */
        .container {
            margin-left: 250px; /* Space for the sidebar */
            margin-top: 60px; /* Space for the header */
            padding: 20px;
        }

        /* Dashboard */
.dashboard {
    display: flex;
    flex-direction: column;
    gap: 30px;
    padding: 20px;
}

/* Graph Section */
.graph-section {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

.graph-section h2 {
    font-size: 24px;
    margin-bottom: 20px;
}

/* Orders Section */
#orders {
    background-color: #f9f9f9;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

#orders h2 {
    font-size: 28px;
    color: #333;
    margin-bottom: 20px;
}

/* Complete Order Button */
#completeOrderBtn {
    background-color: #C6A988;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    margin-bottom: 20px;
    transition: background-color 0.3s ease;
}

#completeOrderBtn:hover {
    background-color: #9D673A;
}

/* Table Styling */
#orderHistoryTable {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    border-radius: 10px;
    overflow: hidden;
}

#orderHistoryTable th, #orderHistoryTable td {
    padding: 12px 15px;
    text-align: left;
}

#orderHistoryTable th {
    background-color: #C6A988;
    color: white;
    font-size: 16px;
}

#orderHistoryTable td {
    font-size: 14px;
}

#orderHistoryTable tr:nth-child(even) {
    background-color: #f1f1f1;
}

#orderHistoryTable tr:hover {
    background-color: #f1f1f1;
}

#orderHistoryTable tbody tr:last-child {
    border-bottom: 2px solid #C6A988;
}

/* Initially hide all content sections */
.content-section {
    display: none;
}

/* Show the dashboard section by default */
#dashboard {
    display: block;
}

/* Basic styling for the form and product list */
#menu-list {
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
}

form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

form label {
    font-weight: bold;
}

form input, form select {
    padding: 8px;
    font-size: 14px;
}

button {
    padding: 10px 15px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

#product-list {
    margin-top: 30px;
}

#product-list ul {
    list-style-type: none;
    padding: 0;
}

#product-list li {
    margin: 10px 0;
}

h2 {
        color: #333;
    }

    .ticket-form {
        margin-top: 20px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    .form-control {
        width: 100%;
        padding: 8px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .form-control:focus {
        border-color: #007bff;
        outline: none;
    }

    .btn {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    .mt-5 {
        margin-top: 40px;
    }

    .table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    .table th, .table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .table th {
        background-color: #f8f8f8;
        color: #333;
    }

    .table-striped tbody tr:nth-child(odd) {
        background-color: #f9f9f9;
    }

    .table-striped tbody tr:hover {
        background-color: #f1f1f1;
    }

    .table .btn {
        background-color: #28a745;
        color: white;
    }

    .table .btn:hover {
        background-color: #218838;
    }


    /* Customer Service Section */
#customer-service {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-top: 20px;
}

/* Heading */
#customer-service h2 {
    font-size: 28px;
    color: #333;
    margin-bottom: 20px;
}

/* Paragraph */
#customer-service p {
    font-size: 16px;
    color: #555;
    line-height: 1.6;
    margin-bottom: 20px;
}

/* Ticket Form */
#ticket-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* Form Group Styling */
.form-group {
    margin-bottom: 15px;
}

.form-group label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

.form-control {
    width: 100%;
    padding: 8px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.form-control:focus {
    border-color: #007bff;
    outline: none;
}

/* Submit Button Styling */
.btn {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #0056b3;
}

/* Submitted Tickets Section */
#submitted-tickets {
    margin-top: 30px;
}

#submitted-tickets h3 {
    font-size: 24px;
    color: #333;
    margin-bottom: 15px;
}

/* Table Styling */
#submitted-tickets .table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
    background-color: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

#submitted-tickets th, #submitted-tickets td {
    padding: 12px 15px;
    text-align: left;
}

#submitted-tickets th {
    background-color: #C6A988;
    color: white;
    font-size: 16px;
}

#submitted-tickets td {
    font-size: 14px;
}

#submitted-tickets tr:nth-child(even) {
    background-color: #f1f1f1;
}

#submitted-tickets tr:hover {
    background-color: #f1f1f1;
}

#submitted-tickets tbody tr:last-child {
    border-bottom: 2px solid #C6A988;
}

/* Customer Service Form and Ticket Table Layout */
#customer-service .form-group, #submitted-tickets {
    margin-bottom: 20px;
}



/* Delivery Section */
#delivery {
    background-color: #f9f9f9;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

#delivery h2 {
    font-size: 28px;
    color: #333;
    margin-bottom: 20px;
}

/* Delivery Status Paragraph */
#delivery p {
    font-size: 16px;
    color: #555;
    margin-bottom: 20px;
    line-height: 1.6;
}

/* Add Delivery Form or Status */
.delivery-status {
    display: flex;
    flex-direction: column;
    gap: 20px; /* Slightly increased gap for better spacing */
}

/* Inputs and Selects Styling */
.delivery-status input,
.delivery-status select {
    padding: 12px; /* Increased padding for better clickability */
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 100%;
    box-sizing: border-box;
    transition: border-color 0.3s ease; /* Smooth border color transition */
}

/* Hover effect for input and select */
.delivery-status input:hover,
.delivery-status select:hover {
    border-color: #9D673A; /* Subtle change in border color on hover */
}

/* Focus effect for input and select */
.delivery-status input:focus,
.delivery-status select:focus {
    border-color: #C6A988; /* Highlight border color when focused */
    outline: none; /* Remove default focus outline */
}

/* Submit Button Styling */
.delivery-status button {
    background-color: #C6A988;
    color: white;
    border: none;
    padding: 14px 22px; /* Increased padding for better button size */
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
    width: 100%;
}

/* Hover effect for button */
.delivery-status button:hover {
    background-color: #9D673A;
}

/* Active state for button */
.delivery-status button:active {
    background-color: #7a4f24; /* Darker shade when button is clicked */
}

/* Basic Styles for Dashboard */
.dashboard {
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.dashboard h2 {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
}

.graph-section {
    margin-bottom: 30px;
}

.graph-section h3 {
    font-size: 18px;
    color: #555;
}

/* Basic Styles for Dashboard */
.dashboard {
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.dashboard h2 {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
}

/* Basic Styles for Dashboard */
.dashboard {
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.dashboard h2 {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
}

/* Statistics Section */
.statistics {
    display: flex;
    justify-content: space-between;  /* Space out the boxes */
    gap: 20px;  /* Gap between each box */
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Shadow for overall statistics box */
    margin-bottom: 20px; /* Space between the stats and the graph */
}

.statistics .stat-box {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    flex: 1;  /* Make the boxes grow to fill available space */
    padding: 20px;
    text-align: center;  /* Center the text inside */
}

.statistics .stat-box h4 {
    font-size: 18px;
    color: #555;
    margin-bottom: 10px;
}

.statistics .stat-box p {
    font-size: 24px;
    font-weight: bold;
    color: #007bff;
}

/* Graph Section */
.graph-section {
    margin-top: 20px;
}

.graph-section h3 {
    font-size: 18px;
    color: #555;
    margin-bottom: 15px;
}

/* Canvas for the Graph */
#ordersGraph {
    width: 100%;  /* Makes the canvas take up 100% of the width of its container */
    height: 400px;  /* Set a fixed height for the graph */
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}


@media (max-width: 768px) {
    #ordersGraph {
        height: 300px;  
    }
}

    </style>
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
            <button class="logout">LOGOUT</button>
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
                <button id="completeOrderBtn">Complete Order</button> <!-- Button to simulate completing an order -->
                <table id="orderHistoryTable">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#001</td>
                            <td>John Doe</td>
                            <td>Completed</td>
                            <td>2024-12-05</td>
                        </tr>
                        <tr>
                            <td>#002</td>
                            <td>Jane Smith</td>
                            <td>Pending</td>
                            <td>2024-12-04</td>
                        </tr>
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
            const newRow = document.createElement('tr');

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

    </script>

</body>
</html>
