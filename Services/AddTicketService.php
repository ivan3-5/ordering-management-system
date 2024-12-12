<?php
require_once 'DbConnector.php';
require_once '../function/GenerateRandomStringID.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userId = $_SESSION['id'];
$subject = $_POST['subject'];
$description = $_POST['description'];
$dateSubmitted = date('Y-m-d H:i:s');
$ticketStatus = 'open';
$ticketID = generateRandomStringID('TCK', 9);

$sql = "INSERT INTO customer_service (TicketID, UserID, subject, description, date_submitted, ticket_status) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sissss", $ticketID, $userId, $subject, $description, $dateSubmitted, $ticketStatus);

$response = array();
if ($stmt->execute()) {
    $response['status'] = 'success';
} else {
    $response['status'] = 'error';
    $response['message'] = $stmt->error;
}

echo json_encode($response);
?>