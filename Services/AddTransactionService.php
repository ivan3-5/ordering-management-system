<?php
  include 'DbConnector.php';
  include 'CommonQueryService.php';
  
  $orderId = $_POST["orderId"];
  $transactionType = $_POST["transactionType"];
  
  if ($orderId != null && !empty($orderId)) {
    $deliveryId = uniqid();
    $deliveryAddress = GetActiveDeliveryAddress($conn, $session_id);
    $deliveryAddressId = $deliveryAddress != null ? $deliveryAddress['Id'] : 0;

    $sql = "INSERT INTO transactions (OrderId, TransactionType, DeliveryAddressId, UserId, DeliveryId, TransactionStatus, Active, DateCreated, DateUpdated) " 
      . "VALUES ('" . $orderId . "', '" . $transactionType . "', " . $deliveryAddressId . ", " . $session_id . ", '" . $deliveryId . "', " . "'?', " 
      . 1 . ", " . "'" . GetCurrentDate() . "', '" . GetCurrentDate()  . "')";
      
    if ($conn->query($sql) === TRUE) {
      echo json_encode(array("status" => "success"));
      return;
    } else {
      echo json_encode(array("status" => "error"));
    }
  }

  echo json_encode(array("status" => "existing_transaction"));
?>