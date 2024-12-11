<?php
  include 'DbConnector.php';
  include 'CommonQueryService.php';

  $deliveryAddressId = $_POST["deliveryAddressId"];

  $deliveryAddress = null;
  
  if ($deliveryAddressId != null && !empty($deliveryAddressId) && $deliveryAddressId != 0) {
    $sql = "SELECT * FROM delivery_address WHERE Id = " . $deliveryAddressId;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $deliveryAddress = $result->fetch_assoc();
    }
  } else {
    $deliveryAddress = GetActiveDeliveryAddress($conn, $session_id);
  }
  
  if ($deliveryAddress != null) {
    echo json_encode(array("status" => "success"));
    return;
  } else {
    echo json_encode(array("status" => "not found"));
  }
?>