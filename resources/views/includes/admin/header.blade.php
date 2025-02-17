<div class="header">
    <div class="logo">
        <a href="/">
            <img src="{{ asset('images/logo/Diana_logo.png') }}" alt="Company Logo" style="height: 50px;">
        </a>
    </div>
    <div class="search-bar">
        <input type="text" placeholder="Search...">
    </div>
    <div class="user-info">
        <div class="notification">
            <a href="#" class="notification">
                <i class="fas fa-bell"></i>
            </a>
        </div>
        <div class="user-profile">
            <i class="fas fa-user-circle"></i>
            <div class="user-text">
                <span class="user-name">{{ Auth::user()->name }}</span> <!-- Display user's name -->
                <span class="user-email">{{ Auth::user()->email }}</span> <!-- Display user's email -->
            </div>
            <div class="user-details-dropdown">
                <a href="/profile" class="dropdown-item">Profile</a> <!-- Profile link -->
                <a href="/logout" class="dropdown-item">Logout</a> <!-- Logout link -->
            </div>
        </div>
    </div>
</div>
