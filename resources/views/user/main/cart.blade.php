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
                            <img src="{{asset('storage/'.$c->product_image)}}" alt="" style="width: 50px;">
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Your other button handling code...

    // Clear Cart
    $(document).on('click', '#clearBtn', function() {
        $.ajax({
            type: 'GET',
            url: '{{route('ajax#clearCart')}}',
            dataType: 'json',
            success: function(response) {
                if(response.status == 'true') {
                    $('#dataTable tbody tr').remove();
                    $('#subtotal').text('0 Kyats');
                    $('#total').text('3000 Kyats');
                    alert('Cart cleared successfully.');
                } else {
                    alert('Failed to clear the cart.');
                }
            },
            error: function() {
                alert('Error clearing the cart.');
            }
        });
    });

    // Remove Item
    $(document).on('click', '.btn-danger', function() {
        var button = $(this);
        var row = button.closest('tr');
        var productId = button.data('id');

        $.ajax({
            type: 'GET',
            url: '{{ route('ajax#removeCart') }}',
            data: { product_id: productId },
            dataType: 'json',
            success: function(response) {
                if(response.status == 'true') {
                    row.remove();
                    updateCartSummary();
                    alert('Item removed from cart successfully.');
                } else {
                    alert('Failed to remove the item from the cart.');
                }
            },
            error: function() {
                alert('Error removing the item from the cart.');
            }
        });
    });

    // Proceed to Checkout
    $(document).on('click', '#orderBtn', function() {
        var orderList = [];
        $('#dataTable tbody tr').each(function(index, row) {
            var randomCode = Math.floor(Math.random() * 10000001);
            var orderItem = {
                'user_id': $(row).find('.userId').val(),
                'product_id': $(row).find('.productId').val(),
                'Qty': $(row).find('.qty-input').val(),
                'total_amount': parseFloat($(row).find('.total-price').text().replace(' Kyats', '')),
                'order_code': 'POS' + randomCode,
            };
            orderList.push(orderItem);
        });

        if (orderList.length > 0) {
            $.ajax({
                type: 'POST',
                url: '{{route('ajax#order')}}',
                data: { orders: orderList },
                dataType: 'json',
                success: function(response) {
                    if(response.status == 'true') {
                        location.reload();
                    }
                },
                error: function(jqXHR) {
                    console.error('Error:', jqXHR.status, jqXHR.statusText);
                },
            });
        } else {
            alert("No items in the cart!");
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

