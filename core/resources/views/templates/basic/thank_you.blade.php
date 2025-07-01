@extends('templates.basic.layouts.frontend_app')

@section('content')

<div class="container">
        <div class="row">
           <div class="end-checkout-wrapp">
                <div class="end-checkout checkout-form">
                    <div class="icon">
                    </div>
                    <h3 class="title-checkend">
                        Congratulation! Your order has been processed.
                    </h3>
                    <div class="sub-title">
                        Thank you for your purchase!
                    </div>
                    <a href="{{ route('products.listing') }}" class="button btn-return">Return to Store</a>
                </div>
            </div>
        </div>
</div>

@endsection