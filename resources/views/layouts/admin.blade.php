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
    <link href="{{ asset('/theme/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
    <!-- Drop Zone -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />

    <link href="{{ asset('/theme/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('/theme/css/style.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('/theme/css/plugins/dropzone/basic.css') }}" rel="stylesheet">
    <link href="{{ asset('/theme/css/plugins/dropzone/dropzone.css') }}" rel="stylesheet"> -->
    <script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>
    <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">

    <!-- Scripts
    <script src="{{ asset('js/app.js') }}" defer></script> -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/b-1.5.6/r-2.2.2/datatables.min.css"/> --}}
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    <!--------------------------->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/b-1.5.6/r-2.2.2/datatables.min.css"/> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>

<body>
    <div id="app">
        <div id="wrapper">
            @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
            @endif
            @else
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav metismenu" id="side-menu">
                        <li class="nav-header">
                            <div class="dropdown profile-element">
                                <img alt="image" class="img-circle" src="{{ asset('/theme/img/profile_small.jpg')}}" />
                                </span>
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">David Williams</strong>
                                        </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                    <li><a href="profile.html">Profile</a></li>
                                    <li><a href="contacts.html">Contacts</a></li>
                                    <li><a href="mailbox.html">Mailbox</a></li>
                                    <li class="divider"></li>
                                    <li><a href="login.html">Logout</a></li>
                                </ul>
                            </div>
                            <div class="logo-element">
                                IN+
                            </div>
                        </li>

                        <li class="nav-body" style="margin-top:20px;">

                            <ul>
                                @can('viewAny',App\Role::class)
                                <li style="padding-bottom:5px"><a href="{{ route('roles.index') }}" style="color: #fff;font-size: 15px;">Roles</a></li>
                                @endcan
                                @can('viewAny',App\City::class)
                                <li style="padding-bottom:5px"><a href="{{ route('cities.index') }}" style="color: #fff;font-size: 15px;">Cities</a></li>
                                @endcan
                                @can('viewAny',App\Job::class)
                                <li style="padding-bottom:5px"><a href="{{ route('jobs.index') }}" style="color: #fff;font-size: 15px;">Jobs</a></li>
                                @endcan
                                @can('viewAny',App\StaffMember::class)
                                <li style="padding-bottom:5px"><a href="{{ route('staff.index') }}" style="color: #fff;font-size: 15px;">Staff Members</a></li>
                                @endcan
                                @can('viewAny',App\Visitor::class)
                                <li style="padding-bottom:5px"><a href="{{ route('visitors.index') }}" style="color: #fff;font-size: 15px;">Visitors</a></li>
                                @endcan
                                @can('viewAny',App\News::class)
                                <li style="padding-bottom:5px"><a href="{{ route('news.index') }}" style="color: #fff;font-size: 15px;">News</a></li>
                                @endcan
                            </ul>
                        </li>
                    </ul>

                </div>
            </nav>
            <div id="page-wrapper" class="gray-bg">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                        </div>
                        <ul class="nav navbar-top-links navbar-right">
                            <li>
                                <span class="m-r-sm text-muted welcome-message">Welcome to INSPINIA+ Admin Theme.</span>
                            </li>

                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i> {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                            @endguest
                        </ul>

                    </nav>
                </div>
                <!--
                /************************/
                /************************/
                /***** Start Content ****/
                /************************/
                /************************/
                 -->
                <div class="wrapper wrapper-content">
                    <!-- content  -->
                    <main>
                        @yield('content')
                    </main>

                </div>
                <!--
                /************************/
                /************************/
                /****** End Content *****/
                /************************/
                /************************/
                 -->
                <!-- <div class="footer">
                    <div class="pull-right">
                        10GB of <strong>250GB</strong> Free.
                    </div>
                    <div>
                        <strong>Copyright</strong> Example Company &copy; 2014-2017
                    </div>
                </div> -->
            </div>


        </div>
    </div>

    <script src="{{ asset('/theme/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/theme/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('/theme/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>


    <!-- jQuery UI -->
    <script src="{{ asset('/theme/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- Jvectormap -->
    <script src="{{ asset('/theme/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('/theme/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- dataTables linkes -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
    <!-- Chosen -->
    <script src="{{ asset('/theme/js/plugins/chosen/chosen.jquery.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('/theme/js/plugins/select2/select2.full.min.js') }}"></script>
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- Drop Zone -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
    @yield('script')
    @yield('fileZoneScript')

    <!-- JS Validtion -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    @yield('validation')
</body>

</html>