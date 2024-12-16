<?php
include 'DbConnector.php';
include 'CommonQueryService.php';

session_start();


$transactionId = $_POST['TransactionID'];
$deliveryAddressId = $_POST['deliveryAddressId'];
$paymentMethod = $_POST['paymentMethod'];
$transactionStatus = $_POST['transactionStatus'];
$orderId = $_POST['orderId'];
$amountPaid = $_POST['amountPaid']; 


$sql_transaction = "UPDATE transactions SET 
                        transaction_status = ?, 
                        transaction_method = ?, 
                        amount_paid = ?
                    WHERE TransactionID = ?";

$stmt_transaction = $conn->prepare($sql_transaction);
$stmt_transaction->bind_param("ssds", $transactionStatus, $paymentMethod, $amountPaid, $transactionId);

if ($stmt_transaction->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt_transaction->error]);
}

$stmt_transaction->close();
$conn->close();
?>