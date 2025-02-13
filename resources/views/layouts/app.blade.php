<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dianaa Hardwares</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header-container">
            <!-- Left Section: Logo -->
            <div class="left-section">
                <a href="{{ url('/') }}"><img src="{{ asset('images/logo/Diana_logo.png') }}" alt="Logo"></a>
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
                        <a href="{{ route('products_main') }}"><i class="fa fa-box"></i> All Products</a> |
                        <!-- <a href="{{ route('account') }}"><i class="fa fa-user"></i> My Account</a> | -->
                        <a href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i> Cart</a> |
                        <a href="{{ route('login') }}"><i class="fa fa-user"></i> Log In</a>
                    </div>
                </div>
            </div>
        </div>
    </header>


    @yield('content')

     <!-- Services Section -->
     <div class="product-service-offers">
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

     <!-- Footer -->
     <footer class="site-footer">
    <div class="footer-container">
        <div class="footer-column">
            <h4>Products</h4>
            <ul>
                <li><a href="#">Prices drop</a></li>
                <li><a href="#">New products</a></li>
                <li><a href="#">Best sales</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Our company</h4>
            <ul>
                <li><a href="#">Delivery</a></li>
                <li><a href="#">Legal Notice</a></li>
                <li><a href="#">Terms and conditions of use</a></li>
                <li><a href="#">About us</a></li>
                <li><a href="#">Secure payment</a></li>
                <li><a href="#">Contact us</a></li>
                <li><a href="#">Sitemap</a></li>
                <li><a href="#">Stores</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Your account</h4>
            <ul>
                <li><a href="#">Personal info</a></li>
                <li><a href="#">Orders</a></li>
                <li><a href="#">Credit slips</a></li>
                <li><a href="#">Addresses</a></li>
                <li><a href="#">Wishlist</a></li>
                <li><a href="#">Compare</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Store Information</h4>
            <p>ToolShop, Russia</p>
            <p>Tel: 123 456 789</p>
            <p>Email: demo@demo.com</p>
            <div class="payment-methods">
                <i class="fab fa-cc-visa" aria-hidden="true"></i>
                <i class="fab fa-cc-paypal" aria-hidden="true"></i>
                <i class="fab fa-cc-mastercard" aria-hidden="true"></i>
                <i class="fab fa-cc-amex" aria-hidden="true"></i>
                <i class="fab fa-cc-discover" aria-hidden="true"></i>
            </div>
        </div>
    </div>
</footer>

    <!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<!-- Include Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>




</body>
</html>
