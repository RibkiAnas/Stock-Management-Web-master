<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/x-icon" href="./assets/images/favicon/favicon.ico">

    <!-- Libs CSS -->
    <link href="{{asset('assets/libs/bootstrap-icons/font/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('assets/libs/dropzone/dist/dropzone.css')}}"  rel="stylesheet">
    <link href="{{asset('assets/libs/@mdi/font/css/materialdesignicons.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/libs/prismjs/themes/prism-okaidia.css')}}" rel="stylesheet">
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/theme.min.css')}}">
    <title>@yield('title')</title>
</head>

<body>
    <!-- container -->
  <div class="container d-flex flex-column">
    <div class="row align-items-center justify-content-center g-0
        min-vh-100">
        <div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">
            <!-- Card -->
            <div class="card smooth-shadow-md">
                @yield('content')
            </div>
        </div>
    </div>
</div>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/libs/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('assets/libs/feather-icons/dist/feather.min.js')}}"></script>
    <script src="{{asset('assets/libs/prismjs/prism.js')}}"></script>
    <script src="{{asset('assets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/libs/dropzone/dist/min/dropzone.min.js')}}"></script>
    <script src="{{asset('assets/libs/prismjs/plugins/toolbar/prism-toolbar.min.js')}}"></script>
    <script src="{{asset('assets/libs/prismjs/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js')}}"></script>
    <!-- Optional JavaScript -->
    @yield('custom_script')

    <!-- Theme JS -->
    <script src="{{asset('assets/js/theme.min.js')}}"></script>
</body>

</html>