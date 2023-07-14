<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <h1>Hello, world!</h1>

    <div id="recent-purchases" class="row">
    </div>
    <hr>
    <div id="cart-summary">
    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script>
        $( document ).ready(function() {

            // setup csrf token for backend request validation
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            let cartID;

            // initialize new cart
            initializeCart();

            // element event handlers
            $(document).on('click','.btn-add-to-cart',function(){
                var productID = $(this).data('id');
                addCartItem(productID);
            });

            $(document).on('click','.btn-remove-from-cart',function(){
                var cartItemID = $(this).data('id');
                removeCartItem(cartItemID);
            });


            // methods
            function getCartID(){
                return localStorage.getItem('cartID');
            }

            function initializeCart(){
                cartID = getCartID();

                // if there is no cartID, initialize
                if(!cartID){
                    $.post( "{{ route("cart.store") }}", function( data ) {
                        localStorage.setItem('cartID', data);
                    });
                }

                getCartItems();
                getRecentPurchases();
            }

            function getCartItems(){
                $.get( "/cart?cartID="+getCartID(), function( data ) {
                    $('#cart-summary').html('');
                    data.forEach(item => {
                        $('#cart-summary').append(`
                            <div class="cart-item">
                                <img src="/images/${item.image}" title="${item.name}"/>
                                <p>${item.name} x ${item.quantity}</p>
                                <p><span>${item.price_sale}</span><span><strike>${item.price_regular}</strike></span></p>
                                <button type="button" class="btn-remove-from-cart" data-id="${item.id}">Remove</>
                            </div>
                        `)
                    });
                });
            }

            function addCartItem(productID){
                $.post( '/cart-items', {
                    'cartID' : getCartID(),
                    'productID' : productID,
                } ,function( response ) {
                    getCartItems();
                });
            }

            function removeCartItem(cartItemID){
                if(cartItemID){
                    $.ajax({
                        url: '/cart-items/'+cartItemID,
                        type: 'DELETE',
                        success: function(response) {
                            getCartItems();
                        }
                    });
                }
            }

            function updateCartItemQuantity(cartItemID){

            }




            // function getTrendingItems(){
            //     $.get( "/data/trending-items", function( data ) {
            //         console.log(data);
            //     });
            // }

            function getRecentPurchases(){
                $.get( "/data/recent-purchases", function( data ) {
                    // reset recent purchases container
                    $('#recent-purchases').html('');
                    data.forEach(item => {
                        $('#recent-purchases').append(`
                            <div class="col col-2 md-recent-item">
                                <img src="/images/${item.image}" title="${item.name}"/>
                                <p>${item.name}</p>
                                <button type="button" class="btn-add-to-cart" data-id="${item.id}">Add to Cart</>
                            </div>
                        `)
                        console.log(item);
                    });
                });
            }

        });
    </script>
  </body>
</html>
