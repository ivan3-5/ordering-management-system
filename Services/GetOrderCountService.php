<?php
  include 'DbConnector.php';
  
  $sql = "SELECT COUNT(*) AS OrderCount FROM orders WHERE Active = 1 AND UserId = " . $session_id;
  $result = $conn->query($sql);
  
  echo json_encode($result->fetch_assoc()['OrderCount']);
  
?>