<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layouts.jidox.shared/title-meta', ['title' => $page_title])
    @yield('css')
    @include('admin.layouts.jidox.shared/head-css', ['mode' => $mode ?? '', 'demo' => $demo ?? ''])

    @vite(['resources/jidox/js/head.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>
    <div class="wrapper">

        @include('admin.layouts.jidox.shared/topbar')

        @include('admin.layouts.jidox.shared/left-sidebar')

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                @yield('content')
            </div>
            @include('admin.layouts.jidox.shared/footer')
        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>

    @include('admin.layouts.jidox.shared/right-sidebar')
    @include('admin.layouts.jidox.shared/footer-script')
    @vite(['resources/jidox/js/app.js', 'resources/jidox/js/layout.js'])
    @yield('script')

</body>

</html>
