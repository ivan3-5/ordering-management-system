<?php
include 'DbConnector.php';
session_start();
$userId = $_SESSION['id'];

$sql = "SELECT o.OrderID, o.order_date, o.order_status, o.total_amount, t.transaction_method, t.transaction_status
        FROM orders o
        LEFT JOIN transactions t ON o.TransactionID = t.TransactionID
        WHERE o.UserID = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="UserProfile.css">
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar bg-brown d-flex flex-column align-items-center py-4">
            <div class="nav-icon mb-4">
                <a href="Homepage.php">
                    <i class="fas fa-home fa-2x"></i>
                </a>
            </div>

            <div class="nav-icon mb-4">
                <a href="OrderHistory.php">
                    <i class="fa-solid fa-clock-rotate-left fa-2x"></i>
                </a>
            </div>

            <div class="nav-icon mb-4">
                <a href="CustomerService.php">
                    <i class="fas fa-comment fa-2x"></i>
                </a>
            </div>

            <div class="nav-icon mb-4">
                <i class="fas fa-sign-out-alt fa-2x" onclick="logout()"></i>
            </div>
        </div>

        <!-- Content -->
        <div class="content flex-grow-1 bg-light-brown d-flex justify-content-center align-items-center p-5">
            <!-- Order History -->
            <div class="order-history-section bg-brown text-center p-4 rounded">
                <h3 class="text-white mb-4">Order History</h3>
                <table id="orderList" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Delivery Status</th>
                            <th>Transaction Status</th>
                            <th>Payment Method</th>
                            <th>Order Date</th>
                            <th>Order Status</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($order = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<th>" . $order['OrderID'] . "</th>";
                            echo "<th>Pending</th>"; 
                            echo "<th>" . $order['transaction_status'] . "</th>";
                            echo "<th>" . $order['transaction_method'] . "</th>";
                            echo "<th>" . $order['order_date'] . "</th>";
                            echo "<th>" . $order['order_status'] . "</th>";
                            echo "<th>" . $order['total_amount'] . "</th>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                    <tbody>
                        <!-- Display Orders by JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/order-list.service.js"></script>
</body>
</html>
