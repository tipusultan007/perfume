<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layouts.newkirk.shared/title-meta', ['title' => $page_title])
    @yield('css')
    @include('admin.layouts.newkirk.shared/head-css', ['mode' => $mode ?? '', 'demo' => $demo ?? ''])

    @vite(['resources/newkirk/js/head.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>
    <div class="wrapper">

        @include('admin.layouts.newkirk.shared/topbar')

        @include('admin.layouts.newkirk.shared/left-sidebar')

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


