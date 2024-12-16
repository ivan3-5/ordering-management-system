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

require_once __DIR__ . '/Services/DbConnector.php';

// Fetch tickets sorted by date_submitted
$sql = "SELECT cs.TicketID, cs.UserID, cs.subject, cs.description, cs.date_submitted, cs.ticket_status, u.FirstName, u.LastName
        FROM customer_service cs
        JOIN users u ON cs.UserID = u.Id
        ORDER BY cs.date_submitted DESC";
$result = $conn->query($sql);
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
            <button class="nav-button logout-button" id="logout-button" onclick="logout()">LOGOUT</button>
        </aside>

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
                        <p id="totalEarnings">₱0</p>
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
            <div id="orders" class="content-section" style="display: none;">
                <h2>Orders</h2>
                <button id="completeOrderBtn">Complete Order</button>
                <table id="orderHistoryTable">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>User ID</th>
                            <th>Delivery ID</th>
                            <th>Transaction ID</th>
                            <th>Pickup</th>
                            <th>Order Date</th>
                            <th>Order Status</th>
                            <th>Total Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $orderService->getOrders(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Customer Service Section -->
            <div id="customer-service" class="content-section" style="display: none;">
                <h2>Customer Service</h2>
                <p>Manage customer inquiries, feedback, and support requests here.</p>
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
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['TicketID']); ?></td>
                                    <td><?php echo htmlspecialchars($row['FirstName'] . ' ' . $row['LastName']); ?></td>
                                    <td><?php echo htmlspecialchars($row['subject']); ?></td>
                                    <td><?php echo htmlspecialchars($row['ticket_status']); ?></td>
                                    <td>
                                        <button class="btn btn-primary" onclick="updateTicketStatus('<?php echo $row['TicketID']; ?>', 'open')">Open</button>
                                        <button class="btn btn-warning" onclick="updateTicketStatus('<?php echo $row['TicketID']; ?>', 'cancelled')">Cancelled</button>
                                        <button class="btn btn-success" onclick="updateTicketStatus('<?php echo $row['TicketID']; ?>', 'closed')">Closed</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Delivery Section -->
            <div id="delivery" class="content-section" style="display: none;">
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
            <div id="menu-list" class="content-section" style="display: none;">
                <h2>Menu List</h2>
                <p>Manage and update the menu items here.</p>
                <form id="add-category-form">
                    <label for="category-name">Category Name:</label>
                    <input type="text" id="category-name" name="category-name" required>
                    <label for="category-description">Description:</label>
                    <input type="text" id="category-description" name="category-description" required>
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
                    <img id="add-item-image-preview" src="#" alt="Image Preview" style="display: none; width: 100px; height: 100px;">
                    <label for="item-description">Description:</label>
                    <input type="text" id="item-description" name="item-description" required>
                    <label for="item-price">Price (₱):</label>
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
                            <th>Image</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Items will be dynamically added here -->
                    </tbody>
                </table>
            </div>

            <!-- Update Item Modal -->
            <div id="updateItemModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Update Item</h2>
                    <form id="update-item-form" enctype="multipart/form-data">
                        <input type="hidden" id="update-item-id">
                        <label for="update-item-name">Item Name:</label>
                        <input type="text" id="update-item-name" name="item-name" required>
                        <label for="update-item-category">Category:</label>
                        <select id="update-item-category" name="category" required>
                            <option value="" disabled selected>Select a Category</option>
                            <!-- Categories will be dynamically added here -->
                        </select>
                        <label for="update-item-description">Description:</label>
                        <input type="text" id="update-item-description" name="item-description" required>
                        <label for="update-item-price">Price (₱):</label>
                        <input type="number" id="update-item-price" name="item-price" required>
                        <label for="update-item-image">Image:</label>
                        <input type="file" id="update-item-image" name="item-image">
                        <img id="update-item-image-preview" src="#" alt="Image Preview" style="display: none; width: 100px; height: 100px;">
                        <button type="submit">Update Item</button>
                    </form>
                </div>
            </div>

            <!-- Update Category Modal -->
            <div id="updateCategoryModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Update Category</h2>
                    <form id="update-category-form">
                        <input type="hidden" id="update-category-id">
                        <label for="update-category-name">Category Name:</label>
                        <input type="text" id="update-category-name" name="category-name" required>
                        <label for="update-category-description">Description:</label>
                        <input type="text" id="update-category-description" name="category-description" required></input>
                        <button type="submit">Update Category</button>
                    </form>
                </div>
            </div>
        </div>
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

        function updateTicketStatus(ticketID, status) {
            $.ajax({
                type: "POST",
                url: 'Services/UpdateTicketStatusService.php',
                data: { ticketID: ticketID, status: status },
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.status === "success") {
                        alert('Ticket status updated successfully!');
                        location.reload();
                    } else {
                        alert('Failed to update ticket status: ' + data.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    alert('An unexpected error occurred. Please try again.');
                }
            });
        }
    </script>
</body>
</html>
