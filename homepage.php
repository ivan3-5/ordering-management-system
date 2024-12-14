<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['id'])) {
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    $userRole = $_SESSION['UserRole'];
    if ($userRole === 'admin') {
        header('Location: Admin.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ninong Ry's</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="homepage.css">
    <link rel="icon" href="Photos/image logo.png" type="image/x-icon">
</head>
<body>
    <div class="header">
        <div class="navbar navbar-expand-lg navbar-light">
            <div class="icon">
                <img src="Photos/image logo.png" alt="Ry's">
            </div>
            
            <div class="navmenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="MenuList (1).php"><button class="btn-custom-hover">MENU LIST</button></a>
                    </li>
                    <li class="nav-item">
                        <a href="CustomerService.php"><button class="btn-custom-hover">CUSTOMER SERVICE</button></a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a href="CartTab.php"><button class="btn-custom-hover">CART</button></a>
                    </li>
                    <a class="btn-custom-hover">
                        <?php if (isset($_SESSION['email'])): ?>
                            <li class="nav-item" id="click-user">
                                <span id="user-name" style="cursor: pointer;">
                                    <?php echo htmlspecialchars($_SESSION['firstname']) . " " . htmlspecialchars($_SESSION['lastname']); ?>
                                </span>
                                <button id="logout-button" class="btn-custom-hover" style="display: none;" onclick="logout()">LOGOUT</button>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a href="Login.php"><button  id="Login-Design">LOG IN</button></a >
                            </li>
                        <?php endif; ?>
                        </a>
                    
                </ul>              
            </div>
        </div>

        <div class="content mx-3">
            <h1><span class="start-text">START YOUR DAY</span><br><span class="flavour-text">WITH FLAVOUR.</span></h1>
            <p class="hometext">With every sip, feel recharged and ready to take<br>on your day. Our coffee is here to keep you going,<br>one cup at a time-bringing you the warmth,<br>energy, and comfort you need, whenever you need it.</p>
        </div>
    </div>
    
    <!-- Menu List Section -->
    <div id="menu-list" class="content-section">
        <h2>Menu List</h2>
        <p>Manage and update the menu items here.</p>
        <form id="add-category-form">
            <label for="category-name">Category Name:</label>
            <input type="text" id="category-name" name="category-name" required>
            <label for="category-description">Description:</label>
            <textarea id="category-description" name="category-description" required></textarea>
            <button type="submit">Add Category</button>
        </form>
        <br>
        <hr>
        <br>
        <form id="add-item-form">
            <label for="item-name">Item Name:</label>
            <input type="text" id="item-name" name="item-name" required>
            <label for="item-category">Category:</label>
            <select id="item-category" name="category" required>
                <option value="" disabled selected>Select a Category</option>
                <!-- Categories will be dynamically added here -->
            </select>
            <label for="item-image">Image:</label>
            <input type="file" id="item-image" name="item-image" required>
            <label for="item-description">Description:</label>
            <textarea id="item-description" name="item-description" required></textarea>
            <label for="item-price">Price ($):</label>
            <input type="number" id="item-price" name="item-price" required>
            <button type="submit">Add Item</button>
        </form>
        <br>
        <hr>
        <br>
        <h3>Category List</h3>
        <table id="categoryListTable" class="responsive-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Categories will be dynamically added here -->
            </tbody>
        </table>
        <br>
        <hr>
        <br>
        <h3>Item List</h3>
        <table id="itemListTable" class="responsive-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Item Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Category ID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Items will be dynamically added here -->
            </tbody>
        </table>
        <button id="updateMenuListBtn" class="btn btn-primary">Update</button> <!-- Add Update button -->
    </div>

    <footer class="text-white pt-5 pb-4" style="background-color: #C6A988;">
        <div class="container text-center text-md-left">
            <div class="row text-center text-md-left">
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="company text-uppercase mb-4 font-weight-bold text-outline" style="color: #E4B279;">Ninong Ry's</h5>
                    <p>Brewed with love, served with a smile - your perfect coffee experience, one cup at a time.</p>
                </div>

                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                        <h5 class="text-uppercase mb-4 font-weight-bold text-outline" style="color: #E4B279;">Products</h5>
                    <p>
                        <a href="#" class="text-white" style="text-decoration: none;">PLACEHOLDER</a>
                    </p>
                    <p>
                        <a href="#" class="text-white" style="text-decoration: none;">PLACEHOLDER</a>
                    </p>
                    <p>
                        <a href="#" class="text-white" style="text-decoration: none;">PLACEHOLDER</a>
                    </p>
                    <p>
                        <a href="#" class="text-white" style="text-decoration: none;">PLACEHOLDER</a>
                    </p>
                </div>

                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold text-outline" style="color: #E4B279;">Useful Links</h5>
                    <p>
                        <a href="#" class="text-white" style="text-decoration: none;">About Us</a>
                    </p>
                    <p>
                        <a href="#" class="text-white" style="text-decoration: none;">Home</a>
                    </p>
                    <p>
                        <a href="#" class="text-white" style="text-decoration: none;">Menu List</a>
                    </p>
                    <p>
                        <a href="#" class="text-white" style="text-decoration: none;">Customer Service</a>
                    </p>
                </div>

                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold text-outline" style="color: #E4B279;">Contact</h5>
                    <p>
                        <i class="fas fa-home mr-3"></i> Medalla, Purok Carnacion, 3rd Street,
                         Panabo City, Davao del Norte
                    </p>
                    <p>
                        <i class="fas fa-envelope mr-3"></i> <a href="#" class="text-white" style="text-decoration: none">ninongry@email.com</a>
                    </p>
                    <p>
                        <i class="fas fa-phone mr-3"></i>  09922618263
                    </p>
                </div>
                
                <hr class="mb-4">
                <div class="row align-items-center">
                    <div class="col-md-7 col-lg-8">
                        <p>Copyright ©2024 All rights reserved. This website is made with by <a href="#" class="text-white" style="text-decoration: none;"><strong>Team Ninong Ry's</strong></a>
                        </p>
                    </div>                
                </div>
            </div>
        </div>    
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        document.getElementById('click-user').addEventListener('click', function() {
            var logoutButton = document.getElementById('logout-button');
            if (logoutButton.style.display === 'none') {
                logoutButton.style.display = 'block';
            } else {
                logoutButton.style.display = 'none';
            }
        });

        document.getElementById('logout-button').addEventListener('click', function() {
            if (confirm('Are you sure you want to log out?')) {
                window.location.href = 'Services/User/LogoutService.php';
            }
        });
    </script>
</body>
</html>
