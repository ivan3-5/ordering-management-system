<?php
  include 'DbConnector.php';
  include 'CommonQueryService.php';
  
  $transactionId = $_POST["transactionId"];
  $deliveryAddressId = $_POST["deliveryAddressId"];
  $paymentMethod = $_POST["paymentMethod"];
  $transactionStatus = $_POST["transactionStatus"];
  $orderId = $_POST["orderId"];
  
  $sql = "UPDATE transactions SET DeliveryAddressId = " . $deliveryAddressId . ", PaymentMethod = '" . $paymentMethod . "', "
    . "TransactionStatus = '" . $transactionStatus . "', Active = " . 0 . ", DateUpdated = '" . GetCurrentDate()  . "'"
    . " WHERE Id = " . $transactionId;

  if ($conn->query($sql) === TRUE) {
    RemoveActiveOrders($conn, $orderId);
    echo json_encode(array("status" => "success"));
  } else {
    echo json_encode(array("status" => "error"));
  }
?>