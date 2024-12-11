<?php
  include 'DbConnector.php';
  
  $list = array();

  $sql = "SELECT * FROM orders WHERE Active = 1 AND UserId = " . $session_id;
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      array_push($list, $row);
    }
  }
  
  echo json_encode($list);
?>