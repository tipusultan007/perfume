<!DOCTYPE html>
<html lang="en" data-sidenav-size="sm-hover">

<head>
    @include('admin.layouts.jidox.shared/title-meta', ['title' => $page_title])
    @yield('css')
    @include('admin.layouts.jidox.shared/head-css', ['mode' => $mode ?? '', 'demo' => $demo ?? ''])

    @vite(['resources/jidox/js/head.js'])
</head>

<body>
    <!-- Begin page -->
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
    @vite(['resources/jidox/js/app.js', 'resources/jidox/js/layout.js'])
    @include('admin.layouts.jidox.shared/footer-script')
    @yield('script')

</body>

</html>
