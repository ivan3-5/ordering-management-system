<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ninong Ry's</title>  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
  <link rel="stylesheet" href="MenuList.css">
  <style>
    html {
      scroll-behavior: smooth;
    }
  </style>
</head>
<body style="background-color: #C6A988;">
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
        <img src="System Pictures/ako mani oh huh.jpg" alt="Profile Image">
      </button>
      </a>
      <a button href="ChooseOptionOrder.php"  class="order-now-button">Order Now</a>
      <a button href="CartTab.php" class="Cart-button">
        <img src="System Pictures/cart_icon-removebg-preview.png" alt="Cart Icon">
      </a>
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
  <div class="banner-overlay" onclick="openOrderWindow('Mocha Frappe x Chocolate Croissant Banner', 125.85, 'a rich and creamy blend of coffee and chocolate, pairs perfectly with our flaky Chocolate Croissant.', 'System Pictures/Mocha Frappe x Chocolate Croissant  Real.png')">
  </div>
</button>

  <!-- First Row Pastries -->
  <div class="container mt-5" id="pastries-section"> <!-- Added an ID here -->
    <div class="Pc1-container">
      <h1 style="font-family: abel;">Pastries</h1>
    </div>
    <div class="row">
      <div class="col-md-3 mb-4">
        <div class="product-frame">
          <img src="System Pictures/muffins.jpg" alt="Product Image" class="product-image">
          <p class="product-title"><b>Muffins</b></p>
          <p class="product-description">Baked fresh daily, an assortment of chocolate and fruit muffins. Individually packaged upon request.</p>
          <p class="product-price">₱50.40</p>
          <button class="order-btn" onclick="openOrderWindow('Muffin', 50.40, 'Baked fresh daily, an assortment of chocolate and fruit muffins. Individually packaged upon request.', 'System Pictures/muffins.jpg')">Order Now</button>
        </div>
      </div>

     

      <div class="col-md-3 mb-4">
        <div class="product-frame">
          <img src="System Pictures/scones asorted.jpg" alt="Product Image" class="product-image">
          <p class="product-title"><b>Scones</b></p>
          <p class="product-description">Freshly baked each morning. Assorted sweet and savoury buttermilk breakfast scones. Individually packaged on request.</p>
          <p class="product-price">₱60.55</p>
          <button class="order-btn" onclick="openOrderWindow('Scones', 60.55, 'Freshly baked each morning. Assorted sweet and savoury buttermilk breakfast scones. Individually packaged on request.', 'System Pictures/scones asorted.jpg')">Order Now</button>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="product-frame">
          <img src="System Pictures/cookies asorted.jpg" alt="Product Image" class="product-image">
          <p class="product-title"><b>Cookies</b></p>
          <p class="product-description">A small, flat, sweet treat made from flour, sugar, eggs, and some kind of fat or oil.</p>
          <p class="product-price">₱85.99</p>
          <button class="order-btn" onclick="openOrderWindow('Cookies', 85.99, 'A small, flat, sweet treat made from flour, sugar, eggs, and some kind of fat or oil. ', 'System Pictures/cookies asorted.jpg')">Order Now</button>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="product-frame">
          <img src="System Pictures/cinnamon buns asorted.jpg" alt="Product Image" class="product-image">
          <p class="product-title"><b>Cinnamon Buns</b></p>
          <p class="product-description">a sweet baked dough filled with a cinnamon-sugar filling. Made with a rich dough leavened with yeast.</p>
          <p class="product-price">₱45.59</p>
          <button class="order-btn" onclick="openOrderWindow('Cinnamon Buns', 45.59, 'a sweet baked dough filled with a cinnamon-sugar filling. Made with a rich dough leavened with yeast. ', 'System Pictures/cinnamon buns asorted.jpg')">Order Now</button>
        </div>
      </div>
    </div>
  </div>

 <!-- Second Row Pastries -->
 <div class="container mt-5">
    <div class="row">
      <div class="col-md-3 mb-4">
        <div class="product-frame">
          <img src="System Pictures/hand pies.jpg" alt="Product Image" class="product-image">
          <p class="product-title"><b>Hand pies</b></p>
          <p class="product-description">small, single-serving pies with flaky pastry that can be baked or fried and filled with sweet or savory fillings.</p>
          <p class="product-price">₱75.59</p>
          <button class="order-btn" onclick="openOrderWindow('Handpies', 75.59, 'small, single-serving pies with flaky pastry that can be baked or fried and filled with sweet or savory fillings.  ', 'System Pictures/hand pies.jpg')">Order Now</button>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="product-frame">
          <img src="System Pictures/bagel platter.jpg" alt="Product Image" class="product-image">
          <p class="product-title"><b>Bagel Platter</b></p>
          <p class="product-description">18 Fresh baked bagels (not toasted), assorted cream cheeses,accompaniments (boiled egg, arugula, tomato, caper, red onion).</p>
          <p class="product-price">₱35.29</p>
          <button class="order-btn" onclick="openOrderWindow('Bagel Platter', 35.29, '18 Fresh baked bagels (not toasted), assorted cream cheeses,accompaniments (boiled egg, arugula, tomato, caper, red onion).', 'System Pictures/bagel platter.jpg')">Order Now</button>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="product-frame">
          <img src="System Pictures/Coconut Rice Pudding.jpg" alt="Product Image" class="product-image">
          <p class="product-title"><b>Coconut Rice Pudding</b></p>
          <p class="product-description">Rich, creamy coconut milk and short grain rice pudding with vanilla bean paste and orange zest.</p>
          <p class="product-price">₱43.00</p>
          <button class="order-btn" onclick="openOrderWindow('Coconut Rice Pudding', 43.00, 'Rich, creamy coconut milk and short grain rice pudding with vanilla bean paste and orange zest.', 'System Pictures/Coconut Rice Pudding.jpg')">Order Now</button>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="product-frame">
          <img src="System Pictures/Croissant.jpg" alt="Product Image" class="product-image">
          <p class="product-title"><b>Croissant</b></p>
          <p class="product-description">a buttery, flaky, viennoiserie pastry inspired by the shape of the Austrian kipferl, but using the French yeast-leavened laminated dough.</p>
          <p class="product-price">₱65.25</p>
          <button class="order-btn" onclick="openOrderWindow('Croissant', 65.25, 'a buttery, flaky, viennoiserie pastry inspired by the shape of the Austrian kipferl, but using the French yeast-leavened laminated dough.', 'System Pictures/Croissant.jpg')">Order Now</button>
        </div>
      </div>
    </div>
  </div>

  
   
  <!-- First Row Coffee -->
  <div class="container mt-5" id="coffee-section">
    <div class="Pc1-container">
      <h1 style="font-family: abel;">Coffee</h1>
    </div>
    <div class="row">
      <div class="col-md-3 mb-4">
        <div class="product-frame">
          <img src="System Pictures/Salted Caramel Macchiato.jpg" alt="Product Image" class="product-image">
          <p class="product-title"><b>Salted Caramel Macchiato</b></p>
          <p class="product-description">This creamy salted caramel macchiato is just the right amount sweet and salty.</p>
          <p class="product-price">₱95.60</p>
          <button class="order-btn" onclick="openOrderWindow('Salted Caramel Macchiato', 95.60, 'Made with frothed milk, homemade salted caramel sauce and espresso.', 'System Pictures/Salted Caramel Macchiato.jpg')">Order Now</button>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="product-frame">
          <img src="System Pictures/CappuccinoSuperReal.jpg" alt="Product Image" class="product-image">
          <p class="product-title"><b>Cappucino</b></p>
          <p class="product-description">espresso coffee topped with frothed hot milk or cream and often flavored with cinnamon.</p>
          <p class="product-price">₱105.99</p>
          <button class="order-btn" onclick="openOrderWindow('Cappucino', 105.99, 'espresso coffee topped with frothed hot milk or cream and often flavored with cinnamon.', 'System Pictures/CappuccinoSuperReal.jpg')">Order Now</button>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="product-frame">
          <img src="System Pictures/flat white.jpg" alt="Product Image" class="product-image">
          <p class="product-title"><b>Flat White</b></p>
          <p class="product-description">Baked fresh daily, an assortment of our daily selections. Individual packaging upon request.</p>
          <p class="product-price">₱35.99</p>
          <button class="order-btn" onclick="openOrderWindow('Flat Whit', 35.99, 'Baked fresh daily, an assortment of our daily selections. Individual packaging upon request.', 'System Pictures/flat white.jpg')">Order Now</button>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="product-frame">
          <img src="System Pictures/Biscoff Affogato.jpg" alt="Product Image" class="product-image">
          <p class="product-title"><b>Biscoff Affogato</b></p>
          <p class="product-description">It's crispy yet chewy, with a delightful caramel tinge.</p>
          <p class="product-price">₱55.59</p>
          <button class="order-btn" onclick="openOrderWindow('Biscoff Affogato', 55.59, ' But dont confuse Biscoff with the Dutch speculaas, which contain a greater variety of spices.', 'System Pictures/Biscoff Affogato.jpg')">Order Now</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Second Row Coffee -->
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-3 mb-4">
        <div class="product-frame">
          <img src="System Pictures/Mocha.jpg" alt="Product Image" class="product-image">
          <p class="product-title"><b>Mocha Coffee</b></p>
          <p class="product-description">a shot of espresso is combined with chocolate powder or syrup, followed by milk or cream. </p>
          <p class="product-price">₱30.99</p>
          <button class="order-btn" onclick="openOrderWindow('Mocha Coffee', 30.99, ' a shot of espresso is combined with chocolate powder or syrup, followed by milk or cream.', 'System Pictures/Mocha.jpg')">Order Now</button>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="product-frame">
          <img src="System Pictures/Piccolo latte.jpg" alt="Product Image" class="product-image">
          <p class="product-title"><b>Piccolo Latte</b></p>
          <p class="product-description">a shot of espresso is combined with a small amount of steamed milk.</p>
          <p class="product-price">₱49.59</p>
          <button class="order-btn" onclick="openOrderWindow('Piccolo Latte', 49.59, ' a shot of espresso is combined with a small amount of steamed milk.', 'System Pictures/Piccolo latte.jpg')">Order Now</button>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="product-frame">
          <img src="System Pictures/Americano Coffee.jpg" alt="Product Image" class="product-image">
          <p class="product-title"><b>Latte</b></p>
          <p class="product-description">a coffee drink made with espresso and hot water</p>
          <p class="product-price">₱50.99</p>
          <button class="order-btn" onclick="openOrderWindow('Latte', 50.99, ' a coffee drink made with espresso and hot water.', 'System Pictures/Americano Coffee.jpg')">Order Now</button>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="product-frame">
          <img src="System Pictures/Long Black Coffee.jpg" alt="Product Image" class="product-image">
          <p class="product-title"><b>Long Black Coffee</b></p>
          <p class="product-description">an espresso drink consisting of two shots of espresso diluted with hot water.</p>
          <p class="product-price">₱83.50</p>
          <button class="order-btn" onclick="openOrderWindow('Long Black Coffee', 83.50, ' it is made by pouring hot water in a cup and pouring the espresso shots on top of the water.', 'System Pictures/Long Black Coffee.jpg')">Order Now</button>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-4">
  <div class="col-md-4">
    <div class="additional-content text-center">
      <a href="homepage.php"> <!-- Replace 'page2.html' with your desired link -->
        <button class="logo-button">
          <img src="System Pictures/BSIT-2F_Logo_real-removebg-preview.png" alt="Additional Logo" class="logo-image">
        </button>
      </a>
    </div>
  </div>
</div>

 <div class="row mt-4 justify-content-end">
  <div class="col-md-4 d-flex justify-content-end">
    <div class="additional-content text-center">
      <button class="icon-button">
        <img src="System Pictures/facebook logo.png" alt="Icon 1" class="logo-image">
      </button>
    </div>
    <div class="additional-content text-center">
      <button class="icon-button">
        <img src="System Pictures/Instagram logo.png" alt="Icon 2" class="logo-image">
      </button>
    </div>
    <div class="additional-content text-center">
      <button class="icon-button">
        <img src="System Pictures/Contact number logo.png" alt="Icon 3" class="logo-image">
      </button>
    </div>
  </div>
</div>

  <div class="row mt-4">
  <div class="col-12">
    <div class="horizontal-line"></div>
  </div>
</div>
<div class="icon-container">
  <div class="icon-item">
    <img src="System Pictures/COD-removebg-preview.png" alt="Icon 1" class="icon-image">
  </div>
  <div class="icon-item">
    <img src="System Pictures/gcash-removebg-preview.png" alt="Icon 2" class="icon-image">
  </div>
</div>
<div class="Pc2-container">
    <h1 style="font-family: abel;">Reach Us</h1>
</div>

<div class="input-container">
    <input type="text" placeholder="Type here..." class="text-box">
    <button class="signup-button">Sign Up</button>
</div>
<!-- Order Cart Hover-->
<div class="order-window" id="orderWindow">
    <div class="order-content">
        <button class="close-btn" onclick="closeOrderWindow()">×</button>
        <img id="orderImg" src="" alt="Product Image" class="order-img">
        <h2 class="order-name" id="orderName">Product Name</h2>
        <p class="order-price">Price: ₱<span id="totalPrice">0.00</span></p>
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
