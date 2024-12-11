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
<script src="js/jquery-3.7.1.min.js"></script>
<script src="js/order-list.service.js"></script>
<script src="js/global-data.js"></script>

<a href="homepage.php">
    <img src="System Pictures/BSIT-2F_Logo_real-removebg-preview.png" alt="Logo" class="logo">
</a>

<!-- Customer Service Header -->
<div class="header-text">
    Pick Order
</div>

<!-- Profile Icon -->
<a href="UserProfile.php"> 
    <img src="System Pictures/ako mani oh huh.jpg" alt="Profile" class="profile-icon">
</a>

<!-- New Background Container -->
<div class="new-bg-container">
    <div class="row">
        <!-- Pickup Choice as a Button -->
        <button style="opacity: 0;" class="col choice"></button>
        <!-- <button class="col choice" onclick="generatePickupID()">
            Generate Delivery ID
        </button> -->
    </div>
    
    <!-- Display Pickup ID -->
    <div class="pickup-id" id="pickupIDContainer">
    <hr class="pickup-line">
        Pickup ID: <span id="pickupID"></span>
    </div>
    <div class="order-details">
        <table id="orderList" style="width: 100%;">
            <tr>
                <th style="width: 33%;">Product</th>
                <th style="width: 33%;text-align: right;" class="quantity">Quantity</th>
                <th style="width: 33%;" class="price">Price</th>
                <th></th>
            </tr>
        </table>
        <!-- <div class="order-item">
            <span>Order 1: Brew Coffee</span>
            <span class="price">$80.00</span>
        </div>
        <div class="order-item">
            <span>Order 2: Muffins 4x</span>
            <span class="price">$150.00</span>
        </div> -->
        <hr class="pickup-line">
        <div class="date-total">
        <span id="currentDate"></span> <!-- Display current date -->
        <span id="sumPrice" class="total-price"></span> <!-- Display total price -->
    </div>
        <!-- Estimated Time to Pickup Section -->
        <div class="estimated-time">
            Estimated Time to Pickup: <span id="pickupTime">8:00 am</span>
        </div>

        <!-- Customer Address Section -->
    <div class="customer-address">
        <label for="addressType">Store Address: Ninong Ry !!</label>        
        <!-- <textarea id="newAddress" name="newAddress" class="form-control" placeholder="Enter your new address" style="margin-top: 10px;">
            Ninong Ry Fudz
        </textarea> -->
    </div>
        
    </div>
    
    <!-- Payment Section moved to the left side -->
    <!-- <div class="payment-section">
        <label for="paymentOptions" class="payment-label">Payment:</label>
        <select id="paymentOptions" name="paymentOptions" class="payment-select">
            <option value="">Select</option>
            <option value="gcash">Gcash</option>
            <option value="creditCard">Credit Card</option>
            <option value="cash">Cod</option>
        </select>
    </div> -->
    <!-- Pickup Now Button -->
<!-- <a href="MenuList.php" class="pickup-now-btn">Order Now</a> -->
 <p class="pickup-now-btn" onclick="orderNow()">Order Now</p>
</div>

<!-- JavaScript for Pickup ID -->
<script>
    var transactionId = null;
    var orderId = null;

    $(document).ready(function() {
        fetchOrders(false, (orders) => {
            console.log('orders: ', orders);
            if (orders && orders.length) {
                orderId = orders[0].OrderId;
                // addTransaction(orderId);

                getActiveTransaction();
            }
        });
        
        getDeliveryAddressList();
    });

    function addTransaction(orderId, callback) {
        // const orderId = 1; // Get the order ID
        const transactionType = 1; // Get the transaction type
        const userId = 1; // Get the user ID

        $.ajax({
            type: 'POST',
            url: 'Services/AddTransactionService.php',
            data: {
                orderId: orderId,
                transactionType: "Pickup",
                userId: userId
            },
            success: function(response) {
                console.log('addTransaction: ', response);
                const data = JSON.parse(response);
                if (data.status === 'success') {
                    callback(data);
                }
            }
        });
    }

    function getActiveTransaction() {
        $.ajax({
            type: 'GET',
            url: 'Services/GetActiveTransactionService.php',
            success: function(response) {
                // console.log('getActiveTransaction: ', response);
                const data = JSON.parse(response);

                if (data && data.DeliveryId) {
                    $('#pickupID').text(data.DeliveryId.toUpperCase());
                    displayCurrentDate(new Date(data.DateCreated));
                    // getActiveDeliveryAddress(data.DeliveryAddressId);
                    transactionId = data.Id;
                    console.log('transactionId: ', transactionId);
                } else {
                    // getActiveDeliveryAddress(null);
                    // alert('No active transaction found');
                    addTransaction(orderId, () => {
                        getActiveTransaction();
                    });
                }
            }
        });
    }

    function getDeliveryAddressList(deliveryAddressId) {
        $.ajax({
            type: 'GET',
            url: 'Services/GetDeliveryAddressListService.php',
            success: function(response) {
                
                const deliveryAddressList = JSON.parse(response);
                
                if (deliveryAddressList) {
                    console.log('DeliveryAddress count: ', deliveryAddressList.length);

                    deliveryAddressList.forEach((deliveryAddress) => {
                        $('#addressType')
                            .append($('<option>', {
                                value: deliveryAddress.Id,
                                text: deliveryAddress.Address
                            }));
                    });
                }

                $('#addressType')
                    .append($('<option>', {
                        value: "0",
                        text: "New Address"
                    }));
            }
        });
    }

    function getActiveDeliveryAddress(deliveryAddressId) {
        console.log('deliveryAddressId', deliveryAddressId);
        $.ajax({
            type: 'POST',
            url: 'Services/GetDeliveryAddressService.php',
            data: {
                deliveryAddressId: deliveryAddressId
            },
            success: function(response) {
                const data = JSON.parse(response);
                console.log('ActiveDeliveryAddress: ', data);
                
                // if (data && data.status == 'success') {
                //     $('#addressType').val(data.Id);
                // }

                // toggleNewAddressInput();
            }
        });
    }

    function addDeliveryAddress(callback) {
        const address = '';
        const deliveryAddressId = 0;
        console.log('deliveryAddressId', deliveryAddressId);

        // if (!deliveryAddressId && !address) {
        //     alert('Please select or add new delivery address');
        //     return;
        // } else if (deliveryAddressId == '0' && !address) {
        //     alert('Please enter your new delivery address');
        //     return;
        // }

        if (deliveryAddressId == '0') {
            $.ajax({
                type: 'POST',
                url: 'Services/AddDeliveryAddressService.php',
                data: {
                    address: address
                },
                success: function(response) {
                    console.log('addDeliveryAddress: ', response);
                    const data = JSON.parse(response);
                    callback(data);
                }
            });
        } else {
            callback({Id: deliveryAddressId});
        }
    }

    function updateTransaction(deliveryAddressId) {
        // const addressType = $('#addressType').value;
        // const address = $('#newAddress').value;
        const paymentMethod = 'Pickup';

        // if (!paymentMethod) {
        //     alert('Please select a payment method');
        //     return;
        // }
        console.log('transactionId', transactionId);

        $.ajax({
            type: 'POST',
            url: 'Services/UpdateTransactionService.php',
            data: {
                transactionId: transactionId,
                deliveryAddressId: deliveryAddressId,
                paymentMethod: paymentMethod,
                transactionStatus: 'PickingUp',
                orderId: orderId
            },
            success: function(response) {
                console.log('updateTransaction: ', response);
                const data = JSON.parse(response);

                if (data.status === 'success') {
                    // confirm('Order placed successfully');
                     window.location.href = "MenuList%20(1).php";
                }
            }
        });
    }

    function orderNow() {
        addDeliveryAddress((deliveryAddress) => {
            console.log('orderNow: ', deliveryAddress);
            const deliveryAddressId = Number(deliveryAddress.Id);
            if (deliveryAddressId) {
                updateTransaction(deliveryAddressId);
            }
        });
    }

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
    function displayCurrentDate(today) {
    // const today = new Date();
    const year = today.getFullYear();
    const month = (today.getMonth() + 1).toString().padStart(2, '0'); // Get month and ensure two digits
    const day = today.getDate().toString().padStart(2, '0'); // Get day and ensure two digits
    const currentDate = `${year}-${month}-${day}`; // Format as YYYY-MM-DD
    document.getElementById('currentDate').textContent = 'Date: ' + currentDate;
}

function toggleNewAddressInput() {
        const addressType = document.getElementById('addressType').value;
        const newAddress = document.getElementById('newAddress');
        console.log('addressType', addressType);
        if (!addressType || addressType == 'new' || addressType == '0') {
            newAddress.style.display = 'block';
        } else {
            newAddress.style.display = 'none';
        }
    }
// Call the function to display the current date when the page loads
// window.onload = function() {
//     // displayCurrentDate();
// };
</script>
</body>
</html>
