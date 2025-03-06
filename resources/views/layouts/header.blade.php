<header>
        <div class="header-container">
            <!-- Left Section: Logo -->
            <div class="left-section">
                <a href="{{ url('/') }}"><img src="{{ asset('images/logo/Diana_logo2.png') }}" alt="Logo"></a>
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
                        <a href="{{ route('products_main') }}" class ="all-products"><i class="fa fa-box"></i> Products</a> |
                        <!-- <a href="{{ route('account') }}"><i class="fa fa-user"></i> My Account</a> | -->
                        <a href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i> Cart(<span id="cart-count">0</span>)</a> |
                        
                        <div class="user-profile">
                                @if(Auth::check()) <!-- Check if user is authenticated -->
                                    <i class="fa fa-user"></i> <!-- Display the user icon -->
                                    <div class="user-text">
                                        <span class="user-name">{{ Auth::user()->name }}</span><br> <!-- Display user's name -->
                                        <span class="user-email">{{ Auth::user()->email }}</span> <!-- Display user's email -->
                                    </div>
                                    <div class="user-details-dropdown">
                                        <a href="{{ route('admin.products') }}" class="dropdown-item">Profile</a> <!-- Profile link -->
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                @else
                                    <!-- Display login or register links if user is not authenticated -->
                                    <a href="{{ route('login') }}">Login</a>
                                    
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</header>
