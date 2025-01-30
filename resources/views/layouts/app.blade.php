<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dianaa Hardwares</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9B0CUoE4RJC3Cp2T11tHKEg3pii2K63nn2" crossorigin="anonymous">
</head>
<body>
    <header>
        <div class="header-container">
            <!-- Left Section: Logo -->
            <div class="left-section">
                <a href="{{ url('/') }}"><img src="{{ asset('images/logo/logo.png') }}" alt="Logo"></a>
            </div>

            <!-- Right Section -->
            <div class="right-section">
                <!-- Top Links -->
                <div class="top-right-links">
                    <a href="{{ route('about_us') }}">About Us</a> |
                    <a href="{{ route('services') }}">Services & Solutions</a> |
                    <a href="{{ route('careers') }}">Careers</a> |
                    <a href="{{ route('contact') }}">Contact</a>
                </div>

                <!-- Bottom Section: Search Bar and Links -->
                <div class="bottom-right-section">
                    <div class="search-bar">
                        <form action="{{ route('search') }}" method="GET">
                            <input type="text" name="q" placeholder="Search a Product" required>
                            <button type="submit">Search</button>
                        </form>
                    </div>
                    <div class="bottom-links">
                        <a href="#"><i class="fa fa-box"></i> All Products</a> |
                        <a href="{{ route('account') }}"><i class="fa fa-user"></i> My Account</a> |
                        <a href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i> Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<!-- Include Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<!-- Include Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    @yield('content')
</body>
</html>
