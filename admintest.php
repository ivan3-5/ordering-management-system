<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="Admin.css">
    <style>
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

/* Order History */
.order-history {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

.order-history table {
    width: 100%;
    border-collapse: collapse;
}

.order-history th, .order-history td {
    padding: 10px;
    text-align: left;
}

.order-history th {
    background-color: #C6A988;
    color: white;
}

.order-history tr:nth-child(even) {
    background-color: #f9f9f9;
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
                <div class="graph-section">
                    <h3>Orders Overview</h3>
                    <canvas id="ordersGraph" width="400" height="200"></canvas>
                </div>
                <div class="order-history">
                    <h3>Order History</h3>
                    <table>
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
                <!-- Add a contact form or ticket system as needed -->
            </div>

            <!-- Delivery Section -->
            <div id="delivery" class="content-section">
                <h2>Delivery</h2>
                <p>Manage delivery status and orders here.</p>
                <!-- Add delivery tracking features or order status updates -->
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
        // Chart.js code for orders graph
        const ctx = document.getElementById('ordersGraph').getContext('2d');
        const ordersGraph = new Chart(ctx, {
            type: 'line', // Change to bar, radar, etc. if needed
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June'], // Example months
                datasets: [{
                    label: 'Orders',
                    data: [12, 19, 3, 5, 2, 3], // Example data
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
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


                // JavaScript to dynamically add a new completed order to the table
                document.getElementById('completeOrderBtn').addEventListener('click', () => {
            // Simulating new order data
            const newOrderId = '#00' + (Math.floor(Math.random() * 1000) + 1); // Random order ID
            const newCustomer = 'New Customer';  // Example customer name
            const newStatus = 'Completed';       // New order status
            const newDate = new Date().toISOString().split('T')[0];  // Current date in YYYY-MM-DD format

            // Create a new table row
            const newRow = document.createElement('tr');

            // Add new order data to the row
            newRow.innerHTML = `
                <td>${newOrderId}</td>
                <td>${newCustomer}</td>
                <td>${newStatus}</td>
                <td>${newDate}</td>
            `;

            // Append the new row to the table
            document.querySelector('#orderHistoryTable tbody').appendChild(newRow);
        });


        // JavaScript to change content based on button clicked
        const buttons = document.querySelectorAll('.nav-button');
        const sections = document.querySelectorAll('.content-section');

        // Initially hide all sections
        sections.forEach(section => section.style.display = 'none');

        // Set default content (Dashboard) to display on load
        document.getElementById('dashboard').style.display = 'block';

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


        // Sample existing categories
const existingCategories = ['Beverages', 'Pastries', 'Snacks', 'Entrees'];

// Function to load categories into the dropdown
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


    </script>
</body>
</html>