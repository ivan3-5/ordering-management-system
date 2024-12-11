<?php
    date_default_timezone_set('Asia/Manila');
    function GetActiveOrderId($conn, $session_id) {
        $sql = "SELECT OrderId FROM orders WHERE Active = 1 AND UserId = " . $session_id . " ORDER BY DateCreated DESC LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc()['OrderId'];
        }
        return null;
    }

    function GetActiveDeliveryAddress($conn, $session_id) {
        $sql = "SELECT * FROM delivery_address WHERE Active = 1 AND UserId = " . $session_id . " ORDER BY DateCreated DESC LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    function GetActiveTransaction($conn, $session_id) {
        $sql = "SELECT * FROM transactions WHERE Active = 1 AND UserId = " . $session_id . " ORDER BY DateCreated DESC LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    function RemoveActiveOrders($conn, $orderId) {
        $sql = "UPDATE orders SET Active = " . 0 . ", DateUpdated = '" . date("Y/m/d")  . "'"
            . " WHERE OrderId = '" . $orderId . "'";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    function GetCurrentDate() {
        return date('Y-m-d H:i:s');
    }
?>