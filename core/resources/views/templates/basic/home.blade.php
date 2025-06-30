@extends('templates.basic.layouts.frontend_app')

@section('content')
<div class="home-slider style1 rows-space-30">
    <div class="container">
        <div class="slider-owl owl-slick equal-container nav-center" data-slick='{"autoplay":true, "autoplaySpeed":9000, "arrows":true, "dots":false, "infinite":true, "speed":1000, "rows":1}' data-responsive='[{"breakpoint":"2000","settings":{"slidesToShow":1}}]'>
            <div class="slider-item style1">
                <div class="slider-inner equal-element">
                    <div class="slider-infor">
                        <h5 class="title-small">
                            Luxury Appeal
                        </h5>
                        <h3 class="title-big">
                            Discover Scents That Define You.
                        </h3>
                        <div class="price">
                            Price from:
                            <span class="number-price">
                                    $20.00
                                </span>
                        </div>
                        <a href="#" class="button btn-shop-the-look bgroud-style">Shop now</a>
                    </div>
                </div>
            </div>
            <div class="slider-item style2">
                <div class="slider-inner equal-element">
                    <div class="slider-infor">
                        <h5 class="title-small">
                            Special Offers
                        </h5>
                        <h3 class="title-big">
                            Your Signature Fragrance Awaits!
                        </h3>
                        <div class="price">
                            Price from:
                            <span class="number-price">
                                    $20.00
                                </span>
                        </div>
                        <a href="#" class="button btn-shop-now">Shop now</a>
                    </div>
                </div>
            </div>
            <div class="slider-item style3">
                <div class="slider-inner equal-element">
                    <div class="slider-infor">
                        <h5 class="title-small">
                            Unique Selection
                        </h5>
                        <h3 class="title-big">
                            Exclusive Perfumes, Curated for Every Mood.
                        </h3>
                        <div class="price">
                            Price from:
                            <span class="number-price">
                                    $20.00
                                </span>
                        </div>
                        <a href="#" class="button btn-shop-the-look bgroud-style">Shop now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="banner-wrapp rows-space-35">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="banner">
                    <div class="item-banner style12">
                        <div class="inner">
                            <div class="banner-content">
                                <h3 class="title">Top-Selling Scents</h3>
                                <div class="description">
                                    Loved by thousands – find your signature.
                                </div>
                                <a href="{{ route('products.listing') }}" class="button btn-shop-now">Shop now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="banner">
                    <div class="item-banner style14">
                        <div class="inner">
                            <div class="banner-content">
                                <h4 class="stelina-subtitle">End this weekend</h4>
                                <h3 class="title">Final Hours of Our Big Sale!</h3>
                                <div class="code">
                                    Up to 25% OFF
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="banner">
                    <div class="item-banner style12 type2">
                        <div class="inner">
                            <div class="banner-content">
                                <h3 class="title"> New Summer Fragrances</h3>
                                <div class="description">
                                    Fresh. Light. Unforgettable.
                                </div>
                                <a href="#" class="button btn-view-the-look">Shop now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="stelina-tabs  default rows-space-40">
    <div class="container">
        <div class="tab-head">
            <ul class="tab-link">
              
                <li class="active">
                    <a data-toggle="tab" aria-expanded="true" href="#new_arrivals">New Arrivals </a>
                </li>
               
            </ul>
        </div>
        <div class="tab-container">
            <div id="new_arrivals" class="tab-panel active">
                <div class="stelina-product">
                    <ul class="row list-products auto-clear equal-container product-grid">
                        @foreach ($products as $product)
                                <li class="product-item  col-lg-3 col-md-4 col-sm-6 col-xs-6 col-ts-12 style-1">
                            <div class="product-inner equal-element">
                                <div class="product-top">
                                    <div class="flash">
                                            @if ($product->quantity >= 0)
                                <span class="product-availablity text--success">@lang('in stock')</span>
                            @else
                                <span class="product-availablity text--danger">@lang('out stock')</span>
                            @endif
                                    </div>
                                </div>
                                <div class="product-thumb">
                                    <div class="thumb-inner">
                                        <a href="#">
                                            <img src="{{ getImage(getFilePath('products') . '/' . $product->thumbnail, getFileSize('products')) }}" alt="img">
                                        </a>
                                        <div class="thumb-group">
                                            
                                          @livewire('add-to-cart', ['product' => $product], key($product->id))

                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h5 class="product-name product_title">
                                        <a href="{{ route('product.details', ['id' => $product->id, 'slug' => slug($product->name)]) }}">
                                            {{ __(shortDescription($product->name, 35)) }}</a>
                                    </h5>
                                    <div class="group-info">
                                       
                                        <div class="price">
                                            {{-- <del>
                                                $65
                                            </del> --}}
                                            <ins>
                                               {{ showAmount($product->price) }}
                                            </ins>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                        
                       
                    </ul>
                </div>
            </div>
           
        </div>
    </div>
</div>
<div class="banner-wrapp rows-space-60">
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="banner">
                    <div class="item-banner style6">
                        <div class="inner">
                            <div class="container">
                                <div class="banner-content">
                                    <h4 class="stelina-subtitle">Celebrate Day Sale!</h4>
                                    <h3 class="title">Save <span>25%</span> Of On All<br>Items Collection
                                    </h3>
                                    <a href="#" class="button btn-view-promotion">Shop now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="product-in-stock-wrapp">
    <div class="container">
        <h3 class="custommenu-title-blog white">
            Featured Products
        </h3>
        <div class="stelina-product style3">
            <ul class="row list-products auto-clear equal-container product-grid">
                <li class="product-item  col-lg-4 col-md-6 col-sm-6 col-xs-6 col-ts-12 style-3">
                    <div class="product-inner equal-element">
                        <div class="product-thumb">
                            <div class="product-top">
                                <div class="flash">
                                        <span class="onnew">
                                            <span class="text">
                                                new
                                            </span>
                                        </span>
                                </div>
                                <div class="yith-wcwl-add-to-wishlist">
                                    <div class="yith-wcwl-add-button">
                                        <a href="#" tabindex="0">Add to Wishlist</a>
                                    </div>
                                </div>
                            </div>
                            <div class="thumb-inner">
                                <a href="#" tabindex="0">
                                    <img src="{{asset('/frontend/assets/images/product-item-black-7.jpg')}}" alt="img">
                                </a>
                            </div>
                            <a href="#" class="button quick-wiew-button" tabindex="0">Quick View</a>
                        </div>
                        <div class="product-info">
                            <h5 class="product-name product_title">
                                <a href="#" tabindex="0">Suction Return</a>
                            </h5>
                            <div class="group-info">
                                <div class="stars-rating">
                                    <div class="star-rating">
                                        <span class="star-3"></span>
                                    </div>
                                    <div class="count-star">
                                        (3)
                                    </div>
                                </div>
                                <div class="price">
                                    <span>$375</span>
                                </div>
                            </div>
                            <div class="group-buttons">
                                <div class="quantity">
                                    <div class="control">
                                        <a class="btn-number qtyminus quantity-minus" href="#">-</a>
                                        <input type="text" data-step="1" data-min="0" value="1" title="Qty" class="input-qty qty" size="4">
                                        <a href="#" class="btn-number qtyplus quantity-plus">+</a>
                                    </div>
                                </div>
                                <button class="add_to_cart_button button" tabindex="0">Shop now</button>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="product-item style-3 col-lg-4 col-md-6 col-sm-6 col-xs-6 col-ts-12">
                    <div class="product-inner equal-element">
                        <div class="product-thumb">
                            <div class="product-top">
                                <div class="flash">
                                        <span class="onnew">
                                            <span class="text">
                                                new
                                            </span>
                                        </span>
                                </div>
                                <div class="yith-wcwl-add-to-wishlist">
                                    <div class="yith-wcwl-add-button">
                                        <a href="#" tabindex="0">Add to Wishlist</a>
                                    </div>
                                </div>
                            </div>
                            <div class="thumb-inner">
                                <a href="#" tabindex="0">
                                    <img src="{{asset('/frontend/assets/images/product-item-black-2.jpg')}}" alt="img">
                                </a>
                            </div>
                            <a href="#" class="button quick-wiew-button" tabindex="0">Quick View</a>
                        </div>
                        <div class="product-info">
                            <h5 class="product-name product_title">
                                <a href="#" tabindex="0">Blowoff Valve Kit</a>
                            </h5>
                            <div class="group-info">
                                <div class="stars-rating">
                                    <div class="star-rating">
                                        <span class="star-3"></span>
                                    </div>
                                    <div class="count-star">
                                        (3)
                                    </div>
                                </div>
                                <div class="price">
                                    <span>$375</span>
                                </div>
                            </div>
                            <div class="group-buttons">
                                <div class="quantity">
                                    <div class="control">
                                        <a class="btn-number qtyminus quantity-minus" href="#">-</a>
                                        <input type="text" data-step="1" data-min="0" value="1" title="Qty" class="input-qty qty" size="4">
                                        <a href="#" class="btn-number qtyplus quantity-plus">+</a>
                                    </div>
                                </div>
                                <button class="add_to_cart_button button" tabindex="0">Shop now</button>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="product-item style-3 col-lg-4 col-md-6 col-sm-6 col-xs-6 col-ts-12">
                    <div class="product-inner equal-element">
                        <div class="product-thumb">
                            <div class="product-top">
                                <div class="flash">
                                        <span class="onnew">
                                            <span class="text">
                                                new
                                            </span>
                                        </span>
                                </div>
                                <div class="yith-wcwl-add-to-wishlist">
                                    <div class="yith-wcwl-add-button">
                                        <a href="#" tabindex="0">Add to Wishlist</a>
                                    </div>
                                </div>
                            </div>
                            <div class="thumb-inner">
                                <a href="#" tabindex="0">
                                    <img src="{{asset('/frontend/assets/images/product-item-black-3.jpg')}}" alt="img">
                                </a>
                            </div>
                            <a href="#" class="button quick-wiew-button" tabindex="0">Quick View</a>
                        </div>
                        <div class="product-info">
                            <h5 class="product-name product_title">
                                <a href="#" tabindex="0">Attack Stage</a>
                            </h5>
                            <div class="group-info">
                                <div class="stars-rating">
                                    <div class="star-rating">
                                        <span class="star-3"></span>
                                    </div>
                                    <div class="count-star">
                                        (3)
                                    </div>
                                </div>
                                <div class="price">
                                    <span>$375</span>
                                </div>
                            </div>
                            <div class="group-buttons">
                                <div class="quantity">
                                    <div class="control">
                                        <a class="btn-number qtyminus quantity-minus" href="#">-</a>
                                        <input type="text" data-step="1" data-min="0" value="1" title="Qty" class="input-qty qty" size="4">
                                        <a href="#" class="btn-number qtyplus quantity-plus">+</a>
                                    </div>
                                </div>
                                <button class="add_to_cart_button button" tabindex="0">Shop now</button>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="product-item  col-lg-4 col-md-6 col-sm-6 col-xs-6 col-ts-12 style-3">
                    <div class="product-inner equal-element">
                        <div class="product-thumb">
                            <div class="product-top">
                                <div class="flash">
                                        <span class="onnew">
                                            <span class="text">
                                                new
                                            </span>
                                        </span>
                                </div>
                                <div class="yith-wcwl-add-to-wishlist">
                                    <div class="yith-wcwl-add-button">
                                        <a href="#" tabindex="0">Add to Wishlist</a>
                                    </div>
                                </div>
                            </div>
                            <div class="thumb-inner">
                                <a href="#" tabindex="0">
                                    <img src="{{asset('/frontend/assets/images/product-item-black-4.jpg')}}" alt="img">
                                </a>
                            </div>
                            <a href="#" class="button quick-wiew-button" tabindex="0">Quick View</a>
                        </div>
                        <div class="product-info">
                            <h5 class="product-name product_title">
                                <a href="#" tabindex="0">Cold Intake System</a>
                            </h5>
                            <div class="group-info">
                                <div class="stars-rating">
                                    <div class="star-rating">
                                        <span class="star-3"></span>
                                    </div>
                                    <div class="count-star">
                                        (3)
                                    </div>
                                </div>
                                <div class="price">
                                    <span>$375</span>
                                </div>
                            </div>
                            <div class="group-buttons">
                                <div class="quantity">
                                    <div class="control">
                                        <a class="btn-number qtyminus quantity-minus" href="#">-</a>
                                        <input type="text" data-step="1" data-min="0" value="1" title="Qty" class="input-qty qty" size="4">
                                        <a href="#" class="btn-number qtyplus quantity-plus">+</a>
                                    </div>
                                </div>
                                <button class="add_to_cart_button button" tabindex="0">Shop now</button>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="product-item style-3 col-lg-4 col-md-6 col-sm-6 col-xs-6 col-ts-12">
                    <div class="product-inner equal-element">
                        <div class="product-thumb">
                            <div class="product-top">
                                <div class="flash">
                                        <span class="onnew">
                                            <span class="text">
                                                new
                                            </span>
                                        </span>
                                </div>
                                <div class="yith-wcwl-add-to-wishlist">
                                    <div class="yith-wcwl-add-button">
                                        <a href="#" tabindex="0">Add to Wishlist</a>
                                    </div>
                                </div>
                            </div>
                            <div class="thumb-inner">
                                <a href="#" tabindex="0">
                                    <img src="{{asset('/frontend/assets/images/product-item-black-5.jpg')}}" alt="img">
                                </a>
                            </div>
                            <a href="#" class="button quick-wiew-button" tabindex="0">Quick View</a>
                        </div>
                        <div class="product-info">
                            <h5 class="product-name product_title">
                                <a href="#" tabindex="0">Bottle Melody Eau</a>
                            </h5>
                            <div class="group-info">
                                <div class="stars-rating">
                                    <div class="star-rating">
                                        <span class="star-3"></span>
                                    </div>
                                    <div class="count-star">
                                        (3)
                                    </div>
                                </div>
                                <div class="price">
                                    <span>$375</span>
                                </div>
                            </div>
                            <div class="group-buttons">
                                <div class="quantity">
                                    <div class="control">
                                        <a class="btn-number qtyminus quantity-minus" href="#">-</a>
                                        <input type="text" data-step="1" data-min="0" value="1" title="Qty" class="input-qty qty" size="4">
                                        <a href="#" class="btn-number qtyplus quantity-plus">+</a>
                                    </div>
                                </div>
                                <button class="add_to_cart_button button" tabindex="0">Shop now</button>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="product-item style-3 col-lg-4 col-md-6 col-sm-6 col-xs-6 col-ts-12">
                    <div class="product-inner equal-element">
                        <div class="product-thumb">
                            <div class="product-top">
                                <div class="flash">
                                        <span class="onnew">
                                            <span class="text">
                                                new
                                            </span>
                                        </span>
                                </div>
                                <div class="yith-wcwl-add-to-wishlist">
                                    <div class="yith-wcwl-add-button">
                                        <a href="#" tabindex="0">Add to Wishlist</a>
                                    </div>
                                </div>
                            </div>
                            <div class="thumb-inner">
                                <a href="#" tabindex="0">
                                    <img src="{{asset('/frontend/assets/images/product-item-black-6.jpg')}}" alt="img">
                                </a>
                            </div>
                            <a href="#" class="button quick-wiew-button" tabindex="0">Quick View</a>
                        </div>
                        <div class="product-info">
                            <h5 class="product-name product_title">
                                <a href="#" tabindex="0">Toyota Switchback</a>
                            </h5>
                            <div class="group-info">
                                <div class="stars-rating">
                                    <div class="star-rating">
                                        <span class="star-3"></span>
                                    </div>
                                    <div class="count-star">
                                        (3)
                                    </div>
                                </div>
                                <div class="price">
                                    <span>$375</span>
                                </div>
                            </div>
                            <div class="group-buttons">
                                <div class="quantity">
                                    <div class="control">
                                        <a class="btn-number qtyminus quantity-minus" href="#">-</a>
                                        <input type="text" data-step="1" data-min="0" value="1" title="Qty" class="input-qty qty" size="4">
                                        <a href="#" class="btn-number qtyplus quantity-plus">+</a>
                                    </div>
                                </div>
                                <button class="add_to_cart_button button" tabindex="0">Shop now</button>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div> --}}
<div class="banner-wrapp rows-space-30">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="banner">
                    <div class="item-banner style10">
                        <div class="inner">
                            <div class="banner-content">
                                <h4 class="stelina-subtitle">Limited Edition Scents</h4>
                                <h3 class="title">Rare & lasting impressions.</h3>
                                <div class="description">
                                    We’ve been waiting for you!
                                </div>
                                 <a href="#" class="button btn-shopping-us">Shop now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="banner">
                    <div class="item-banner style11">
                        <div class="inner">
                            <div class="banner-content">
                                <h4 class="stelina-subtitle">Perfume for Every Mood</h4>
                                <h3 class="title">Scents That Speak for You </h3>
                                <div class="description">
                                    From bold to romantic — find your vibe.
                                </div>
                                <a href="#" class="button btn-shopping-us">Shop now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--<div class="stelina-blog-wraap">-->
<!--    <div class="container">-->
<!--        <h3 class="custommenu-title-blog">-->
<!--            Our Latest News-->
<!--        </h3>-->
<!--        <div class="stelina-blog default">-->
<!--            <div class="owl-slick equal-container nav-center" data-slick='{"autoplay":false, "autoplaySpeed":1000, "arrows":false, "dots":true, "infinite":true, "speed":800, "rows":1}' data-responsive='[{"breakpoint":"2000","settings":{"slidesToShow":3}},{"breakpoint":"1200","settings":{"slidesToShow":3}},{"breakpoint":"992","settings":{"slidesToShow":2}},{"breakpoint":"768","settings":{"slidesToShow":2}},{"breakpoint":"481","settings":{"slidesToShow":1}}]'>-->
<!--                <div class="stelina-blog-item equal-element layout1">-->
<!--                    <div class="post-thumb">-->
<!--                        <a href="#">-->
<!--                            <img src="{{asset('/frontend/assets/images/slider-blog-thumb-1.jpg')}}" alt="img">-->
<!--                        </a>-->
<!--                        <div class="category-blog">-->
<!--                            <ul class="list-category">-->
<!--                                <li class="category-item">-->
<!--                                    <a href="#">Skincare</a>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                        <div class="post-item-share">-->
<!--                            <a href="#" class="icon">-->
<!--                                <i class="fa fa-share-alt" aria-hidden="true"></i>-->
<!--                            </a>-->
<!--                            <div class="box-content">-->
<!--                                <a href="#">-->
<!--                                    <i class="fa fa-facebook"></i>-->
<!--                                </a>-->
<!--                                <a href="#">-->
<!--                                    <i class="fa fa-twitter"></i>-->
<!--                                </a>-->
<!--                                <a href="#">-->
<!--                                    <i class="fa fa-google-plus"></i>-->
<!--                                </a>-->
<!--                                <a href="#">-->
<!--                                    <i class="fa fa-pinterest"></i>-->
<!--                                </a>-->
<!--                                <a href="#">-->
<!--                                    <i class="fa fa-linkedin"></i>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="blog-info">-->
<!--                        <div class="blog-meta">-->
<!--                            <div class="post-date">-->
<!--                                Agust 17, 09:14 am-->
<!--                            </div>-->
<!--                            <span class="view">-->
<!--                                    <i class="icon fa fa-eye" aria-hidden="true"></i>-->
<!--                                    631-->
<!--                                </span>-->
<!--                            <span class="comment">-->
<!--                                    <i class="icon fa fa-commenting" aria-hidden="true"></i>-->
<!--                                    84-->
<!--                                </span>-->
<!--                        </div>-->
<!--                        <h2 class="blog-title">-->
<!--                            <a href="#">We bring you the best by working</a>-->
<!--                        </h2>-->
<!--                        <div class="main-info-post">-->
<!--                            <p class="des">-->
<!--                                Phasellus condimentum nulla a arcu lacinia, a venenatis ex congue.-->
<!--                                Mauris nec ante magna.-->
<!--                            </p>-->
<!--                            <a class="readmore" href="#">Read more</a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="stelina-blog-item equal-element layout1">-->
<!--                    <div class="post-thumb">-->
<!--                        <a href="#">-->
<!--                            <img src="{{asset('/frontend/assets/images/slider-blog-thumb-2.jpg')}}" alt="img">-->
<!--                        </a>-->
<!--                        <div class="category-blog">-->
<!--                            <ul class="list-category">-->
<!--                                <li class="category-item">-->
<!--                                    <a href="#">HOW TO</a>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                        <div class="post-item-share">-->
<!--                            <a href="#" class="icon">-->
<!--                                <i class="fa fa-share-alt" aria-hidden="true"></i>-->
<!--                            </a>-->
<!--                            <div class="box-content">-->
<!--                                <a href="#">-->
<!--                                    <i class="fa fa-facebook"></i>-->
<!--                                </a>-->
<!--                                <a href="#">-->
<!--                                    <i class="fa fa-twitter"></i>-->
<!--                                </a>-->
<!--                                <a href="#">-->
<!--                                    <i class="fa fa-google-plus"></i>-->
<!--                                </a>-->
<!--                                <a href="#">-->
<!--                                    <i class="fa fa-pinterest"></i>-->
<!--                                </a>-->
<!--                                <a href="#">-->
<!--                                    <i class="fa fa-linkedin"></i>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="blog-info">-->
<!--                        <div class="blog-meta">-->
<!--                            <div class="post-date">-->
<!--                                Agust 17, 09:14 am-->
<!--                            </div>-->
<!--                            <span class="view">-->
<!--                                    <i class="icon fa fa-eye" aria-hidden="true"></i>-->
<!--                                    631-->
<!--                                </span>-->
<!--                            <span class="comment">-->
<!--                                    <i class="icon fa fa-commenting" aria-hidden="true"></i>-->
<!--                                    84-->
<!--                                </span>-->
<!--                        </div>-->
<!--                        <h2 class="blog-title">-->
<!--                            <a href="#">We know that buying Items</a>-->
<!--                        </h2>-->
<!--                        <div class="main-info-post">-->
<!--                            <p class="des">-->
<!--                                Using Lorem Ipsum allows designers to put together layouts-->
<!--                                and the form content-->
<!--                            </p>-->
<!--                            <a class="readmore" href="#">Read more</a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="stelina-blog-item equal-element layout1">-->
<!--                    <div class="post-thumb">-->
<!--                        <div class="video-stelina-blog">-->
<!--                            <figure>-->
<!--                                <img src="{{asset('/frontend/assets/images/slider-blog-thumb-3.jpg')}}" alt="img" width="370" height="280">-->
<!--                            </figure>-->
<!--                            <a class="quick-install" href="#" data-videosite="vimeo" data-videoid="134060140"></a>-->
<!--                        </div>-->
<!--                        <div class="category-blog">-->
<!--                            <ul class="list-category">-->
<!--                                <li class="category-item">-->
<!--                                    <a href="#">VIDEO</a>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                        <div class="post-item-share">-->
<!--                            <a href="#" class="icon">-->
<!--                                <i class="fa fa-share-alt" aria-hidden="true"></i>-->
<!--                            </a>-->
<!--                            <div class="box-content">-->
<!--                                <a href="#">-->
<!--                                    <i class="fa fa-facebook"></i>-->
<!--                                </a>-->
<!--                                <a href="#">-->
<!--                                    <i class="fa fa-twitter"></i>-->
<!--                                </a>-->
<!--                                <a href="#">-->
<!--                                    <i class="fa fa-google-plus"></i>-->
<!--                                </a>-->
<!--                                <a href="#">-->
<!--                                    <i class="fa fa-pinterest"></i>-->
<!--                                </a>-->
<!--                                <a href="#">-->
<!--                                    <i class="fa fa-linkedin"></i>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="blog-info">-->
<!--                        <div class="blog-meta">-->
<!--                            <div class="post-date">-->
<!--                                Agust 17, 09:14 am-->
<!--                            </div>-->
<!--                            <span class="view">-->
<!--                                    <i class="icon fa fa-eye" aria-hidden="true"></i>-->
<!--                                    631-->
<!--                                </span>-->
<!--                            <span class="comment">-->
<!--                                    <i class="icon fa fa-commenting" aria-hidden="true"></i>-->
<!--                                    84-->
<!--                                </span>-->
<!--                        </div>-->
<!--                        <h2 class="blog-title">-->
<!--                            <a href="#">We design functional Items</a>-->
<!--                        </h2>-->
<!--                        <div class="main-info-post">-->
<!--                            <p class="des">-->
<!--                                Risus non porta suscipit lobortis habitasse felis, aptent-->
<!--                                interdum pretium ut.-->
<!--                            </p>-->
<!--                            <a class="readmore" href="#">Read more</a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="stelina-blog-item equal-element layout1">-->
<!--                    <div class="post-thumb">-->
<!--                        <a href="#">-->
<!--                            <img src="{{asset('/frontend/assets/images/slider-blog-thumb-4.jpg')}}" alt="img">-->
<!--                        </a>-->
<!--                        <div class="category-blog">-->
<!--                            <ul class="list-category">-->
<!--                                <li class="category-item">-->
<!--                                    <a href="#">Skincare</a>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                        <div class="post-item-share">-->
<!--                            <a href="#" class="icon">-->
<!--                                <i class="fa fa-share-alt" aria-hidden="true"></i>-->
<!--                            </a>-->
<!--                            <div class="box-content">-->
<!--                                <a href="#">-->
<!--                                    <i class="fa fa-facebook"></i>-->
<!--                                </a>-->
<!--                                <a href="#">-->
<!--                                    <i class="fa fa-twitter"></i>-->
<!--                                </a>-->
<!--                                <a href="#">-->
<!--                                    <i class="fa fa-google-plus"></i>-->
<!--                                </a>-->
<!--                                <a href="#">-->
<!--                                    <i class="fa fa-pinterest"></i>-->
<!--                                </a>-->
<!--                                <a href="#">-->
<!--                                    <i class="fa fa-linkedin"></i>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="blog-info">-->
<!--                        <div class="blog-meta">-->
<!--                            <div class="post-date">-->
<!--                                Agust 17, 09:14 am-->
<!--                            </div>-->
<!--                            <span class="view">-->
<!--                                    <i class="icon fa fa-eye" aria-hidden="true"></i>-->
<!--                                    631-->
<!--                                </span>-->
<!--                            <span class="comment">-->
<!--                                    <i class="icon fa fa-commenting" aria-hidden="true"></i>-->
<!--                                    84-->
<!--                                </span>-->
<!--                        </div>-->
<!--                        <h2 class="blog-title">-->
<!--                            <a href="#">We know that buying Items</a>-->
<!--                        </h2>-->
<!--                        <div class="main-info-post">-->
<!--                            <p class="des">-->
<!--                                Class integer tellus praesent at torquent cras, potenti erat fames-->
<!--                                volutpat etiam.-->
<!--                            </p>-->
<!--                            <a class="readmore" href="#">Read more</a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
@endsection