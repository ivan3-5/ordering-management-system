<?php
  include 'DbConnector.php';
  include 'CommonQueryService.php';
  
  $address = $_POST["address"];

  $sql = "INSERT INTO delivery_address (Address, Active, UserId, DateCreated)" 
      . "VALUES ('" . $address . "', " . 1 . ", " . $session_id . ", '" . date("Y/m/d") . "')";
      
  if ($conn->query($sql) === TRUE) {
    $deliveryAddress = GetActiveDeliveryAddress($conn ,$session_id);
    echo json_encode($deliveryAddress);
  } else {
    echo json_encode(array("status" => "error"));
  }
?>