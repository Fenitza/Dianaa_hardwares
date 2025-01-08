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
        <div class="container" style="padding: 10px 20px;">
            <div class="top-links">
                <div class="logo">
                    <a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="Logo"></a>
                </div>
                <div class="top-right-links">
                    <a href="{{ route('about_us') }}">About Us</a> |
                    <a href="{{ route('services') }}">Services & Solutions</a> |
                    <a href="{{ route('careers') }}">Careers</a> |
                    <a href="{{ route('contact') }}">Contact</a>
                </div>
            </div>
            <div class="main-header">
                <div class="search-bar">
                    <input type="text" name="q" placeholder="Search a Product" required>
                    <button type="submit">Search</button>
                </form>
                </div>
                <div class="bottom-right-links">
                    <a href="#">All Products</a> |
                    <a href="{{ route('account') }}">My Account</a> |
                    <a href="{{ route('cart') }}">Cart</a>
                </div>
            </div>
        </div>
    </header>
    @yield('content')
</body>
</html>
