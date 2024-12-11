<?php
class OrderService {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "order_management";
    private $conn;

    public function __construct() {
        // Create connection
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getOrders() {
        // SQL query to fetch orders
        $sql = "SELECT Id, OrderName, Quantity, TotalPrice, OrderDescription, Active, OrderID, UserId, DateCreated, DateUpdated FROM `orders`";
        $result = $this->conn->query($sql);

        // Check if there are results
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Id"] . "</td>";
                echo "<td>" . $row["OrderName"] . "</td>";
                echo "<td>" . $row["Quantity"] . "</td>";
                echo "<td>" . $row["TotalPrice"] . "</td>";
                echo "<td>" . $row["OrderDescription"] . "</td>";
                echo "<td>" . ($row["Active"] ? "Completed" : "Pending") . "</td>";
                echo "<td>" . $row["OrderID"] . "</td>";
                echo "<td>" . $row["UserId"] . "</td>";
                echo "<td>" . $row["DateCreated"] . "</td>";
                echo "<td>" . $row["DateUpdated"] . "</td>";
                echo "<td><button class='complete-order-btn " . ($row["Active"] ? "grey-button" : "") . "' data-id='" . $row["Id"] . "' " . ($row["Active"] ? "disabled" : "") . ">Complete Order</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='11'>No orders found</td></tr>";
        }
    }

    public function completeOrder($orderId) {
        // SQL query to update order status and DateUpdated
        $sql = "UPDATE `orders` SET Active = 1, DateUpdated = NOW() WHERE Id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $orderId);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function __destruct() {
        // Close connection
        $this->conn->close();
    }
}
?>