<!DOCTYPE html>
<html>

<head>
    <title>@yield('title', 'Blog Site')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
</head>

<body>

    @include('layout.header')

    <main class="container py-4">
        @yield('content')

    </main>

    @include('layout.footer')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    @yield('js')

</body>

</html>
