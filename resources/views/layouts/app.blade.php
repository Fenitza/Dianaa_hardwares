<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/logo/favicon.ico') }}" type="image/x-icon">
    <title>Dianaa Fasteners - Leading Provider of Engineering and Fasteners Solutions</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">


</head>
@stack('scripts')
<body>
    @include('layouts.header')


    @yield('content')

<!-- Spacer Block -->
<div class="custom-spacer"></div>
     <!-- Services Section -->
     <div class="product-service-offers" >
    <div class="product-service-item">
        <i class="fas fa-grin-beam fa-2x"></i>
        <span>100% Satisfaction<br>If you are unable</span>
    </div>
    <div class="product-service-item">
        <i class="fas fa-tags fa-2x"></i>
        <span>Save 20% When You<br>Use credit card</span>
    </div>
    <div class="product-service-item">
        <i class="fas fa-shipping-fast fa-2x"></i>
        <span>Fast Free Shipment<br>Load any computer's</span>
    </div>
    <div class="product-service-item">
        <i class="fas fa-undo fa-2x"></i>
        <span>14-Day Money Back<br>If you are unable</span>
    </div>
    </div>

    <a href="https://wa.me/919566275630" target="_blank" class="whatsapp-float" aria-label="Chat on WhatsApp">
    <i class="fab fa-whatsapp whatsapp-icon"></i>
</a>

    <style>
.whatsapp-float {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #25d366;
    color: white;
    border-radius: 50%;
    padding: 15px;
    box-shadow: 2px 2px 3px #999;
    z-index: 1000;
    text-align: center;
    transition: transform 0.3s;
}

.whatsapp-float:hover {
    transform: scale(1.1);
    color: white;
    text-decoration: none;
}

.whatsapp-icon {
    font-size: 30px;
}


.product-service-offers {
    display: flex;
    flex-wrap: wrap; /* Allows items to wrap to the next line */
    justify-content: center; /* Optional: centers items horizontally */
    gap: 10px; /* Adds space between items */
}

.product-service-item {
    flex: 1 1 150px; /* Flex grow/shrink with minimum width */
    min-width: 120px; /* Prevents items from getting too small */
    text-align: center;
    padding: 10px;
    box-sizing: border-box;
}

@media (max-width: 480px) {
    .product-service-item {
        flex: 1 1 100%; /* On very small screens, items take full width */
    }
}
</style>

    @include('layouts.footer') 

<script src="{{ asset('js/app.js') }}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Include Bootstrap JS with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<!-- Include Bootstrap JS -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->


</body>
</html>
