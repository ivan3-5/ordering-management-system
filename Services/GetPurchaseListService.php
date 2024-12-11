<?php
  include 'DbConnector.php';
  
  $list = array();

  $sql = "SELECT * FROM transactions WHERE Active = 0 AND UserId = " . $session_id;
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      array_push($list, $row);
    }
  }
  
  echo json_encode($list);
?>