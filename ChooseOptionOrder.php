<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Order Option</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Kotta+One&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="ChooseOptionOrder.css">
</head>
<body>
<a href="homepage.php">
    <img src="System Pictures/BSIT-2F_Logo_real-removebg-preview.png" alt="Logo" class="logo">
</a>
<!-- Customer Service header -->
<div class="header-text">
Choose your option
</div>

<!-- Profile icon -->
<a href="UserProfile.php"> 
    <img src="Photos/profile-icon.svg" alt="Profile" class="profile-icon">
</a>

<!-- New background container for Pickup/Delivery choices -->
<div class="new-bg-container">
    <div class="row">
        <!-- Pickup choice as a button -->
        <a button href="PickUpTab.php" class="col choice">
            Pickup
        </a>

        <!-- Delivery choice as a button -->
        <a button href= "DeliveryTab.php" class="col choice">
            Delivery
        </a>
    </div>
</div>

<script src="js/jquery-3.7.1.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    // getOrderCount();
  });

  function addTransaction(){
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
            console.log(response);
            location.reload();
        }
    });
  }
</script>
</body>
</html>
