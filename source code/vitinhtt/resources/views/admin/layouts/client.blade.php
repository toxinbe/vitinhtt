<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport'/>
    <link rel="icon" href="{{ asset('img/logo/adminmini.png') }}" type="image/x-icon" />
    <title>[Admin] Vi tính T&T - @yield('title')</title>
    @include('admin.layouts.head')
    @yield('head') {{-- thêm css --}}
</head>
<body>
    <div class="wrapper">
        @include('admin.layouts.menu')
        @include('admin.layouts.searchheader')
        <div class="main-panel">
            <div class="content">
                @yield('content')
            </div>
            @include('admin.layouts.footer')
        </div>
    </div>
</body>
@yield('js') {{-- thêm js --}}
</html>
