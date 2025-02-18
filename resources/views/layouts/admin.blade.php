<!-- Main Layout HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="{{ asset('js/admin.js') }}" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        @include('includes.admin.header')
    </header>
    <div class="admin-container">
        <aside>
        <ul>
            <li><a href="{{ route('admin.products') }}"><i class="fas fa-box-open"></i> Products</a></li>
            <li><a href="{{ route('admin.orders') }}"><i class="fas fa-shopping-cart"></i> Orders</a></li>
            <!-- More sidebar items with icons -->
        </ul>

        </aside>
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
