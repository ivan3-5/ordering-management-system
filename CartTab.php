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
<script src="js/jquery-3.7.1.min.js"></script>
<script src="js/order-list.service.js"></script>

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
        <table id="orderList" style="width: 100%;">
            <tr>
                <th style="width: 33%;">Product</th>
                <th style="width: 33%;text-align: right;" class="quantity">Quantity</th>
                <th style="width: 33%;" class="price">Price</th>
                <th></th>
            </tr>
        </table>
    </div>
        <!-- Date and Total Section -->
        <hr style="border: 2px solid #000; width: 100%; margin: 20px auto;">
        <div class="date-total-section">
            <div class="date-text" id="dateToday">Date: </div>
            <div id="sumPrice" class="total-amount"></div>
        </div>
    <!-- Pickup Now Button -->
    <p class="pickup-now-btn" onclick="orderNow()">Order Now</p>
    <!-- <a href="ChooseOptionOrder.php" class="pickup-now-btn">Order Now</a> -->
    </div>
</div>

<script type="text/javascript">
    var orders = [];
    $(document).ready(function() {
        loadInitialData();
        fetchOrders(true, (_order) => {
            orders =_order;
        });
    });

    function loadInitialData() {
        // Get the current date
        const currentDate = new Date();
        
        // Format the date as YYYY-MM-DD
        const year = currentDate.getFullYear();
        const month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Adding 1 as months are zero-indexed
        const day = String(currentDate.getDate()).padStart(2, '0'); // Ensure two digits for the day
        
        const formattedDate = `${year}-${month}-${day}`;
        
        // Set the formatted date with "Date: " in the 'dateToday' element
        document.getElementById("dateToday").innerHTML = `Date: ${formattedDate}`;
    }

    function orderNow() {
        if (orders.length) {
            window.location.href = "ChooseOptionOrder.php";
        }
    }

    // function fetchOrders() {
    //     $.ajax({
    //         type: "POST",
    //         url: 'Services/GetOrderListService.php',
    //         success: function(response)
    //         {
    //             const orders = JSON.parse(response);
    //             console.log(orders);

    //             if (orders) {
    //                 orders.map((order, index) => {
    //                     $("#orderList").find('tbody')
    //                         .append($('<tr>')
    //                             .append($('<td style="width: 30%;">').text('Order ' + (index+1) + ': ' + order.OrderName))
    //                             .append($('<td style="width: 33%;text-align: right;" class="quantity">').text(order.Quantity + 'x'))
    //                             .append($('<td style="width: 33%;" class="price">').text('₱' + (parseFloat(order.TotalPrice) * order.Quantity).toFixed(2)))
    //                             .append($('<td>')
    //                                 .append($('<p>')
    //                                     .append($('<img style="width: 45px; position: relative;top: 9px;" src="System Pictures/Delete_icon-removebg-preview.png">')))
    //                                 .click(() => {
    //                                     deleteOrder(order.Id);
    //                                 })
    //                             )
    //                         );
    //                 });

    //                 const totalPriceList = orders.map(order => {
    //                     return (parseFloat(order.TotalPrice) * order.Quantity).toFixed(2);
    //                 });
                    
    //                 const sum = totalPriceList.reduce((partialSum, totalPrice) => partialSum + parseFloat(totalPrice), 0);

    //                 $("#sumPrice").text('Total Amount: ₱' + sum.toFixed(2));
    //             }
    //         }
    //     });
    // }

    function deleteOrder(orderId) {
        $.ajax({
            type: "POST",
            url: 'Services/DeleteOrderSerivce.php',
            data: { orderId },
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
