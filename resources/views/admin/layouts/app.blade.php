@extends('admin.layouts.newkirk.vertical', ['page_title' => $title ?? 'Admin Dashboard', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
    @yield('styles')
@endsection

@section('content')
    @yield('admin_content')
    @yield('content')
@endsection

@section('script')
    @yield('scripts')
@endsection

