<!doctype html>
<html lang="en">
    @include('head')
    <body>
    <div id="container">
    @include('header')
    <div id="content">
        <div class="container p-5">
            <h1>Checkout</h1>
            <hr>
            <div class="row">

                <div class="col-12 col-lg-8">
                    <h4>Order Items</h4>
                    <ul class="list-unstyled" id="checkout-items"></ul>
                </div>

                <div class="col-12 col-lg-4">
                    <div id="checkout-summary">

                    </div>
                    <div id="paypal-button-container" class="d-none"></div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
    </div>
    @include('scripts')


  </body>
</html>
