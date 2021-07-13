<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <link href="/images/logo_icon.png" rel="shortcut icon">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Midone admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, Midone admin template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="LEFT4CODE"> -->
        <title>Auto Wash - Agent</title>
        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="/admin-assets/dist/css/app.css" />
        <link rel="stylesheet" type="text/css" href="{{ asset('toastr/toastr.css')}}">
        <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/extensions/sweetalert2.min.css">
        @yield('extra-css')
        <!-- END: CSS Assets-->
    </head>
    <!-- END: Head -->
    <body class="app">
        <!-- BEGIN: Mobile Menu -->
        @include('agent.mobile_menu')
        <!-- END: Mobile Menu -->
        <!-- BEGIN: Top Bar -->
        @include('agent.header')
        <!-- END: Top Bar -->
        <!-- BEGIN: Top Menu -->
        @include('agent.menu')
        <!-- END: Top Menu -->
        <!-- BEGIN: Content -->  
        @yield('body-section')
        <!-- END: Content -->
        <!-- BEGIN: JS Assets-->
        <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=["your-google-map-api"]&libraries=places"></script>
        <script src="/admin-assets/dist/js/app.js"></script>
        <script src="{{ asset('toastr/toastr.min.js')}}"></script>
        <script src="/app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
        @yield('extra-js')
        <!-- END: JS Assets-->
    </body>
</html>