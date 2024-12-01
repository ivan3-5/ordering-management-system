<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Kotta+One&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="DeliveryTab.css">
</head>
<body>
<a href="homepage.php">
    <img src="System Pictures/BSIT-2F_Logo_real-removebg-preview.png" alt="Logo" class="logo">
</a>

<!-- Customer Service Header -->
<div class="header-text">
    Delivery Order
</div>

<!-- Profile Icon -->
<a href="UserProfile.php"> 
    <img src="System Pictures/ako mani oh huh.jpg" alt="Profile" class="profile-icon">
</a>

<!-- New Background Container -->
<div class="new-bg-container">
    <div class="row">
        <!-- Pickup Choice as a Button -->
        <button class="col choice" onclick="generatePickupID()">
            Generate Delivery ID
        </button>
    </div>
    
    <!-- Display Pickup ID -->
    <div class="pickup-id" id="pickupIDContainer">
    <hr class="pickup-line">
        Delivery ID: <span id="pickupID"></span>
    </div>
    <div class="order-details">
        <div class="order-item">
            <span>Order 1: Brew Coffee</span>
            <span class="price">$80.00</span>
        </div>
        <div class="order-item">
            <span>Order 2: Muffins 4x</span>
            <span class="price">$150.00</span>
        </div>
        <hr class="pickup-line">
        <div class="date-total">
        <span id="currentDate"></span> <!-- Display current date -->
        <span id="totalAmount" class="total-price">Total: $230.00</span> <!-- Display total price -->
    </div>
        <!-- Estimated Time to Pickup Section -->
        <div class="estimated-time">
            Estimated Time to Pickup: <span id="pickupTime">8:00 am</span>
        </div>

        <!-- Customer Address Section -->
    <div class="customer-address">
        <label for="addressType">Customer Address:</label>
        <select id="addressType" name="addressType" class="form-select" onchange="toggleNewAddressInput()">
            <option value="permanent">Permanent Address</option>
            <option value="new">New Address</option>
        </select>
        
        <textarea id="newAddress" name="newAddress" class="form-control" placeholder="Enter your new address" style="display: none; margin-top: 10px;"></textarea>
    </div>
        
    </div>
    
    <!-- Payment Section moved to the left side -->
    <div class="payment-section">
        <label for="paymentOptions" class="payment-label">Payment:</label>
        <select id="paymentOptions" name="paymentOptions" class="payment-select">
            <option value="gcash">Gcash</option>
            <option value="creditCard">Credit Card</option>
            <option value="cash">Cod</option>
        </select>
    </div>
    <!-- Pickup Now Button -->
<a href="MenuList.php" class="pickup-now-btn">Order Now</a>
</div>

<!-- JavaScript for Pickup ID -->
<script>
    function generatePickupID() {
        const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const numbers = '0123456789';
        let id = '';

        for (let i = 0; i < 5; i++) {
            id += letters.charAt(Math.floor(Math.random() * letters.length));
        }

        for (let i = 0; i < 5; i++) {
            id += numbers.charAt(Math.floor(Math.random() * numbers.length));
        }

        document.getElementById('pickupID').innerText = id;
    }
    function displayCurrentDate() {
    const today = new Date();
    const year = today.getFullYear();
    const month = (today.getMonth() + 1).toString().padStart(2, '0'); // Get month and ensure two digits
    const day = today.getDate().toString().padStart(2, '0'); // Get day and ensure two digits
    const currentDate = `${year}-${month}-${day}`; // Format as YYYY-MM-DD
    document.getElementById('currentDate').textContent = 'Date: ' + currentDate;
}

function toggleNewAddressInput() {
        const addressType = document.getElementById('addressType').value;
        const newAddress = document.getElementById('newAddress');
        if (addressType === 'new') {
            newAddress.style.display = 'block';
        } else {
            newAddress.style.display = 'none';
        }
    }
// Call the function to display the current date when the page loads
window.onload = function() {
    displayCurrentDate();
};
</script>
</body>
</html>
