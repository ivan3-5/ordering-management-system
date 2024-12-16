<?php
class OrderService {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "order_management";
    private $conn;

    public function __construct() {
        
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getOrders() {
        
        $sql = "SELECT OrderID, UserID, DeliveryID, TransactionID, pickup, order_date, order_status, total_amount FROM `orders`";
        $result = $this->conn->query($sql);

        
        if ($result->num_rows > 0) {
            
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["OrderID"] . "</td>";
                echo "<td>" . $row["UserID"] . "</td>";
                echo "<td>" . $row["DeliveryID"] . "</td>";
                echo "<td>" . $row["TransactionID"] . "</td>";
                echo "<td>" . ($row["pickup"] ? "Yes" : "No") . "</td>";
                echo "<td>" . $row["order_date"] . "</td>";
                echo "<td>" . ($row["order_status"] ? "Completed" : "Pending") . "</td>";
                echo "<td>₱" . number_format($row["total_amount"], 2) . "</td>";
                echo "<td><button class='complete-order-btn' data-id='" . $row["OrderID"] . "'>Complete Order</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No orders found</td></tr>";
        }
    }

    public function completeOrder($orderId) {
        
        $sql = "UPDATE `orders` SET order_status = 1, DateUpdated = NOW() WHERE OrderID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $orderId);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function __destruct() {
        
        $this->conn->close();
    }
}
?>