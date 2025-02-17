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
