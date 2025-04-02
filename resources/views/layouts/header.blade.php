<header>
    <div class="header-top-row text-white py-2">
        <div class="container-fluid">
            <div class="row align-items-center">
                <!-- Collapsible Menu Toggle -->
                <div class="col-2 col-md-1">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>

                <!-- Logo -->
                <div class="col-4 col-md-3">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/logo/Diana_logo2.png') }}" alt="Logo" class="img-fluid">
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="col-6 col-md-4">
                    <form action="{{ route('search') }}" method="GET" class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search a Product" required>
                        <button class="btn btn-warning" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Right Side Icons -->
                <div class="col-md-4 d-none d-md-flex justify-content-end">
                    <a href="{{ route('products_main') }}" class="me-2">Products</a> |
                    <a href="{{ route('login') }}" class="me-2">Login</a> |
                    <a href="{{ route('cart') }}">Cart (0)</a>
                </div>
            </div>
        </div>
    </div>

            <!-- Navigation and icons adjusted to be visible on md screens and larger -->
            <div class="col-md-9 d-none d-md-block">
                <div class="row">
                    <!-- Navigation links -->
                    <div class="col-12 text-end mb-2" style="padding-top: 10px;">
                        <nav>
                            <a href="{{ route('services') }}">Services & Solution</a> |
                            <a href="{{ route('careers') }}">Careers</a> |
                            <a href="{{ route('contact') }}">Contact</a> |
                            <a href="{{ route('about_us') }}">About Us</a>
                        </nav>
                    </div>

                    <!-- Search bar and user interactions for md and larger -->
                    <div class="header-search-bar col-12">
                        <div class="d-flex justify-content-between">
                            <div class="flex-grow-1">
                                <form action="{{ route('search') }}" method="GET" class="input-group">
                                    <input type="text" name="q" class="form-control" placeholder="Search a Product" required>
                                    <button class="btn btn-warning" type="submit">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="header-cart-login col-6 text-end">
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
                                <a href="{{ route('cart') }}">
                                    <i class="fa fa-shopping-cart"></i> Cart (
                                    <span id="cart-count">{{ session('cartCount', 0) }}</span>)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Collapsible content for xs to sm screens -->
    <div class="collapse" id="navbarToggleExternalContent">
        <div class="bg-dark p-4">
            <a href="{{ route('services') }}" class="text-white d-block">Services & Solution</a>
            <a href="{{ route('careers') }}" class="text-white d-block">Careers</a>
            <a href="{{ route('contact') }}" class="text-white d-block">Contact</a>
            <a href="{{ route('about_us') }}" class="text-white d-block">About Us</a>
            <a href="{{ route('products_main') }}" class="text-white d-block"><i class="bi bi-grid-3x3-gap-fill"></i> Products</a>
            @if(Auth::check())
                <a href="{{ route('user.profile') }}" class="text-white d-block"><i class="bi bi-person-fill"></i> Profile</a>
                <a href="{{ route('logout') }}" class="text-white d-block" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            @else
                <a href="{{ route('login') }}" class="text-white d-block"><i class= "bi bi-box-arrow-in-right"></i> Login</a>
            @endif
            <a href="{{ route('cart') }}" class="text-white d-block">
                <i class="fa fa-shopping-cart"></i> Cart (<span id="cart-count">{{ session('cartCount', 0) }}</span>)
            </a>
        </div>
    </div>
</header>
