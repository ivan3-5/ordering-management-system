<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Tab</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Kotta+One&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="CartTab.css">
</head>
<body>
<a href="homepage.php">
    <img src="Photos/image logo.png" alt="Logo" class="logo">
</a>

<!-- Customer Service Header -->
<div class="header-text">
    Cart Tab
</div>

<!-- Profile Icon -->
<a href="UserProfile.php"> 
    <img src="Photos/profile-icon.svg" alt="Profile" class="profile-icon">
</a>

<!-- New Background Container -->
<div class="new-bg-container">
    <div class="order-details">
        <div class="order-item">
            <span>Order 1: Brew Coffee</span>
            <span class="price">$80.00</span>
        </div>
        <div class="order-item">
            <span>Order 2: Muffins 4x</span>
            <span class="price">$150.00</span>
        </div>
        <div class="order-item">
            <span>Order 3: Brew Coffee</span>
            <span class="price">$20.00</span>
        </div>
        <div class="order-item">
            <span>Order 4: Muffins 4x</span>
            <span class="price">$55.00</span>
        </div>
        <div class="order-item">
            <span>Order 5: Brew Coffee</span>
            <span class="price">$12.00</span>
        </div>
        <div class="order-item">
            <span>Order 6: Muffins 4x</span>
            <span class="price">$70.00</span>
        </div>
        <hr class="pickup-line">
        
    </div>
        <!-- Date and Total Section -->
        <div class="date-total-section">
            <div class="date-text" id="dateToday">Date: </div>
            <div class="total-amount">Total Amount: $387.00</div>
        </div>
    <!-- Pickup Now Button -->
    <a href="ChooseOptionOrder.php" class="pickup-now-btn">Order Now</a>
    </div>
</div>
<script>
        // Get the current date
        const currentDate = new Date();
        
        // Format the date as YYYY-MM-DD
        const year = currentDate.getFullYear();
        const month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Adding 1 as months are zero-indexed
        const day = String(currentDate.getDate()).padStart(2, '0'); // Ensure two digits for the day
        
        const formattedDate = `${year}-${month}-${day}`;
        
        // Set the formatted date with "Date: " in the 'dateToday' element
        document.getElementById("dateToday").innerHTML = `Date: ${formattedDate}`;
    </script>
</body>
</html>
