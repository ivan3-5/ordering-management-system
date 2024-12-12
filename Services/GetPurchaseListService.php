<?php
include 'DbConnector.php';

$list = array();

$sql = "SELECT * FROM orders WHERE Active = 0 AND UserId = " . $_SESSION['id'];
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_push($list, $row);
    }
}

echo json_encode($list);
?>