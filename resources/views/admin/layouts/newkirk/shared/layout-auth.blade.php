<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.layouts.newkirk.shared.title-meta', ['title' => $title])
    @include('admin.layouts.newkirk.shared.head-css')
    @yield('css')
</head>

<body class="authentication-bg">
    @yield('content')

    <footer class="footer footer-alt">
        {{ date('Y') }} © NewKirk
    </footer>

    @include('admin.layouts.newkirk.shared.footer-script')
</body>
</html>

