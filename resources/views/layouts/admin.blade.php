<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="{{ asset('js/admin.js') }}" defer></script>
</head>
<body>
    <header>
        <!-- Navigation Bar -->
        @include('includes.admin.header')
    </header>
    <aside>
        <!-- Sidebar -->
        @include('includes.admin.sidebar')
    </aside>
    <main>
        @yield('content')
    </main>
</body>
</html>
