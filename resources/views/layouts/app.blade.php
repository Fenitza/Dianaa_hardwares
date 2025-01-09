<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website Title</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header-container">
            <!-- Left Section: Logo -->
            <div class="left-section">
                <a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="Logo"></a>
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
                        <a href="#">All Products</a> |
                        <a href="{{ route('account') }}">My Account</a> |
                        <a href="{{ route('cart') }}">Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    @yield('content')
</body>
</html>
