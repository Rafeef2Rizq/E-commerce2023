<x-front-layout title="Cart">

   <!-- Start Breadcrumbs -->
   <x-slot name="breadcrumbs">
   <div class="breadcrumbs">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="breadcrumbs-content">
                    <h1 class="page-title">Cart</h1>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <ul class="breadcrumb-nav">
                    <li><a href="{{route('home')}}"><i class="lni lni-home"></i> Home</a></li>
                    <li><a href="{{route('products.index')}}">Shop</a></li>
                    <li>Cart</li>
                </ul>
            </div>
        </div>
    </div>
</div>
</x-slot>
<!-- End Breadcrumbs -->

<!-- Shopping Cart -->
<div class="shopping-cart section">
    <div class="container">
        <div class="cart-list-head">
            <!-- Cart List Title -->
            <div class="cart-list-title">
                <div class="row">
                    <div class="col-lg-1 col-md-1 col-12">

                    </div>
                    <div class="col-lg-4 col-md-3 col-12">
                        <p>Product Name</p>
                    </div>
                    <div class="col-lg-2 col-md-2 col-12">
                        <p>Quantity</p>
                    </div>
                    <div class="col-lg-2 col-md-2 col-12">
                        <p>Subtotal</p>
                    </div>
                    <div class="col-lg-2 col-md-2 col-12">
                        <p>Discount</p>
                    </div>
                    <div class="col-lg-1 col-md-2 col-12">
                        <p>Remove</p>
                    </div>
                </div>
            </div>
            <!-- End Cart List Title -->
            <!-- Cart Single List list -->
            @foreach ($cart->get() as $item)
                
       
            <div class="cart-single-list" id="{{$item->id}}">
                <div class="row align-items-center">
                    <div class="col-lg-1 col-md-1 col-12">
                        <a href="{{route('products.show',$item->product->slug)}}">
                            <img src="{{$item->product->imge_url}}" alt="#"></a>
                    </div>
                    <div class="col-lg-4 col-md-3 col-12">
                        <h5 class="product-name">
                            <a href="{{route('products.show',$item->product->slug)}}">
                                {{$item->product->name}}</a></h5>
                        <p class="product-des">
                            <span><em>Type:</em> Mirrorless</span>
                            <span><em>Color:</em> Black</span>
                        </p>
                    </div>
                    <div class="col-lg-2 col-md-2 col-12">
                        <div class="count-input">
                            <input type="number" min="1" class="form-control item-quantity" 
                            data-id="{{$item->id}}" 
                            value="{{$item->quantity}}">
                             
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-12">
                        <p>{{Currency::format($item->quantity * $item->price)}}</p>
                    </div>
                    <div class="col-lg-2 col-md-2 col-12">
                        <p>{{Currency::format(0)}}</p>
                    </div>
                    <div class="col-lg-1 col-md-2 col-12">
                        <a class="remove-item" data-id="{{$item->id}}" href="javascript:void(0)"><i class="lni lni-close"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- End Single List list -->
          
        </div>
        <div class="row">
            <div class="col-12">
                <!-- Total Amount -->
                <div class="total-amount">
                    <div class="row">
                        <div class="col-lg-8 col-md-6 col-12">
                            <div class="left">
                                <div class="coupon">
                                    <form action="#" target="_blank">
                                        <input name="Coupon" placeholder="Enter Your Coupon">
                                        <div class="button">
                                            <button class="btn">Apply Coupon</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="right">
                                <ul>
                                    <li>Cart Subtotal<span>{{Currency::format($cart->total())}}</span></li>
                                    <li>Shipping<span>Free</span></li>
                                    <li>You Save<span>$29.00</span></li>
                                    <li class="last">You Pay<span>$2531.00</span></li>
                                </ul>
                                <div class="button">
                                    <a href="{{route('checkout')}}" class="btn">Checkout</a>
                                    <a href="product-grids.html" class="btn btn-alt">Continue shopping</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ End Total Amount -->
            </div>
        </div>
    </div>
</div>
<!--/ End Shopping Cart -->
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    const csrf_token = "{{ csrf_token() }}";

    (function($) {
        $('.item-quantity').on('change', function(e) {
            const itemId = $(this).data('id'); // Assuming data-id contains the item ID
            const url = "{{ route('cart.update', ['cart' => ':itemId']) }}"; // Use ':itemId' as a placeholder

            const finalUrl = url.replace(':itemId', itemId);

            $.ajax({
                url: finalUrl,
                method: 'put',
                data: {
                    quantity: $(this).val(),
                },
                headers: {
                    'X-CSRF-TOKEN': csrf_token,
                },
                success: function(response) {
                    alert('Quantity updated!');
                },
                error: function(xhr, status, error) {
                    alert('Error in update!');
                }
            });
        });
        //remove item
        $('.remove-item').on('click', function(e) {
    e.preventDefault(); // Prevent the default link behavior

    const itemId = $(this).data('id'); // Assuming data-id contains the item ID
    const url = "{{ route('cart.destroy', ['cart' => ':itemId']) }}"; // Use ':itemId' as a placeholder

    const finalUrl = url.replace(':itemId', itemId);

    $.ajax({
        url: finalUrl,
        method: 'delete',
        headers: {
            'X-CSRF-TOKEN': csrf_token,
        },
        success: function(response) {
            // Assuming 'id' is the variable for the item's ID
            $('#' + itemId).remove(); // Remove the item with the matching ID
            alert('Item deleted!');
        },
        error: function(xhr, status, error) {
            alert('Error in delete!');
        }
    });
});

    })(jQuery);
</script>

@endpush


</x-front-layout>