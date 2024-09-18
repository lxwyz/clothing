@extends('user.layouts.master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container-fluid">
    <br>
    <a href="{{route('user#home')}}" class="nav-item nav-link text-dark">
       <button class="btn btn-sm btn-primary">Home</button>
    </a>
    <br>
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                <thead class="thead-dark">
                    <tr>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @foreach ($cartList as $c)
                    <tr>
                        <td class="align-middle">
                            <img src="img/{{asset('storage/'.$c->product_image)}}" alt="" style="width: 50px;">
                            {{$c->product_name}}
                            <input type="hidden" class="productId" value="{{$c->product_id}}">
                            <input type="hidden" class="userId" value="{{$c->user_id}}">
                        </td>
                        <td class="align-middle" data-price="{{$c->product_price}}">{{$c->product_price}}</td>
                        <td class="align-middle">
                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-primary btn-minus">
                                    <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center qty-input" value="{{$c->Qty}}">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-primary btn-plus">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle total-price">{{$c->product_price * $c->Qty}} Kyats</td>
                        <td class="align-middle">
                            <button class="btn btn-sm btn-danger" id="btnRemove" data-id="{{$c->product_id}}">
                                <i class="fa fa-times"></i>
                            </button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="border-bottom pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Subtotal</h6>
                        <h6 id="subtotal">{{$totalPrice}} Kyats</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Shipping</h6>
                        <h6 class="font-weight-medium">3000 Kyats</h6>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5 id="total">{{$totalPrice + 3000}}</h5>
                    </div>
                    <button class="btn btn-block btn-primary font-weight-bold my-3 py-3" id="orderBtn">Proceed To Checkout</button> <br>
                    <button class="btn btn-block btn-danger font-weight-bold my-3 py-3" id="clearBtn">Clear Cart</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scriptSource')

<script>
$(document).ready(function () {
    // Handling the Plus Button
    $('.btn-plus').click(function () {
        var row = $(this).closest('tr'); // Find the closest table row
        var qtyInput = row.find('.qty-input'); // Target the quantity input in this row
        var quantity = parseInt(qtyInput.val());  // Get the current quantity
        qtyInput.val(quantity + 1);  // Increment and update the value

        // Update the total price for the row
        updateRowTotal(row);
    });

    // Handling the Minus Button
    $('.btn-minus').click(function () {
        var row = $(this).closest('tr'); // Find the closest table row
        var qtyInput = row.find('.qty-input'); // Target the quantity input in this row
        var quantity = parseInt(qtyInput.val());  // Get the current quantity
        if (quantity > 1) {
            qtyInput.val(quantity - 1);  // Decrement and update the value
        }

        // Update the total price for the row
        updateRowTotal(row);
    });

    // // Handle Remove Button
    // $('.btn-danger').click(function () {
    //     var row = $(this).closest('tr'); // Find the closest table row
    //     row.remove(); // Remove the row from the table

    //     // Update the cart summary after removing the item
    //     updateCartSummary();
    // });

    // Handling the Proceed to Checkout button click
    $('#orderBtn').click(function(){
        var orderList = [];

        $('#dataTable tbody tr').each(function(index, row){
            var randomCode = Math.floor(Math.random() * 10000001); // Generate random order code

            // Prepare each order item data
            var orderItem = {
                'user_id': $(row).find('.userId').val(),
                'product_id': $(row).find('.productId').val(),
                'Qty': $(row).find('.qty-input').val(),
                'total_amount': parseFloat($(row).find('.total-price').text().replace(' Kyats', '')),
                'order_code': 'POS' + randomCode
            };

            orderList.push(orderItem); // Add the order item to the orderList array
        });

        // Ensure the orderList array has data before making the AJAX call
        if (orderList.length > 0) {
            // AJAX POST Request to submit order data
            $.ajax({
                type: 'get',
                url: 'http://localhost:8000/user/ajax/order',  // Ensure this matches your Laravel route
                data: { orders: orderList }, // Send the orderList data
                dataType: 'json',
                success: function(response){
                    // Handle success response
                    // console.log(response);
                    // alert('Order placed successfully.');
                    if(response.status == 'true'){
                        window.location.href = 'http://localhost:8000/user/home';
                    }
                },
            });
        } else {
            alert("No items in the cart!");
        }
    });
    //function to clear cart

    $('#clearBtn').click(function() {
        $.ajax({
            type: 'GET',
            url: '{{route('ajax#clearCart')}}',  // Ensure this matches your Laravel route
            dataType: 'json',
            success: function(response) {
                if(response.status == 'true') {  // Assuming the server returns a status of 'true'
                    $('#dataTable tbody tr').remove();  // Clear cart items in the UI
                    $('#subtotal').text('0 Kyats');  // Reset subtotal
                    $('#total').text('3000 Kyats');  // Assuming shipping cost remains

                    alert('Cart cleared successfully.');  // Optional: Show a success message
                } else {
                    alert('Failed to clear the cart.');  // In case of any failure
                }
            },
            error: function() {
                alert('Error clearing the cart.');  // In case of AJAX error
            }
        });
    });
    $('.btn-danger').click(function(){
        var button = $(this);
        var row = button.closest('tr'); // Fixed typo
        var productId = button.data('id'); // Correctly get the product ID

        $.ajax({
            type: 'GET',
            url: 'http://localhost:8000/user/ajax/remove/cart',  // Ensure this matches your Laravel route
            data: { product_id: productId }, // Send the product ID to be removed
            dataType: 'json',
            success: function(response){
                if(response.status == 'true') {  // Assuming the server returns a status of 'true'
                    row.remove();  // Remove the row from the table
                    updateCartSummary();  // Update the cart summary
                    alert('Item removed from cart successfully.');  // Optional: Show a success message
                } else {
                    alert('Failed to remove the item from the cart.');  // In case of any failure
                }
            },
            error: function() {
                alert('Error removing the item from the cart.');  // In case of AJAX error
            }
        });
        $.ajaxSetup({
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

});

});





function updateRowTotal(row) {
    var price = parseFloat(row.find('td[data-price]').data('price')); // Get the product price
    var qty = parseInt(row.find('.qty-input').val()); // Get the updated quantity
    var totalPrice = (price * qty).toFixed(2); // Calculate total price
    row.find('.total-price').text(totalPrice + ' Kyats'); // Update the total price for the row

    // Update the overall subtotal and total in the cart summary
    updateCartSummary();
}

// Function to update the cart summary (subtotal and total)
function updateCartSummary() {
    var subtotal = 0;
    $('.total-price').each(function () {
        subtotal += parseFloat($(this).text().replace(' Kyats', '')); // Sum up each row's total
    });
    $('#subtotal').text(subtotal.toFixed(2) + ' Kyats'); // Update subtotal
    $('#total').text((subtotal + 3000).toFixed(2) + ' Kyats'); // Add shipping fee and update total
}
</script>

@endsection

