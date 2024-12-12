<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="UserProfile.css">
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar bg-brown d-flex flex-column align-items-center py-4">
            <div class="nav-icon mb-4">
                <a href="homepage.php"><i class="fas fa-home fa-2x"></i></a>
            </div>
            <div class="nav-icon mb-4">
                <i class="fas fa-file-alt fa-2x"></i>
            </div>
            <div class="nav-icon mb-4">
                <i class="fas fa-motorcycle fa-2x"></i>
            </div>
            <div class="nav-icon mb-4">
                <i class="fas fa-comment fa-2x"></i>
            </div>
            <div class="nav-icon mb-4">
                <i class="fas fa-map-marker-alt fa-2x"></i>
            </div>
            <div class="nav-icon mb-4">
                <i class="fas fa-sign-out-alt fa-2x" onclick="logout()"></i>
            </div>
        </div>

        <!-- Content -->
        <div class="content flex-grow-1 bg-light-brown p-5">
            <h2 class="text-white">PROFILE</h2>
            <div class="d-flex mt-4">
                <!-- Profile -->
                <div class="profile-section bg-brown text-center p-4 rounded">
                    <img src="Photos/profile-icon.svg" alt="Profile Image" class="profile-img rounded-circle mb-3">
                    <h5 id="fullname" class="text-white"></h5>
                </div>
                
                <!-- Purchases -->
                <div class="purchases-section flex-grow-1 bg-brown ml-3 p-4 rounded">
                    <h5 class="text-white">Purchases</h5>
                    <hr class="bg-white">

                    <table id="purchaseList" style="width: 100%;">
                        <tr>
                            <th style="width: 33%;">Product</th>
                            <th style="width: 33%;" class="quantity">Quantity</th>
                            <th style="width: 33%; text-align: right;" class="price">Price</th>
                            <!-- <th></th> -->
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/order-list.service.js"></script>
    <script type="text/javascript">
        let purchasedList = [];
        let purchasedOrderList = [];

        $(document).ready(function() {
            getUser();
            getPurchases();
        });

        function getUser() {
            $.ajax({
                type: "GET",
                url: 'Services/User/GetLoggedInService.php',
                success: function(response) {
                    console.log('login: ', response);
                    const data = JSON.parse(response);
                    if (data.status === "success") {
                        $('#fullname').text(data.FirstName + ' ' + data.LastName);
                    } else {
                        console.log("Unauthorized!");
                    }
                }
            });
        }

        function getPurchases() {
            $.ajax({
                type: "GET",
                url: 'Services/GetPurchaseListService.php',
                success: function(response) {
                    // console.log('getPurchases: ', response);
                    const data = JSON.parse(response);
                    if (data && data.length) {
                        purchasedList = data;
                    }
                    const orderIds = data.map(order => `'${order.OrderId}'`).join(',');
                    getPurchasedOrders(orderIds);
                }
            });
        }

        function getPurchasedOrders(orderIds) {
            $.ajax({
                type: "POST",
                url: 'Services/GetPurchasedOrderListService.php',
                data: { orderIds },
                success: function(response) {
                    // console.log('getPurchasedOrders: ', response);
                    const data = JSON.parse(response);

                    if (data && data.length) {
                        purchasedList.forEach((transaction, index) => {
                            const orderList = data.filter(order => order.OrderId === transaction.OrderId);
                            const sum = getTotalPrice(orderList);
                            const orders = [{ itemNumber: index+1  }, ...orderList, { transaction, sumPrice: sum }];
                            purchasedOrderList.push(...orders);
                        });
                    }
                    console.log('purchasedOrderList: ', purchasedOrderList);
                    purchasedOrderList.forEach(order => {
                        const tr = $('<tr>');
                        tr.css('padding', '8px');
                        
                        if (order.itemNumber) {
                            tr.append(`<td colspan="2">Purchase: ${order.itemNumber}</td>`);
                            tr.append(`<td style="padding-bottom: 8px; text-align: right;"><button class="btn btn-primary">Refund</button></td>`);
                            tr.css('background-color', '#855731');
                        } else if (!order.transaction) {
                            tr.append(`<td><span style="margin-left: 10px;">${order.OrderName}</span></td>`);
                            tr.append(`<td>${order.Quantity}</td>`);
                            tr.append(`<td style="padding-bottom: 8px; text-align: right;">${order.TotalPrice}</td>`);
                        } else {
                            tr.append(`<td style="padding-bottom: 8px;">${order.transaction.TransactionType} ID: ${order.transaction.OrderId}</td>`);
                            tr.append(`<td >${order.transaction.DateCreated}</td>`);
                            tr.append(`<td style=" text-align: right;">Total Price: ${order.sumPrice}</td>`);
                        }

                        $('#purchaseList').append(tr);
                    });
                }
            });
        }

        function logout() {
            $.ajax({
                type: "GET",
                url: 'Services/User/LogoutService.php',
                success: function(response) {
                    console.log('logout: ', response);
                    window.location.href = response;
                }
            });
        }
    </script>
</body>
</html>
