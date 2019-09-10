<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Resto') }}</title>

    <link href="{{ asset('/theme/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/theme/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('/theme/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('/theme/css/style.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {!! htmlScriptTagJsApi() !!}

</head>

<body style="background-color:#f5f5f5;">
    <div id="app" style="margin-top: 4%">


        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('/theme/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('/theme/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/theme/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('/theme/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

    <!-- Flot -->
    <script src="{{ asset('/theme/js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('/theme/js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('/theme/js/plugins/flot/jquery.flot.spline.js') }}"></script>
    <script src="{{ asset('/theme/js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('/theme/js/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('/theme/js/plugins/flot/jquery.flot.symbol.js') }}"></script>
    <script src="{{ asset('/theme/js/plugins/flot/jquery.flot.time.js') }}"></script>

    <!-- Peity -->
    <script src="{{ asset('/theme/js/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('/theme/js/demo/peity-demo.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('/theme/js/inspinia.js') }}"></script>
    <script src="{{ asset('/theme/js/plugins/pace/pace.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('/theme/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- Jvectormap -->
    <script src="{{ asset('/theme/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('/theme/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

    <!-- EayPIE -->
    <script src="{{ asset('/theme/js/plugins/easypiechart/jquery.easypiechart.js') }}"></script>

    <!-- Sparkline -->
    <script src="{{ asset('/theme/js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Sparkline demo data  -->
    <script src="{{ asset('/theme/js/demo/sparkline-demo.js') }}"></script>


</body>

</html>