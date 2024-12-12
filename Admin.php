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
                        <p id="totalOrders">0</p>
                    </div>
                    <div class="stat-box">
                        <h4>Total Earnings This Month</h4>
                        <p id="totalEarnings">$0</p>
                    </div>
                    <div class="stat-box">
                        <h4>Total Tickets This Month</h4>
                        <p id="totalTickets">0</p>
                    </div>
                    <div class="stat-box">
                        <h4>Total Refunds This Month</h4>
                        <p id="totalRefunds">0</p>
                    </div>
                </div>
                <!-- Graph Section -->
                <div class="graph-section">
                    <h3>Yearly Orders Overview</h3>
                    <canvas id="yearlyOrdersGraph" width="400" height="200"></canvas>
                    <h3>Monthly Orders Overview</h3>
                    <canvas id="monthlyOrdersGraph" width="400" height="200"></canvas>
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
                <form id="add-category-form">
                    <label for="category-name">Category Name:</label>
                    <input type="text" id="category-name" name="category-name" required>
                    <label for="category-description">Description:</label>
                    <textarea id="category-description" name="category-description" required></textarea>
                    <button type="submit">Add Category</button>
                </form>
                <br>
                <hr>
                <br>
                <form id="add-item-form">
                    <label for="item-name">Item Name:</label>
                    <input type="text" id="item-name" name="item-name" required>
                    <label for="item-category">Category:</label>
                    <select id="item-category" name="category" required>
                        <option value="" disabled selected>Select a Category</option>
                        <!-- Categories will be dynamically added here -->
                    </select>
                    <label for="item-image">Image:</label>
                    <input type="file" id="item-image" name="item-image" required>
                    <label for="item-description">Description:</label>
                    <textarea id="item-description" name="item-description" required></textarea>
                    <label for="item-price">Price ($):</label>
                    <input type="number" id="item-price" name="item-price" required>
                    <button type="submit">Add Item</button>
                </form>
                <br>
                <hr>
                <br>
                <h3>Category List</h3>
                <table id="categoryListTable" class="responsive-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Categories will be dynamically added here -->
                    </tbody>
                </table>
                <br>
                <hr>
                <br>
                <h3>Item List</h3>
                <table id="itemListTable" class="responsive-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Item Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Category ID</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Items will be dynamically added here -->
                    </tbody>
                </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/admin-dashboard.js"></script>
    <script src="js/admin-menu-list.js"></script>
    <script src="js/admin-orders.js"></script>
    <script src="js/admin-customer-service.js"></script>
    <script src="js/admin-delivery.js"></script>
    <script src="js/admin-tabs.js"></script>
    <script type="text/javascript">
        function logout() {
            if (confirm('Are you sure you want to log out?')) {
                window.location.href = 'Services/User/LogoutService.php';
            }
        }
    </script>
</body>
</html>
