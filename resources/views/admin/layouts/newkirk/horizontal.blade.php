<!DOCTYPE html>
<html lang="en" data-layout="topnav">

<head>
    @include('admin.layouts.newkirk.shared/title-meta', ['title' => $page_title])
    @yield('css')
    @include('admin.layouts.newkirk.shared/head-css', ['mode' => $mode ?? '', 'demo' => $demo ?? ''])

    @vite(['resources/newkirk/js/head.js'])
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">

        @include('admin.layouts.newkirk.shared/topbar')

        @include('admin.layouts.newkirk.shared/horizontal-nav')

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                @yield('content')
            </div>
            @include('admin.layouts.newkirk.shared/footer')
        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>

    @include('admin.layouts.newkirk.shared/right-sidebar')
    @include('admin.layouts.newkirk.shared/footer-script')
    @vite(['resources/newkirk/js/app.js', 'resources/newkirk/js/layout.js'])
    @yield('script')

</body>

</html>


