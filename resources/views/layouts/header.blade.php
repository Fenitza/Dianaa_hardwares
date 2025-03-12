<header>
    <div class="header-top-row">
        <!-- Logo -->
        <div class="header-logo">
            <a href="{{ url('/') }}"><img src="{{ asset('images/logo/Diana_logo2.png') }}" alt="Logo"></a>
        </div>
        
        <!-- Search Bar -->
        <div class="header-search-bar">
            <form action="{{ route('search') }}" method="GET">
                <input type="text" name="q" placeholder="Search a Product" required>
                <button type="submit">Search</button>
            </form>
        </div>

        <!-- Cart and Login -->
        <div class="header-cart-login">
            <a href="{{ route('products_main') }}">Products</a>|
            <a href="{{ route('cart') }}">
                <i class="fa fa-shopping-cart"></i> Cart(
                @if(Auth::check())
                    <span id="cart-count">{{ session('cartCount', 0) }}</span>
                @else
                    <span id="cart-count">0</span>
                @endif
                )
            </a>|
            @if(Auth::check())
                <a href="{{ route('user.profile') }}">{{ Auth::user()->name }}</a>| 
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
            @endif
        </div>
    </div>

    <div class="header-bottom-row">
        <!-- Navigation Links -->
        <nav>
            <a href="{{ route('about_us') }}">About Us</a> |
            <a href="{{ route('services') }}">Services & Solutions</a> |
            <a href="{{ route('careers') }}">Careers</a> |
            <a href="{{ route('contact') }}">Contact</a> |
            
        </nav>
    </div>
</header>
