<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['UserRole'] !== 'user') {
    header('Location: homepage.php');
    exit();
}

require_once __DIR__ . '/function/GenerateRandomStringID.php';
require_once __DIR__ . '/Services/DbConnector.php';

$userId = $_SESSION['id'];

$getOrderSql = "SELECT oi.quantity, m.price, o.OrderID 
                FROM order_item oi 
                JOIN menu m ON oi.ItemID = m.ItemID 
                JOIN orders o ON oi.OrderID = o.OrderID 
                WHERE o.UserID = ? AND o.order_status = 'cart'";
$getOrderStmt = $conn->prepare($getOrderSql);
$getOrderStmt->bind_param("i", $userId);
$getOrderStmt->execute();
$getOrderResult = $getOrderStmt->get_result();

$totalAmount = 0;
$orderId = null;
while ($orderRow = $getOrderResult->fetch_assoc()) {
    $totalAmount += $orderRow['quantity'] * $orderRow['price'];
    $orderId = $orderRow['OrderID'];
}
$getOrderStmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['orderOption']) || !in_array($_POST['orderOption'], ['pickup', 'delivery'])) {
        $_SESSION['order_error'] = 'Please select a valid order option.';
        header('Location: CartTab.php');
        exit();
    }

    $orderOption = $_POST['orderOption'];

    if ($orderOption === 'pickup') {
        $updateOrderSql = "UPDATE orders SET order_status = 'Pending', DeliveryID = NULL, pickup = 1, total_amount = ? WHERE OrderID = ?";
        $updateOrderStmt = $conn->prepare($updateOrderSql);
        $updateOrderStmt->bind_param("di", $totalAmount, $orderId);
        $updateOrderStmt->execute();
        $updateOrderStmt->close();
    }

    $_SESSION['orderOption'] = $orderOption;
    $_SESSION['orderId'] = $orderId;

    header('Location: OrderConfirmation.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Order Option</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="ChooseOptionOrder.css">
</head>
<body>
<a href="homepage.php">
    <img src="System Pictures/BSIT-2F_Logo_real-removebg-preview.png" alt="Logo" class="logo">
</a>
<!-- Customer Service header -->
<div class="header-text">
Choose your option
</div>
<a href="UserProfile.php"> 
    <img src="Photos/profile-icon.svg" alt="Profile" class="profile-icon">
</a>
<div class="new-bg-container mx-auto container-width">
    <div class="row">
        <div class="container mt-5">
            <h2>Choose Your Order Option</h2>
            <!-- Display error message if any -->
            <?php if (isset($_SESSION['order_error'])): ?>
                <div class="alert alert-danger">
                    <?php 
                        echo htmlspecialchars($_SESSION['order_error']); 
                        unset($_SESSION['order_error']);
                    ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="ChooseOptionOrder.php">
                <div class="form-group">
                    <label for="orderOption">Select an option:</label>
                    <select class="form-control" id="orderOption" name="orderOption" required>
                        <option value="">--Select an Option--</option>
                        <option value="pickup" onclick="showPickupModal()">Pickup</option>
                        <option value="delivery">Delivery</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Proceed</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Pickup Confirmation -->
<div class="modal fade" id="pickupModal" tabindex="-1" aria-labelledby="pickupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pickupModalLabel">Confirm Pickup</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Total Price: ₱<span id="totalPrice"><?php echo number_format($totalAmount, 2); ?></span></p>
                <p>Do you want to proceed with pickup?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelPickupBtn">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmPickupBtn">Confirm</button>
            </div>
        </div>
    </div>
</div>

<script src="js/jquery-3.7.1.min.js"></script>
<script src="js/choose-option-order.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var totalPriceElement = document.getElementById('totalPrice');
        if (totalPriceElement) {
            var totalPrice = parseFloat(totalPriceElement.innerText.replace(/[^0-9.-]+/g,""));
            document.getElementById('totalPrice').innerText = totalPrice.toFixed(2);
        }

        document.getElementById('orderOption').addEventListener('change', function(event) {
            if (event.target.value === 'pickup') {
                var pickupModal = new bootstrap.Modal(document.getElementById('pickupModal'));
                pickupModal.show();
            }
        });

        document.getElementById('confirmPickupBtn').addEventListener('click', function() {
            $.ajax({
                type: "POST",
                url: 'ChooseOptionOrder.php',
                data: { orderOption: 'pickup' },
                success: function(response) {
                    window.location.href = 'OrderConfirmation.php';
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    alert('An unexpected error occurred. Please try again.');
                }
            });
        });

        $('#pickupModal').on('hidden.bs.modal', function () {
            $('#orderOption').prop('disabled', false);
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        });

        $('#pickupModal').on('hide.bs.modal', function () {
            $('#orderOption').prop('disabled', false);
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        });

        document.getElementById('cancelPickupBtn').addEventListener('click', function() {
            $('#orderOption').prop('disabled', false);
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        });
    });

    function showPickupModal() {
        var myModal = new bootstrap.Modal(document.getElementById('pickupModal'), {
            keyboard: false
        });
        myModal.show();
    }
</script>
</body>
</html>
