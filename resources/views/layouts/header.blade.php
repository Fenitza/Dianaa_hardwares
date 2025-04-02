<header>
    <div class="header-top-row text-white py-2" style="padding-left: 30px; padding-right: 30px;">
    <div class="row align-items-center">
        <!-- First column for logo -->
        <div class="col-md-3">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logo/Diana_logo2.png') }}" alt="Logo" style="height: 70px;">
            </a>
        </div>


        <!-- Second column for links, search bar, and buttons -->
<div class="col-md-9">
    <div class="row">
        <!-- First row for navigation links at the end -->
        <div class="col-12 text-end mb-2" style="padding-top: 10px;">
            <nav>
                <a href="{{ route('services') }}">Services & Solution</a> |
                <a href="{{ route('careers') }}">Careers</a> |
                <a href="{{ route('contact') }}">Contact</a> |
                <a href="{{ route('about_us') }}">About Us</a>
            </nav>
        </div>

        <!-- Second row for search and user interactions -->
        <div class="header-search-bar col-12">
            <div class="d-flex justify-content-between">
                <!-- Search Bar -->
                <div class="flex-grow-1">
                    <form action="{{ route('search') }}" method="GET" class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search a Product" required>
                        <button class="btn btn-warning" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Product and Account Links -->
                <div class="header-cart-login col-6 text-end ">
                    <a href="{{ route('products_main') }}" class="me-2"><i class="bi bi-grid-3x3-gap-fill"></i> Products</a>|
                    @if(Auth::check())
                        <a href="{{ route('user.profile') }}" class="me-2"><i class="bi bi-person-fill"></i> {{ Auth::user()->name }}</a>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="me-2"><i class="bi bi-box-arrow-in-right"></i> Login</a>|
                    @endif

                    <!-- Cart Link -->
                    <a href="{{ route('cart') }}">
                        <i class="fa fa-shopping-cart"></i> Cart (
                        @if(Auth::check())
                            <span id="cart-count">{{ session('cartCount', 0) }}</span>
                        @else
                            <span id="cart-count">0</span>
                        @endif
                        )
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
</div>


</header>
