<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.layouts.jidox.shared.title-meta', ['title' => $title])
    @include('admin.layouts.jidox.shared.head-css')
    @yield('css')
</head>

<body class="authentication-bg">
    @yield('content')

    <footer class="footer footer-alt">
        {{ date('Y') }} © NewKirk
    </footer>

    @include('admin.layouts.jidox.shared.footer-script')
</body>
</html>
