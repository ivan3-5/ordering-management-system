<?php
require_once 'DbConnector.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userId = $_SESSION['id'];

$response = array();

$sql = "SELECT TicketID, subject, date_submitted, ticket_status FROM customer_service WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $response[] = $row;
}

echo json_encode($response);
?>