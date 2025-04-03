<header>
    <!-- Section for Small and Medium Screens -->
    <div class="d-block d-lg-none text-white py-2" style="background-color: #333c8b; padding-left: 30px; padding-right: 30px;">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-between">
            <!-- Left: Toggler and Logo -->
            <div class="col-7 d-flex align-items-center">
                <!-- Toggler -->
                <button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars text-white fs-5"></i>
                </button>
                <!-- Logo -->
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/logo/Diana_logo2.png') }}" alt="Logo"
                        class="img-fluid" style="max-height: 45px;">
                </a>
            </div>

            <!-- Right: Search, Login, Cart Icons -->
            <div class="col-5 text-end">
                <div class="d-flex justify-content-end align-items-center gap-2">
                    <!-- Search Icon -->
                    <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal"
                        data-bs-target="#searchModal" title="Search">
                        <i class="bi bi-search"></i>
                    </button>

                    <!-- Login Icon -->
                      @if(Auth::check())
                @if(Auth::user()->role === 'admin')
                    <!-- Admin specific link -->
                    <a href="{{ route('admin.products') }}" class="btn btn-outline-light btn-sm" title="Account">
                            <i class="bi bi-person-fill"></i></a> 
                @else
                    <!-- Standard user link -->
                    <a href="{{ route('user.profile') }}"class="btn btn-outline-light btn-sm" title="Account">
                            <i class="bi bi-person-fill"></i></a> 
                @endif
                   
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm" title="Login">
                            <i class="bi bi-box-arrow-in-right"></i>
                        </a>
                    @endif

                    <!-- Cart Icon -->
                    <a href="{{ route('cart') }}" class="btn btn-outline-light btn-sm d-flex align-items-center gap-1" title="Cart" style="height: 32px;">
                        <i class="fa fa-shopping-cart"></i>
                        <span style="font-size: 0.85rem;">{{ session('cartCount', 0) }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Uniform Header for Large Screens -->
<div class="d-none d-lg-block text-white py-2" style="background-color: #333c8b; padding-left: 30px; padding-right: 30px;">
    <div class="row align-items-center">
        <!-- First column for logo -->
        <div class="col-lg-3">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logo/Diana_logo2.png') }}" alt="Logo" style="height: 70px;">
            </a>
        </div>

        <!-- Second column for links, search bar, and buttons -->
        <div class="col-lg-9">
            <div class="row">
                <!-- Navigation links row -->
                <div class="header-cart-login col-12 text-end mb-2" style="padding-top: 10px;">
                    <nav>
                        <a href="{{ route('services') }}"><i class="bi bi-tools"></i> Services & Solution</a> |
                        <a href="{{ route('careers') }}"><i class="bi bi-briefcase"></i> Careers</a> |
                        <a href="{{ route('contact') }}"><i class="bi bi-envelope"></i> Contact</a> |
                        <a href="{{ route('about_us') }}"><i class="bi bi-info-circle"></i> About Us</a>
                    </nav>
                </div>

                <!-- Search bar and right-side buttons -->
                <div class="header-search-bar col-12">
                    <div class="d-flex justify-content-between">
                        <!-- Search bar -->
                        <div class="flex-grow-1 me-3">
                            <form action="{{ route('search') }}" method="GET" class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Search a Product" required>
                                <button class="btn btn-warning" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Right-side links -->
                        <div class="header-cart-login col-6 text-end">
                            <a href="{{ route('products_main') }}" class="me-2 text-decoration-none">
                                <i class="bi bi-grid-3x3-gap-fill"></i> Products
                            </a> |

                             @if(Auth::check())
                                    @if(Auth::user()->role === 'admin')
                                        <!-- Admin specific link -->
                                        <a href="{{ route('admin.products') }}">{{ Auth::user()->name }}</a> | 
                                    @else
                                        <!-- Standard user link -->
                                        <a href="{{ route('user.profile') }}">{{ Auth::user()->name }}</a> | 
                                    @endif
                                <a href="{{ route('logout') }}" class=" text-decoration-none"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout 
                                </a> |
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="me-2  text-decoration-none">
                                    <i class="bi bi-box-arrow-in-right"></i> Login
                                </a> |
                            @endif
                            <a href="{{ route('cart') }}" class=" text-decoration-none">
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

 <!-- Collapsible content for xs to sm screens -->
    <div class="collapse d-lg-none " id="navbarToggleExternalContent">
        <div class="bg-dark p-4">
            <a href="{{ route('services') }}"><i class="bi bi-tools"></i> Services & Solution</a>
            <a href="{{ route('careers') }}"><i class="bi bi-briefcase"></i> Careers</a>
            <a href="{{ route('contact') }}"><i class="bi bi-envelope"></i> Contact</a>
            <a href="{{ route('about_us') }}"><i class="bi bi-info-circle"></i> About Us</a>
            <a href="{{ route('products_main') }}" class="text-white d-block"><i class="bi bi-grid-3x3-gap-fill"></i> Products</a>
            @if(Auth::check())
                @if(Auth::user()->role === 'admin')
                    <!-- Admin specific link -->
                    <a href="{{ route('admin.products') }}" class="text-white d-block"><i class="bi bi-person-fill"></i>{{ Auth::user()->name }}</a> | 
                @else
                    <!-- Standard user link -->
                    <a href="{{ route('user.profile') }}" class="text-white d-block"><i class="bi bi-person-fill"></i>{{ Auth::user()->name }}</a> | 
                @endif

                <a href="{{ route('logout') }}" class="text-white d-block" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            @else
                <a href="{{ route('login') }}" class="text-white d-block"><i class="bi bi-box-arrow-in-right"></i> Login</a>
            @endif
            <a href="{{ route('cart') }}" class="text-white d-block">
                <i class="fa fa-shopping-cart"></i> Cart (<span id="cart-count">{{ session('cartCount', 0) }}</span>)
            </a>
        </div>
    </div>    


<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchModalLabel">Search</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('search') }}" method="GET">
                    <input type="text" name="q" class="form-control" placeholder="Search a Product" required>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>