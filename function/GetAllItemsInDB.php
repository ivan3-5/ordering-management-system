<?php
class Database {
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

    public function getCategories() {
        $sql = "SELECT CategoryID, category_name FROM category";
        return $this->conn->query($sql);
    }

    public function getProductsByCategory($categoryId) {
        $sql = "SELECT item_name, item_image, description, price FROM menu WHERE CategoryID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $categoryId); // Use "s" for string type
        $stmt->execute();
        return $stmt->get_result();
    }

    public function close() {
        $this->conn->close();
    }
}

class ProductDisplay {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function displayProducts() {
        $categoriesResult = $this->db->getCategories();

        if ($categoriesResult->num_rows > 0) {
            while ($category = $categoriesResult->fetch_assoc()) {
                $categoryId = $category['CategoryID'];
                $categoryName = htmlspecialchars($category['category_name']);

                echo '<div class="container mt-5" id="' . strtolower($categoryName) . '-section">';
                echo '<div class="Pc1-container">';
                echo '<h1 style="font-family: abel;">' . $categoryName . '</h1>';
                echo '</div>';
                echo '<div class="row">';

                $productsResult = $this->db->getProductsByCategory($categoryId);

                if ($productsResult->num_rows > 0) {
                    while ($product = $productsResult->fetch_assoc()) {
                        $imageData = base64_encode($product['item_image']);
                        $imageSrc = 'data:image/jpeg;base64,' . $imageData;
                        echo '<div class="col-md-3 mb-4">';
                        echo '<div class="product-frame">';
                        echo '<img src="' . $imageSrc . '" alt="Product Image" class="product-image">';
                        echo '<p class="product-title"><b>' . htmlspecialchars($product['item_name']) . '</b></p>';
                        echo '<p class="product-description">' . htmlspecialchars($product['description']) . '</p>';
                        echo '<p class="product-price">₱' . number_format($product['price'], 2) . '</p>';
                        echo '<button class="order-btn" onclick="openOrderWindow(\'' . htmlspecialchars($product['item_name']) . '\', ' . $product['price'] . ', \'' . htmlspecialchars($product['description']) . '\', \'' . $imageSrc . '\')">Order Now</button>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No products found in this category.</p>';
                }

                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No categories found.</p>';
        }
    }
}

$db = new Database();
$productDisplay = new ProductDisplay($db);
$productDisplay->displayProducts();
$db->close();