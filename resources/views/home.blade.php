<!doctype html>
<html lang="en">
    @include('head')
    <body>
    <div id="container">
    @include('header')
    <div id="content">
        <div id="banner">
            <a href="#">
                <img src="/images/hero-1.png">
            </a>
        </div>
        <div id="site-wide-deals">
            <div id="site-wide-deals-container" class="d-flex justify-content-between align-items-center mx-auto">
                <div>
                    <div>
                        <span class="discount">$5</span>
                        <span class="off">OFF</span>
                    </div>
                    <p>on orders above $50</p>
                </div>
                <div>
                    <div>
                        <span class="discount">$15</span>
                        <span class="off">OFF</span>
                    </div>
                    <p>on orders above $75</p>
                </div>
                <div>
                    <div>
                        <span class="discount">$20</span>
                        <span class="off">OFF</span>
                    </div>
                    <p>on orders above $150</p>
                </div>
                <div>
                    <div>
                        <span class="discount">$30</span>
                        <span class="off">OFF</span>
                    </div>
                    <p>on orders above $200</p>
                </div>
                <div>
                    <a class="site-wide-deals" href="#">check out all site-wide deals</a>
                </div>
            </div>
        </div>
        <div id="vip-exclusive">
            <div class="vip-exclusive-wrapper mx-auto">
                <div class="vip-exclusive-content d-flex justify-content-between align-items-center mx-auto">
                    <div class="content-1">black friday exclusive</div>
                    <div class="content-2">free shipping on all orders for VIP 2 and up!</div>
                    <div class="content-3 text-center"><a href="#">SHOP NOW</a></div>
                </div>
            </div>
        </div>
        <div id="trending">
            <div class="heading">now trending</div>
            <p>See what everyone’s wearing right now</p>
            <div class="trending-container d-flex justify-content-between flex-wrap"></div>
            <div class="trending-hashtags-container">
                <ul class="trending-hashtags d-flex justify-content-between mx-auto">
                    <li><a href="#">#Thanksgiving</a></li>
                    <li><a href="#">#NewYears</a></li>
                    <li><a href="#">#Knitted</a></li>
                    <li><a href="#">#Pajamas</a></li>
                    <li><a href="#">#WFH</a></li>
                    <li><a href="#">#FallFashion</a></li>
                </ul>
            </div>
        </div>
        <div id="new-arrivals">
            <div class="new-arrivals-container d-flex justify-content-end flex-wrap">
                <div class="details align-self-center">
                    <h2>NEW ARRIVALS</h2>
                    <p>Get ready for the holidays with us!</p>
                    <a href="#" class="shop-now">SHOP NOW</a>
                </div>
            </div>
        </div>
        <div id="recently-bought">
            <div class="heading text-center">recently bought</div>
            <div class="recently-bought-container d-flex justify-content-between flex-wrap"></div>
        </div>
        <div id="insta" class="text-center">
            <div class="heading">Your Next Inspo</div>
            <p class="subheading">Checkout who’s wearing what by using #THREADEDInspo on Instagram</p>
            <div class="insta-container d-flex justify-content-between align-items-center  flex-wrap">
                <div class="item"><img src="/images/insta-1.png"></div>
                <div class="item"><img src="/images/insta-2.png"></div>
                <div class="item"><img src="/images/insta-3.png"></div>
                <div class="item"><img src="/images/insta-4.png"></div>
                <div class="item"><img src="/images/insta-5.png"></div>
            </div>
            <a href="#" class="btn-view-all">VIEW ALL POST</a>
        </div>
    </div>
    @include('footer')
    </div>
    @include('scripts')
  </body>
</html>
