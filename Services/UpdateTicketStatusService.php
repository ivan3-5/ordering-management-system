<?php
session_start();
require_once __DIR__ . '/DbConnector.php';

$response = ['status' => 'error', 'message' => 'Unknown error'];

try {
    if (!isset($_SESSION['id']) || $_SESSION['UserRole'] !== 'admin') {
        throw new Exception('Unauthorized access');
    }

    $adminId = $_SESSION['id'];
    $ticketID = isset($_POST['ticketID']) ? $_POST['ticketID'] : null;
    $status = isset($_POST['status']) ? $_POST['status'] : null;

    if ($ticketID === null || $status === null) {
        throw new Exception('Invalid input');
    }

    
    $updateSql = "UPDATE customer_service SET ticket_status = ?, AdminID = ? WHERE TicketID = ?";
    $stmt = $conn->prepare($updateSql);
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }
    $stmt->bind_param("sis", $status, $adminId, $ticketID);
    if (!$stmt->execute()) {
        throw new Exception('Execute failed: ' . $stmt->error);
    }
    $stmt->close();

    $response = ['status' => 'success'];
} catch (Exception $e) {
    error_log($e->getMessage(), 3, __DIR__ . '/error_log.txt');
    $response = ['status' => 'error', 'message' => $e->getMessage()];
}

echo json_encode($response);
$conn->close();
?>