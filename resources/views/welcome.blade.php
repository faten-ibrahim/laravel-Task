<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laravel</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('/theme/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Animation CSS -->
    <link href="{{ asset('/theme/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('/theme/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('/theme/css/style.css') }}" rel="stylesheet">



</head>

<body id="page-top" class="landing-page no-skin-config">
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ url('/home') }}">Home</a>
            @else
            <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
            @endif
            @endauth
        </div>
        @endif
        <div class="navbar-wrapper">
            <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
                <div class="container">
                    <div class="navbar-header page-scroll">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.html">WEBAPPLAYERS</a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a class="page-scroll" href="#page-top">Home</a></li>
                            <li><a class="page-scroll" href="#features">Features</a></li>
                            <li><a class="page-scroll" href="#team">Team</a></li>
                            <li><a class="page-scroll" href="#testimonials">Testimonials</a></li>
                            <li><a class="page-scroll" href="#pricing">Pricing</a></li>
                            <li><a class="page-scroll" href="#contact">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div id="inSlider" class="carousel carousel-fade" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#inSlider" data-slide-to="0" class="active"></li>
                <li data-target="#inSlider" data-slide-to="1"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>We craft<br />
                                brands, web apps,<br />
                                and user interfaces<br />
                                we are IN+ studio</h1>
                            <p>Lorem Ipsum is simply dummy text of the printing.</p>
                            <p>
                                <a class="btn btn-lg btn-primary" href="#" role="button">READ MORE</a>
                                <a class="caption-link" href="#" role="button">Inspinia Theme</a>
                            </p>
                        </div>
                        <div class="carousel-image wow zoomIn">
                            <img src="img/landing/laptop.png" alt="laptop" />
                        </div>
                    </div>
                    <!-- Set background for slide in css -->
                    <div class="header-back one"></div>

                </div>
                <div class="item">
                    <div class="container">
                        <div class="carousel-caption blank">
                            <h1>We create meaningful <br /> interfaces that inspire.</h1>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam.</p>
                            <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
                        </div>
                    </div>
                    <!-- Set background for slide in css -->
                    <div class="header-back two"></div>
                </div>
            </div>
            <a class="left carousel-control" href="#inSlider" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#inSlider" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <section id="features" class="container services">
            <div class="row">
                <div class="col-sm-3">
                    <h2>Full responsive</h2>
                    <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus.</p>
                    <p><a class="navy-link" href="#" role="button">Details &raquo;</a></p>
                </div>
                <div class="col-sm-3">
                    <h2>LESS/SASS Files</h2>
                    <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus.</p>
                    <p><a class="navy-link" href="#" role="button">Details &raquo;</a></p>
                </div>
                <div class="col-sm-3">
                    <h2>6 Charts Library</h2>
                    <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus.</p>
                    <p><a class="navy-link" href="#" role="button">Details &raquo;</a></p>
                </div>
                <div class="col-sm-3">
                    <h2>Advanced Forms</h2>
                    <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus.</p>
                    <p><a class="navy-link" href="#" role="button">Details &raquo;</a></p>
                </div>
            </div>
        </section>


        <!-- Mainly scripts -->
        <link href="{{ asset('/theme/css/style.css') }}" rel="stylesheet">
        <script src="{{ asset('/theme/js/jquery-3.1.1.min.js') }}"></script>
        <script src="{{ asset('/theme/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('/theme/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
        <script src="{{ asset('/theme/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

        <!-- Custom and plugin javascript -->
        <script src="{{ asset('/theme/js/inspinia.js') }}"></script>
        <script src="{{ asset('/theme/js/plugins/pace/pace.min.js') }}"></script>
        <script src="{{ asset('/theme/js/plugins/wow/wow.min.js') }}"></script>


        <script>
            $(document).ready(function() {

                $('body').scrollspy({
                    target: '.navbar-fixed-top',
                    offset: 80
                });

                // Page scrolling feature
                $('a.page-scroll').bind('click', function(event) {
                    var link = $(this);
                    $('html, body').stop().animate({
                        scrollTop: $(link.attr('href')).offset().top - 50
                    }, 500);
                    event.preventDefault();
                    $("#navbar").collapse('hide');
                });
            });

            var cbpAnimatedHeader = (function() {
                var docElem = document.documentElement,
                    header = document.querySelector('.navbar-default'),
                    didScroll = false,
                    changeHeaderOn = 200;

                function init() {
                    window.addEventListener('scroll', function(event) {
                        if (!didScroll) {
                            didScroll = true;
                            setTimeout(scrollPage, 250);
                        }
                    }, false);
                }

                function scrollPage() {
                    var sy = scrollY();
                    if (sy >= changeHeaderOn) {
                        $(header).addClass('navbar-scroll')
                    } else {
                        $(header).removeClass('navbar-scroll')
                    }
                    didScroll = false;
                }

                function scrollY() {
                    return window.pageYOffset || docElem.scrollTop;
                }
                init();

            })();

            // Activate WOW.js plugin for animation on scrol
            new WOW().init();
        </script>

</body>

</html>