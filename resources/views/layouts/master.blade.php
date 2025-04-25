<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') |
        {{ isset(Configurations::getConfig('site')->site_name) ? Configurations::getConfig('site')->site_name : '' }}
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Vivek Admin & Dashboard" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->id() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset(Configurations::getConfig('site')->site_icon) }}">

    {{--     
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}


    <!-- <link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.css"> -->


    @include('layouts.head-css')
    <style>
        .select2 {
            width: 100% !important;
        }

        .required::after {
            content: "*";
            color: red;
            margin-left: 2px;
            /* Optional: Adds a small space after the text */
        }

        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #ccc;
            border-top: 5px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

@section('body')

    <body data-sidebar="dark" data-layout-mode="light">
    @show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.topbar')
        @include('layouts.sidebar')

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    @if (session()->has('exception'))
                        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                            <div class="text-white">{{ session('exception') }}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    <ul id="notification-list">

                        <!-- Notifications will be appended here -->
                    </ul>
                    <div id="admin-app">
                        @yield('content')

                    </div>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    @include('layouts.right-sidebar')
    <!-- /Right-bar -->

    <!-- JAVASCRIPT -->
    @include('layouts.vendor-scripts')

    <script></script>
    <script src="{{ mix('js/backend/adminvue.js') }}"></script>
</body>

</html>
