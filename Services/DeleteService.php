<?php
require_once 'DbConnector.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $type = $_POST['type'];
    $id = $_POST['id'];

    if ($type === 'category') {
        if ($action === 'softDelete') {
            $sql = "UPDATE category SET deleted = TRUE WHERE CategoryID = ?";
        } elseif ($action === 'hardDelete') {
            $sql = "DELETE FROM category WHERE CategoryID = ?";
        }
    } elseif ($type === 'item') {
        if ($action === 'softDelete') {
            $sql = "UPDATE menu SET deleted = TRUE WHERE ItemID = ?";
        } elseif ($action === 'hardDelete') {
            $sql = "DELETE FROM menu WHERE ItemID = ?";
        }
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    if ($stmt->execute()) {
        $response['status'] = 'success';
    } else {
        $response['status'] = 'error';
    }
    $stmt->close();
}

echo json_encode($response);
?>