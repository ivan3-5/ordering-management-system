<?php
  include 'DbConnector.php';

  $orderId = $_POST['orderId'];

  $sql = "DELETE FROM orders WHERE id = " . $orderId . " LIMIT 1";
  if ($conn->query($sql) === TRUE) {
    // echo "Record deleted successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  
  echo $orderId;
?>