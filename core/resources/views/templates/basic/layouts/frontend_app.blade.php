
<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $title ?? config('app.name') .' Home' }}</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png">

    <link rel="stylesheet" href="{{asset('/frontend/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/frontend/assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('/frontend/assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('/frontend/assets/css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('/frontend/assets/css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('/frontend/assets/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('/frontend/assets/css/chosen.min.css')}}">
    <link rel="stylesheet" href="{{asset('/frontend/assets/css/pe-icon-7-stroke.css')}}">
    <link rel="stylesheet" href="{{asset('/frontend/assets/css/magnific-popup.min.css')}}">
    <link rel="stylesheet" href="{{asset('/frontend/assets/css/lightbox.min.css')}}">
    <link rel="stylesheet" href="{{asset('/frontend/assets/js/fancybox/source/jquery.fancybox.css')}}">
    <link rel="stylesheet" href="{{asset('/frontend/assets/css/jquery.scrollbar.min.css')}}">
    <link rel="stylesheet" href="{{asset('/frontend/assets/css/mobile-menu.css')}}">
    <link rel="stylesheet" href="{{asset('/frontend/assets/fonts/flaticon/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('/frontend/assets/css/style.css')}}">
        @livewireStyles

</head>
<body class="home">

    @include('templates.basic.partials.frontend_header')
<div class="main-content">
    <div class="fullwidth-template">
        @yield('content')
    </div>
</div>
@include('templates.basic.partials.frontend_footer')
<a href="#" class="backtotop">
    <i class="fa fa-angle-double-up"></i>
</a>
 <!-- In head section -->
 <script src="{{asset('/frontend/assets/js/jquery-1.12.4.min.js')}}"></script>
<script src="{{asset('/frontend/assets/js/jquery.plugin-countdown.min.js')}}"></script>
<script src="{{asset('/frontend/assets/js/jquery-countdown.min.js')}}"></script>
<script src="{{asset('/frontend/assets/js/bootstrap.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.js"></script>
@livewireScripts
  


<script>
   

    // Livewire v3 event listeners
    document.addEventListener('livewire:init', () => {
        // Component events
        Livewire.on('cartUpdated', (event) => {

            console.log('Cart was updated with items:', event[0].name);
            let status = event[0].status || 'success';
            // You can update UI here
            // showToast('success', 'Cart updated successfully! ' + event[0].name);
        const txt = event[0].message || 'Product added to cart! |  ' + event[0].name;
             const options = {
             text: txt,
            showHideTransition: 'slide',
            icon: status == 'error' ? 'error' : 'success',
            position: 'top-right',
            hideAfter: 3000,
            stack: 1,

            textAlign: 'left'
        };

        // Color customization
        const colors = {
            success: '#51a351',
            error: '#bd362f',
            warning: '#f89406',
            info: '#2f96b4'
        };
        
                 $.toast(options);

            
        });
        
     
    });
</script>

<script src="{{asset('/frontend/assets/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('/frontend/assets/js/magnific-popup.min.js')}}"></script>
<script src="{{asset('/frontend/assets/js/isotope.min.js')}}"></script>
<script src="{{asset('/frontend/assets/js/jquery.scrollbar.min.js')}}"></script>
<script src="{{asset('/frontend/assets/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('/frontend/assets/js/mobile-menu.js')}}"></script>
<script src="{{asset('/frontend/assets/js/chosen.min.js')}}"></script>
<script src="{{asset('/frontend/assets/js/slick.js')}}"></script>
<script src="{{asset('/frontend/assets/js/jquery.elevateZoom.min.js')}}"></script>
<script src="{{asset('/frontend/assets/js/jquery.actual.min.js')}}"></script>
<script src="{{asset('/frontend/assets/js/fancybox/source/jquery.fancybox.js')}}"></script>
<script src="{{asset('/frontend/assets/js/lightbox.min.js')}}"></script>
<script src="{{asset('/frontend/assets/js/owl.thumbs.min.js')}}"></script>
<script src="{{asset('/frontend/assets/js/jquery.scrollbar.min.js')}}"></script>
<script src="{{asset('/frontend/assets/js/frontend-plugin.js')}}"></script>
 


    
</body>
</html>