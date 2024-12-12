<?php
require_once 'DbConnector.php';

$action = $_POST['action'];
$type = $_POST['type'];
$id = $_POST['id'];

if ($type === 'category') {
    if ($action === 'softDelete') {
        softDeleteCategory($id);
    } elseif ($action === 'hardDelete') {
        hardDeleteCategory($id);
    }
} elseif ($type === 'item') {
    if ($action === 'softDelete') {
        softDeleteItem($id);
    } elseif ($action === 'hardDelete') {
        hardDeleteItem($id);
    }
}

function softDeleteCategory($categoryId) {
    global $conn;

    // Check if there are any items connected to the category
    $sql = "SELECT COUNT(*) as itemCount FROM menu WHERE CategoryID = ? AND deleted = FALSE";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['itemCount'] > 0) {
        echo json_encode(array("status" => "error", "message" => "Cannot delete category with items."));
    } else {
        $sql = "UPDATE category SET deleted = TRUE WHERE CategoryID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $categoryId);

        if ($stmt->execute()) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "error"));
        }
    }
}

function hardDeleteCategory($categoryId) {
    global $conn;

    // Check if there are any items connected to the category
    $sql = "SELECT COUNT(*) as itemCount FROM menu WHERE CategoryID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['itemCount'] > 0) {
        echo json_encode(array("status" => "error", "message" => "Cannot delete category with items."));
    } else {
        $sql = "DELETE FROM category WHERE CategoryID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $categoryId);

        if ($stmt->execute()) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "error"));
        }
    }
}

function softDeleteItem($itemId) {
    global $conn;

    $sql = "UPDATE menu SET deleted = TRUE WHERE ItemID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $itemId);

    if ($stmt->execute()) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "error"));
    }
}

function hardDeleteItem($itemId) {
    global $conn;

    $sql = "DELETE FROM menu WHERE ItemID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $itemId);

    if ($stmt->execute()) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "error"));
    }
}
?>