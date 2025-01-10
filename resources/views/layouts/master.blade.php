<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>ConnectFriend</title>
        <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    </head>

    <body>
        @include('components.navbar')
        <div class="mx-auto px-4 mt-3 mb-3" style="max-width: 1200px; min-height: 90vh;">
            @yield('content')
        </div>
        @include('components.footer')
        <script src={{ asset('bootstrap/js/bootstrap.bundle.min.js') }}></script>
        @yield('scripts')
    </body>
</html>
