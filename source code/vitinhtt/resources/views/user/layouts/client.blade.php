<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/logo/mini.png') }}">
    <title>Vi tính T&T - @yield('title')</title>
    @include('user.layouts.head')
    @yield('head') {{-- thêm css --}}
</head>

<body>
    @include('user.layouts.menuheader')
    @yield('content')
    @include('user.layouts.footer')
    @include('user.layouts.chatbox')
    @yield('js') {{-- thêm js --}}
</body>

</html>
