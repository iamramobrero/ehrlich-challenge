<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://kit.fontawesome.com/dade6b8446.js" crossorigin="anonymous"></script>
<script src="https://www.paypal.com/sdk/js?client-id=test&currency=USD"></script>
<script>
    $( document ).ready(function() {
        // setup toast
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        // setup csrf token for backend request validation
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        let cartID;
        let cartCount = 0;

        // initialize new cart
        initializeCart();

        // element event handlers
        $(document).on('click','.btn-add-to-cart',function(el){
            var productID = $(this).data('id');
            addCartItem(productID, $(this));
        });

        $(document).on('click','.btn-remove-from-cart',function(){
            var cartItemID = $(this).data('id');
            removeCartItem(cartItemID,$(this));
        });

        $(document).on('click','.btn-update-quantity',function(){
            var targetInput = $(this).data('target');
            targetInput = $(targetInput);
            updateCartItem(targetInput.data('id'), targetInput.val(), $(this));
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
            getTrendingItems();
        }

        function getCartItems(){
            $.get( "/cart?cartID="+getCartID(), function( data ) {
                cartItems = data.cart.items;
                $('#cart-summary, #checkout-items').html('');
                cartCount = 0;
                cartItems.forEach(item => {
                    cartCount += item.quantity;
                    var salePrice = item.price_sale ? `&nbsp;&nbsp;&nbsp;&nbsp;<span class="sale"><strike>$${item.price_sale}</strike></span>`:'';

                    // update cart sumamry
                    $('#cart-summary').append(`
                        <div class="cart-item row p-2">
                            <div class="col-4 text-center">
                                <img src="/images/${item.image}" title="${item.name}"/>
                            </div>
                            <div class="col-8 text-left">
                                <p class="m-0"><b>${item.name}</b></p>
                                <p class="m-0">Qty : ${item.quantity}</p>
                                <p class="m-0"><span>Price: <b>$${item.price}</b></span></p>
                                <button type="button" class="btn btn-sm btn-danger btn-remove-from-cart" data-id="${item.id}">Remove</button>
                            </div>
                        </div>
                    `)

                    // update checkout cart
                    $('#checkout-items').append(`
                        <li class="media p-2 mb-3 border-bottom">
                            <img class="mr-3" src="/images/${item.image}" alt="${item.name}"">
                            <div class="media-body">
                                <h5 class="mt-0 mb-1">${item.name}</h5>
                                <div class="form-group row m-0">
                                    <label class="col-sm-2 col-form-label p-0 m-0 align-self-center">Quantity</label>
                                    <div class="col-sm-10 col-lg-3 align-self-center ">
                                        <div class="input-group">
                                            <input type="number" id="cart-item-${item.id}" class="quantity form-control form-control-sm" data-id="${item.id}" step="1" min="1" value="${item.quantity}"/>
                                            <div class="input-group-append">
                                                <button class="btn btn-sm btn-secondary btn-update-quantity" type="button" data-target="#cart-item-${item.id}">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row m-0">
                                    <label class="col-sm-2 col-form-label p-0 m-0">Item Price:</label>
                                    <div class="col-sm-10 align-self-center"><b>$${item.price}</b></div>
                                </div>
                                <div class="form-group row m-0">
                                    <label class="col-sm-2 col-form-label p-0 m-0">Subtotal:</label>
                                    <div class="col-sm-10 align-self-center"><b>$${item.price * item.quantity}</b></div>
                                </div>
                                <button type="button" class="btn btn-sm btn-danger btn-remove-from-cart" data-id="${item.id}">Remove</button>
                            </div>
                        </li>
                    `)
                });

                if(cartItems.length){
                    // add checkout button on cart summary
                    $('#cart-summary').append(`
                        <div class="cart-item row p-2">
                            <div class="col-12 text-center cart-total">
                                <h3>$${data.cart.subtotal}</h3>
                            </div>
                        </div>
                        <div class="cart-item row p-2">
                            <div class="col-12 text-center">
                                <a href="/checkout" class="btn btn-block btn-checkout">CHECKOUT</a>
                            </div>
                        </div>
                    `);

                    // checkout summary

                    let discountSummary = '';
                    let checkOutOtal = data.cart.total;

                    if(data.cart.discount){
                        discountSummary = `<li class="list-group-item d-flex justify-content-between bg-light">
                                <div class="text-success">
                                    <h6 class="my-0">Promo code</h6>
                                    <small>EXAMPLECODE</small>
                                </div>
                                <span class="text-success">- USD ${data.cart.discount}</span>
                            </li>`;
                    }

                    $('#checkout-summary').html(`
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Order Summary</span>
                        </h4>
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">Cart Total</h6>
                                    <small class="text-muted">Cart Total Cost </small>
                                </div>
                                <span class="text-muted">USD ${data.cart.subtotal}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">Shipping Total</h6>
                                    <small class="text-muted">Cart Shipping Cost</small>
                                </div>
                                <span class="text-muted">USD ${data.cart.shipping}</span>
                            </li>
                            `+discountSummary+`
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total (USD)</span>
                                <strong>USD ${data.cart.total}</strong>
                            </li>
                        </ul>
                    `);


                    $('#paypal-button-container').removeClass('d-none');

                } else {
                    $('#checkout-items').append(`Your cart is empty! <a href="/">Click here to browse our shop!</a>`)
                }

                $('#cart-count').html(cartCount);
            });
        }

        function addCartItem(productID, el){
            el.prop('disabled', true);
            $.post( '/cart-items', {
                'cartID' : getCartID(),
                'productID' : productID,
            } ,function( response ) {
                el.prop('disabled', false);
                Toast.fire({
                    icon: 'success',
                    title: 'The item has been added to your cart'
                })
                getCartItems();
            });
        }

        function updateCartItem(cartItemID, quantity, el){
            el.prop('disabled', true);
            $.ajax({
                url: '/cart-items/'+cartItemID,
                type: 'PUT',
                data : {
                    quantity:quantity
                },
                success: function(response) {
                    el.prop('disabled', false);
                    getCartItems();
                    Toast.fire({
                        icon: 'success',
                        title: 'The item in your cart has been updated!'
                    })
                }
            });
        }

        function removeCartItem(cartItemID, el){
            el.prop('disabled', true);
            if(cartItemID){
                $.ajax({
                    url: '/cart-items/'+cartItemID,
                    type: 'DELETE',
                    success: function(response) {
                        el.prop('disabled', false);
                        getCartItems();
                        Toast.fire({
                            icon: 'success',
                            title: 'The item has been removed from your cart'
                        })
                    }
                });
            }
        }

        function getTrendingItems(){
            $.get( "/data/trending-items", function( data ) {
                $('.trending-container').html('');
                data.forEach(item => {
                    $('.trending-container').append(`
                        <div class="item">
                            <img src="/images/${item[1]}" title="${item[0]}"/>
                            <p class="d-block mx-auto">${item[0]}</p>
                        </div>
                    `)
                    console.log(item);
                });
            });
        }

        function getRecentPurchases(){

            $.get( "/data/recent-purchases", function( data ) {

                // reset recent purchases container
                $('.recently-bought-container').html('');
                data.forEach(item => {
                    var salePrice = item.price_sale ? `<span class="sale">$${item.price_sale}</span>`:'';
                    $('.recently-bought-container').append(`
                        <div class="item text-left">
                            <img src="/images/${item.image}" title="${item.name}"/>
                            <p class="title">${item.name}</p>
                            <p class="prices">
                                ${salePrice}
                                <span class="regular">$${item.price_regular}</span>
                            </p>
                            <button type="button" class="btn-add-to-cart" data-id="${item.id}">Add to Cart</button>
                        </div>
                    `)
                    console.log(item);
                });
            });
        }

    });
    paypal.Buttons({
        // Order is created on the server and the order id is returned
        createOrder() {
          return fetch("/checkout", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            // use the "body" param to optionally pass additional order information
            // like product skus and quantities
            body: JSON.stringify({
              cart: [
                {
                  sku: "YOUR_PRODUCT_STOCK_KEEPING_UNIT",
                  quantity: "YOUR_PRODUCT_QUANTITY",
                },
              ],
            }),
          })
          .then((response) => response.json())
          .then((order) => order.id);
        },
        // Finalize the transaction on the server after payer approval
        onApprove(data) {
          return fetch("/my-server/capture-paypal-order", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              orderID: data.orderID
            })
          })
          .then((response) => response.json())
          .then((orderData) => {
            // Successful capture! For dev/demo purposes:
            console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
            const transaction = orderData.purchase_units[0].payments.captures[0];
            alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
            // When ready to go live, remove the alert and show a success message within this page. For example:
            // const element = document.getElementById('paypal-button-container');
            // element.innerHTML = '<h3>Thank you for your payment!</h3>';
            // Or go to another URL:  window.location.href = 'thank_you.html';
          });
        }
      }).render('#paypal-button-container');
</script>
