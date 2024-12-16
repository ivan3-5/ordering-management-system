<?php
  include 'DbConnector.php';
  include 'CommonQueryService.php';
  
  session_start();
  $userId = $_SESSION['id'];

  $orderId = $_POST["orderId"];
  $transactionMethod = $_POST["transactionMethod"];
  $amountPaid = $_POST["amountPaid"];

  $transactionId = uniqid();

  $sql_transaction = "INSERT INTO transactions (TransactionID, transaction_status, transaction_date, transaction_method, amount_paid)
                      VALUES (?, ?, NOW(), ?, ?)";

  $stmt_transaction = $conn->prepare($sql_transaction);
  $transactionStatus = 'Completed';

  $stmt_transaction->bind_param("sssd", $transactionId, $transactionStatus, $transactionMethod, $amountPaid);

  if ($stmt_transaction->execute()) {
      $sql_update_order = "UPDATE orders SET TransactionID = ? WHERE OrderID = ?";

      $stmt_update_order = $conn->prepare($sql_update_order);
      $stmt_update_order->bind_param("ss", $transactionId, $orderId);
      $stmt_update_order->execute();

      echo json_encode(array("status" => "success"));
  } else {
      echo json_encode(array("status" => "error in transactions"));
  }
?>