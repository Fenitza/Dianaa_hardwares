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
