<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['UserRole'] !== 'user') {
  header('Location: homepage.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ninong Ry's</title>  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
  <link rel="stylesheet" href="MenuList (1).css">
  <style>
    html {
      scroll-behavior: smooth;
    }
  </style>
</head>

<body style="background-color: #C6A988;">
<script src="js/jquery-3.7.1.min.js"></script>

<div class="containerLogo">
  <a href="homepage.php">
    <button class="logo-button">
      <img src="System Pictures/BSIT-2F_Logo_real-removebg-preview.png" 
           style="width: 190px; height: 190px;" alt="Logo">
    </button>
  </a>
</div>

  <div class="content-container">
    <h1 style="font-family: abel;">Fresh, Local and Thoughtful</h1>
    
    <div class="order-now-container">
      <a href="UserProfile.php" button class="profile-button">
        <p><?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname'] ?></p>
      </a>
      <a button href="ChooseOptionOrder.php"  class="order-now-button">Order Now</a>
      <a button href="CartTab.php" class="Cart-button">
        <span id="orderCount" style="position: relative;left: 37px;top: -3px;color: black;"></span>
        <img src="System Pictures/cart_icon-removebg-preview.png" alt="Cart Icon">
      </a>
      <!-- <button href="logout.php" class="logout-button" id="logout-button" onclick="logout()">Logout</button> -->
    </div>
  </div>

  <div class="search-container">
    <div class="search-wrapper">
      <button class="search-button">
        <img src="System Pictures/serach_icon-removebg-preview.png" alt="Search Icon">  
      </button>
      <input type="text" id="search-input" placeholder="Search...">
    </div>
   
    <div class="pc-container">
      <!-- Anchor links to navigate to Pastries and Coffee sections -->
      <a href="#pastries-section">
        <button class="pc-now-button">Pastries</button>
      </a>
      <a href="#coffee-section">
        <button class="pc-now-button">Coffee</button>
      </a>
    </div>
  </div>

  <button target="_blank" class="banner"> <!-- Replace URL with the desired link -->
  <div class="banner-overlay" onclick="openOrderWindow('Mocha Frappe x Chocolate Croissant Banner', 125.85, 'a rich and creamy blend of coffee and chocolate, pairs perfectly with our flaky Chocolate Croissant.', 'System Pictures/Mocha Frappe x Chocolate Croissant .png')">
  </div>
  </button>

  <!-- Get All Items in MySQL Database-->
  <?php require_once 'function/GetAllItemsInDB.php'; ?>

  <!-- Order Cart Hover-->
  <div class="order-window" id="orderWindow">
    <div class="order-content">
        
      <button class="close-btn" onclick="closeOrderWindow()">×</button>
      <img id="orderImg" src="" alt="Product Image" class="order-img">
      <h2 class="order-name" id="orderName">Product Name</h2>
      <p class="order-price">Price: ₱<span id="totalPrice">0.00</span></p>
      <p class="order-description" id="orderDescription">Description</p>
      <div class="quantity">
      <p button style="position: relative;top: 8px;right: 3px;background-color: white;padding: 2px 7px;height: 24px;" onclick="adjustQuantity(-1)">−</p>
          <input name="quantity" type="number" id="quantity" value="1">
          <p button style="position: relative;top: 8px;left: 3px;background-color: white;padding: 2px 7px;height: 24px;"onclick="adjustQuantity(1)">+</p>
      </div>

      <!-- <div class="hidden-inputs" style="opacity:0; position:absolute;width:0;height:0;z-index:-1;">
        <input name="orderImg" id="orderImg_h">
        <input name="orderName" id="orderName_h">
        <input name="totalPrice" id="totalPrice_h" value="0">
        <input name="orderDescription" id="orderDescription_h">
      </div> -->
        
      <p><input id="orderBtn" type="button" value="Add to Order" onclick="addOrder()"/></p>

    </div>
  </div>

<script type="text/javascript">
  $(document).ready(function() {
    getOrderCount();

    $('#logout-button').on('click', function() {
      // Clear cart data and log out
      $.ajax({
        type: "POST",
        url: 'Services/LogoutService.php',
        success: function(response) {
          console.log('Logged out and cart cleared: ', response);
          window.location.href = 'homepage.php'; // Redirect to homepage or login page
        }
      });
    });
  });

  function getOrderCount() {
    $.ajax({
        type: "POST",
        url: 'Services/GetOrderCountService.php',
        success: function(response)
        {
            const count = JSON.parse(response);
            console.log('getOrderCount: ', count);
            $('#orderCount').text(count);
        }
    });
  }

  function addOrder(){
    const quantity = document.getElementById("quantity").value;     
    const orderName = document.getElementById("orderName").innerText;
    const totalPrice = document.getElementById("totalPrice").innerText;
    const orderDescription = document.getElementById("orderDescription").innerText;
    const orderImg = document.getElementById("orderImg").src; 
    console.log("quantity", { quantity, orderName, totalPrice, orderDescription, orderImg});

    $.ajax({
        type: "POST",
        url: 'Services/AddOrderService.php',
        data: { quantity, orderName, totalPrice, orderDescription, orderImg },
        success: function(response)
        {
            console.log('addOrder: ', response);
            const data = JSON.parse(response);
            if (data.status === "success") {
              location.reload();
            }
        }
    });
  }
      
  const basePrices = {}; // Store base prices for calculation

  function openOrderWindow(productName, productPrice, productDescription, productImage) {
    console.log(productName);
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
    console.log("change", change);
    const quantityInput = document.getElementById("quantity");
    const currentQuantity = parseInt(quantityInput.value);
    const newQuantity = currentQuantity + change;

    if (newQuantity > 0) {
        quantityInput.value = newQuantity;

        const productName = document.getElementById("orderName").textContent;
        const newTotalPrice = (basePrices[productName] * newQuantity).toFixed(2);
        document.getElementById("totalPrice").textContent = newTotalPrice;
        // document.getElementById("totalPrice_h").textContent = newTotalPrice;
    }
  }
</script>
</body>
</html>
