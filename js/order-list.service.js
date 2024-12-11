function fetchOrders(showDelete = true, callback = null) {
    $.ajax({
        type: "POST",
        url: 'Services/GetOrderListService.php',
        success: function(response)
        {
            const orders = JSON.parse(response);
            console.log('fetchOrders: ', orders);

            if (orders) {
                orders.map((order, index) => {
                    $("#orderList").find('tbody')
                        .append($('<tr>')
                            .append($('<td style="width: 30%;">').text('Order ' + (index+1) + ': ' + order.OrderName))
                            .append($('<td style="width: 33%;text-align: right;" class="quantity">').text(order.Quantity + 'x'))
                            .append($('<td style="width: 33%;" class="price">').text('₱' + (parseFloat(order.TotalPrice) * order.Quantity).toFixed(2)))
                            .append($(`<td style="display: ${showDelete ? '' : 'none'}">`)
                                .append($('<p>')
                                    .append($('<img style="width: 45px; position: relative;top: 9px;" src="System Pictures/Delete_icon-removebg-preview.png">')))
                                .click(() => {
                                    deleteOrder(order.Id);
                                })
                            )
                        );
                });

                // const totalPriceList = orders.map(order => {
                //     return (parseFloat(order.TotalPrice) * order.Quantity).toFixed(2);
                // });
                
                // const sum = totalPriceList.reduce((partialSum, totalPrice) => partialSum + parseFloat(totalPrice), 0);
                const sum = getTotalPrice(orders);

                $("#sumPrice").text('Total Amount: ₱' + sum);

                // if ($('#pickupID').length && orders[0].OrderId) {
                //     $('#pickupID').text(orders[0].OrderId.toUpperCase()); // temporary
                // }

                if (callback) {
                    callback(orders);
                }
            }
        }
    });
}

function getTotalPrice(orders) {
    const totalPriceList = orders.map(order => {
        return (parseFloat(order.TotalPrice) * order.Quantity).toFixed(2);
    });
    
    const sum = totalPriceList.reduce((partialSum, totalPrice) => partialSum + parseFloat(totalPrice), 0);
    return sum.toFixed(2);
}