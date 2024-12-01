<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>order oredr oder</title>
</head>
<style>
    body {
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center; 
    height: 100vh;
    background-color: #f8f8f8; 
    }
    .product {
    text-align: center;
    margin: 0;

    }

    .product-img {
    width: 200px;
    height: auto;
    border-radius: 8px;
    }

    .order-btn {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    }

    .order-btn:hover {
    background-color: #0056b3;
    }

    .order-window {
    display: none; 
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
    }

    .order-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    width: 300px;
    position: relative;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }


    .close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #f44336;
    color: #fff;
    border: none;
    width: 25px;
    height: 25px;
    font-size: 18px;
    cursor: pointer;
    border-radius: 3px;
    }

    .close-btn:hover {
    background-color: #d32f2f;
    }

    .order-img {
    width: 100%;
    height: auto;
    border-radius: 8px;
    }

    .order-name {
    font-size: 20px;
    margin: 10px 0;
    }

    .order-price {
    font-size: 18px;
    color: #28a745;
    margin: 5px 0;
    }

    .order-description {
    font-size: 14px;
    color: #555;
    margin: 10px 0;
    }

    .quantity {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 10px 0;
    }

    .quantity button {
    width: 30px;
    height: 30px;
    background-color: #007bff;
    color: #fff;
    border: none;
    font-size: 18px;
    border-radius: 3px;
    cursor: pointer;
    }

    .quantity button:hover {
    background-color: #0056b3;
    }

    .quantity input {
    width: 50px;
    text-align: center;
    font-size: 16px;
    margin: 0 5px;
    border: 1px solid #ccc;
    border-radius: 3px;
    }

    .add-to-order {
    padding: 10px 20px;
    background-color: #28a745;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    }

    .add-to-order:hover {
    background-color: #218838;
    }

</style>
<body>
<div class="product-container">
    <div class="product">
        <h1>ORDER WINDOW TEST</h1>
        <img src="https://kickassbaker.com/wp-content/uploads/2023/05/best-blueberry-muffin-recipe-with-sour-cream.jpg" alt="Shit Muffin" class="product-img">
        <h2 class="product-name">Shit Muffin</h2>
        <button class="order-btn" onclick="openOrderWindow('Shit Muffin', 12.99, 'Very shitty!', 'https://kickassbaker.com/wp-content/uploads/2023/05/best-blueberry-muffin-recipe-with-sour-cream.jpg')">Order Now</button>
    </div>
</div>

<div class="product-container">
    <div class="product">
        <h1>ORDER WINDOW TEST</h1>
        <img src="System Pictures/Americano Coffee.jpg" alt="Another Muffin" class="product-img">
        <h2 class="product-name">Another Muffin</h2>
        <button class="order-btn" onclick="openOrderWindow('Another Muffin', 14.99, 'Not so shitty!', 'System Pictures/Americano Coffee.jpg')">Order Now</button>
    </div>
</div>

<div class="order-window" id="orderWindow">
    <div class="order-content">
        <button class="close-btn" onclick="closeOrderWindow()">×</button>
        <img id="orderImg" src="" alt="Product Image" class="order-img">
        <h2 class="order-name" id="orderName">Product Name</h2>
        <p class="order-price">Price: $<span id="totalPrice">0.00</span></p>
        <p class="order-description" id="orderDescription">Description</p>
        <div class="quantity">
            <button onclick="adjustQuantity(-1)">−</button>
            <input type="number" id="quantity" value="1" readonly>
            <button onclick="adjustQuantity(1)">+</button>
        </div>
        <button class="add-to-order">Add to Order</button>
    </div>
</div>

    
    

    <script>
       const basePrices = {}; // Store base prices for calculation

function openOrderWindow(productName, productPrice, productDescription, productImage) {
    // Update modal content
    document.getElementById("orderName").textContent = productName;
    document.getElementById("totalPrice").textContent = productPrice.toFixed(2);
    document.getElementById("orderDescription").textContent = productDescription;
    document.getElementById("orderImg").src = productImage; // Set image dynamically

    // Save base price for quantity updates
    basePrices[productName] = productPrice;

    // Show modal
    document.getElementById("orderWindow").style.display = "flex";
}

function closeOrderWindow() {
    document.getElementById("orderWindow").style.display = "none";
}

function adjustQuantity(change) {
    const quantityInput = document.getElementById("quantity");
    const currentQuantity = parseInt(quantityInput.value);
    const newQuantity = currentQuantity + change;

    if (newQuantity > 0) {
        quantityInput.value = newQuantity;

        const productName = document.getElementById("orderName").textContent;
        const newTotalPrice = (basePrices[productName] * newQuantity).toFixed(2);
        document.getElementById("totalPrice").textContent = newTotalPrice;
    }
}

    </script>

    
</body>
</html>