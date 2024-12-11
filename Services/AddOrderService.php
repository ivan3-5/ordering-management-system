<?php
  include 'DbConnector.php';
  include 'CommonQueryService.php';
  
  $quantity = $_POST["quantity"];
  $orderName = $_POST["orderName"];
  $totalPrice = $_POST["totalPrice"];
  $orderDescription = $_POST["orderDescription"];
  $orderImg = $_POST["orderImg"];

  $activeOrderId = GetActiveOrderId($conn, $session_id);
  if ($activeOrderId == null) {
    $activeOrderId = uniqid();
  }

  $sql = "INSERT INTO orders (OrderName, Quantity, TotalPrice, OrderDescription, OrderImg, Active, OrderId, UserId, DateCreated, DateUpdated)" 
      . "VALUES ('" . $orderName . "', " . $quantity . ", " . $totalPrice . ", '" . $orderDescription . "', '" . $orderImg . "', " 
      . 1 . ", '" . $activeOrderId . "', " . $session_id . ", '" . GetCurrentDate() . "', '" . GetCurrentDate()  . "')";
  // echo "<br/>sql:" . $sql;

  if ($conn->query($sql) === TRUE) {
    echo json_encode(array("status" => "success"));
  } else {
    echo json_encode(array("status" => "error"));
  }
?>