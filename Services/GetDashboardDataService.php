<?php
require_once 'DbConnector.php';

$response = array();


$sql = "SELECT COUNT(*) as totalOrders FROM orders WHERE MONTH(DateCreated) = MONTH(CURRENT_DATE()) AND YEAR(DateCreated) = YEAR(CURRENT_DATE())";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$response['totalOrders'] = $row['totalOrders'];


$sql = "SELECT SUM(TotalPrice) as totalEarnings FROM orders WHERE MONTH(DateCreated) = MONTH(CURRENT_DATE()) AND YEAR(DateCreated) = YEAR(CURRENT_DATE())";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$response['totalEarnings'] = $row['totalEarnings'];


$sql = "SELECT COUNT(*) as totalTickets FROM tickets WHERE MONTH(DateCreated) = MONTH(CURRENT_DATE()) AND YEAR(DateCreated) = YEAR(CURRENT_DATE())";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$response['totalTickets'] = $row['totalTickets'];


$sql = "SELECT COUNT(*) as totalRefunds FROM refunds WHERE MONTH(DateCreated) = MONTH(CURRENT_DATE()) AND YEAR(DateCreated) = YEAR(CURRENT_DATE())";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$response['totalRefunds'] = $row['totalRefunds'];


$sql = "SELECT MONTH(DateCreated) as month, COUNT(*) as orders FROM orders WHERE YEAR(DateCreated) = YEAR(CURRENT_DATE()) GROUP BY MONTH(DateCreated)";
$result = $conn->query($sql);
$yearlyOrders = array('labels' => [], 'values' => []);
while ($row = $result->fetch_assoc()) {
    $yearlyOrders['labels'][] = date('F', mktime(0, 0, 0, $row['month'], 10));
    $yearlyOrders['values'][] = $row['orders'];
}
$response['yearlyOrders'] = $yearlyOrders;


$sql = "SELECT WEEK(DateCreated) as week, COUNT(*) as orders FROM orders WHERE MONTH(DateCreated) = MONTH(CURRENT_DATE()) AND YEAR(DateCreated) = YEAR(CURRENT_DATE()) GROUP BY WEEK(DateCreated)";
$result = $conn->query($sql);
$monthlyOrders = array('labels' => [], 'values' => []);
while ($row = $result->fetch_assoc()) {
    $monthlyOrders['labels'][] = 'Week ' . $row['week'];
    $monthlyOrders['values'][] = $row['orders'];
}
$response['monthlyOrders'] = $monthlyOrders;


$sql = "SELECT MONTH(DateCreated) as month, COUNT(*) as orders FROM orders WHERE QUARTER(DateCreated) = QUARTER(CURRENT_DATE()) AND YEAR(DateCreated) = YEAR(CURRENT_DATE()) GROUP BY MONTH(DateCreated)";
$result = $conn->query($sql);
$quarterlyOrders = array('labels' => [], 'values' => []);
while ($row = $result->fetch_assoc()) {
    $quarterlyOrders['labels'][] = date('F', mktime(0, 0, 0, $row['month'], 10));
    $quarterlyOrders['values'][] = $row['orders'];
}
$response['quarterlyOrders'] = $quarterlyOrders;

$response['status'] = 'success';
echo json_encode($response);
?>