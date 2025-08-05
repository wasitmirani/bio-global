
<div class="instagram-wrapp">
    <div>
        <h3 class="custommenu-title-blog">
            <!--<i class="flaticon-instagram" aria-hidden="true"></i>-->
            Our Team
        </h3>
        <div class="stelina-instagram">
            <div class="instagram owl-slick equal-container" data-slick='{"autoplay":false, "autoplaySpeed":1000, "arrows":false, "dots":false, "infinite":true, "speed":800, "rows":1}' data-responsive='[{"breakpoint":"2000","settings":{"slidesToShow":5}},{"breakpoint":"1200","settings":{"slidesToShow":4}},{"breakpoint":"992","settings":{"slidesToShow":3}},{"breakpoint":"768","settings":{"slidesToShow":2}},{"breakpoint":"481","settings":{"slidesToShow":2}}]'>
                <div class="item-instagram">
                    <a href="javascript:;">
                        <img src="{{asset('/frontend/assets/images/team1.jpg')}}" alt="img">
                    </a>
                    <span class="text">
                        <i class="icon flaticon-instagram" aria-hidden="true"></i>
			        </span>
                </div>
                <div class="item-instagram">
                    <a href="javascript:;">
                        <img src="{{asset('/frontend/assets/images/team2.jpg')}}" alt="img">
                    </a>
                    <span class="text">
                        <i class="icon flaticon-instagram" aria-hidden="true"></i>
			        </span>
                </div>
                <div class="item-instagram">
                    <a href="javascript:;">
                        <img src="{{asset('/frontend/assets/images/team3.jpg')}}" alt="img">
                    </a>
                    <span class="text">
                        <i class="icon flaticon-instagram" aria-hidden="true"></i>
			        </span>
                </div>
                
            </div>
        </div>
    </div>
</div>
<footer class="footer style7">
    <div class="container">
        <div class="container-wapper">
            <div class="row">
                <div class="box-footer col-xs-12 col-sm-4 col-md-4 col-lg-4 hidden-sm hidden-md hidden-lg">
                    <div class="stelina-newsletter style1">
                        <div class="newsletter-head">
                            <h3 class="title">Newsletter</h3>
                        </div>
                        <div class="newsletter-form-wrap">
                            <div class="list">
                                Sign up for our free video course and <br> urban garden inspiration
                            </div>
                            <input type="email" class="input-text email email-newsletter" placeholder="Your email letter">
                            <button class="button btn-submit submit-newsletter">SUBSCRIBE</button>
                        </div>
                    </div>
                </div>
                <div class="box-footer col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="stelina-custommenu default">
                        <h2 class="widgettitle">Quick Menu</h2>
                        <ul class="menu">
                            <li class="menu-item">
                                <a href="#">New arrivals</a>
                            </li>
                            <li class="menu-item">
                                <a href="#">Life style</a>
                            </li>
                            <li class="menu-item">
                                <a href="#">Accents</a>
                            </li>
                            <li class="menu-item">
                                <a href="#">Tables</a>
                            </li>
                            <li class="menu-item">
                                <a href="#">Dining</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="box-footer col-xs-12 col-sm-4 col-md-4 col-lg-4 hidden-xs">
                    <div class="stelina-newsletter style1">
                        <div class="newsletter-head">
                            <h3 class="title">Newsletter</h3>
                        </div>
                        <div class="newsletter-form-wrap">
                            <div class="list">
                                Sign up to unlock exclusive scent tips, behind-the-scenes content, and fragrance inspiration.
                            </div>
                            <input type="email" class="input-text email email-newsletter" placeholder="Your email letter">
                            <button class="button btn-submit submit-newsletter">SUBSCRIBE</button>
                        </div>
                    </div>
                </div>
                <div class="box-footer col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="stelina-custommenu default">
                        <h2 class="widgettitle">Information</h2>
                        <ul class="menu">
                            <li class="menu-item">
                                <a href="#">FAQs</a>
                            </li>
                            <li class="menu-item">
                                <a href="#">Track Order</a>
                            </li>
                            <li class="menu-item">
                                <a href="#">Delivery</a>
                            </li>
                            <li class="menu-item">
                                <a href="#">Contact Us</a>
                            </li>
                            <li class="menu-item">
                                <a href="#">Return</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-end">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="stelina-socials">
                            <ul class="socials">
                                <li>
                                    <a href="https://www.facebook.com/share/16jn6edZt6/" class="social-item" target="_blank">
                                        <i class="icon fa fa-facebook"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.tiktok.com/@biorglobalecommerce?_t=ZS-8xRy6injb3S&_r=1" class="social-item" target="_blank">
                                        <img src="{{asset('/frontend/assets/images/tiktok.png')}}"/>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://youtube.com/@biorglobal?si=AJ5v4HmHr0uIM7bw" class="social-item" target="_blank">
                                        <i class="icon fa fa-youtube"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://wa.me/6285811127777" class="social-item" target="_blank">
                                        <i class="icon fa fa-whatsapp"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="coppyright">
                            Copyright © {{ Date('Y') }}
                            <a href="#">{{ config('app.name') }}</a>
                            . All rights reserved
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="footer-device-mobile">
    <div class="wapper">
        <div class="footer-device-mobile-item device-home">
            <a href="{{ route('home') }}">
					<span class="icon">
						<i class="fa fa-home" aria-hidden="true"></i>
					</span>
                Home
            </a>
        </div>
        <div class="footer-device-mobile-item device-home device-wishlist">
            <a href="{{ route('products.listing') }}">
					<span class="icon">
						<i class="fa fa-th-list" aria-hidden="true"></i>
					</span>
                Products
            </a>
        </div>
        <div class="footer-device-mobile-item device-home device-cart">
            <a href="{{ route('cart') }}">
					<span class="icon">
						<i class="fa fa-shopping-basket" aria-hidden="true"></i>
						<span class="count-icon">
							0
						</span>
					</span>
                <span class="text">Cart</span>
            </a>
        </div>
        <div class="footer-device-mobile-item device-home device-user">
        @if (auth()->check())
            <a href="{{ route('user.dashboard') }}">
                    <span class="icon">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </span>
                dashboard
            </a>
        @else
            <a href="{{ route('user.login') }}">
					<span class="icon">
						<i class="fa fa-user" aria-hidden="true"></i>
					</span>
                Account
            </a>
        @endif
        </div>
    </div>
</div>