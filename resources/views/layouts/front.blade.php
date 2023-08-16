<!DOCTYPE html>
<html lang="en">

<head>
    <title>ALL Post</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Add your CSS links here -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ front_asset('css/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ front_asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ front_asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ front_asset('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ front_asset('css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ front_asset('css/aos.css') }}">
    <link rel="stylesheet" href="{{ front_asset('css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ front_asset('css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ front_asset('css/jquery.timepicker.css') }}">
    <link rel="stylesheet" href="{{ front_asset('css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ front_asset('css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ front_asset('css/style.css') }}">
    @stack('css')
</head>

<body>

    <div id="colorlib-page">
        <a href="#" class="js-colorlib-nav-toggle colorlib-nav-toggle"><i></i></a>
        <aside id="colorlib-aside" role="complementary" class="js-fullheight">
            <nav id="colorlib-main-menu" role="navigation">
                <ul>
                    <li class="colorlib-active"><a href="index-2.html">Home</a></li>
                </ul>
            </nav>
            <div class="colorlib-footer">
                <h1 id="colorlib-logo" class="mb-4"><a href="index-2.html"
                        style="background-image: url(images/bg_1.jpg);">Andrea <span>Moore</span></a></h1>
                <div class="mb-4">
                    <h3>Subscribe for newsletter</h3>
                    <form action="#" class="colorlib-subscribe-form">
                        <div class="form-group d-flex">
                            <div class="icon"><span class="icon-paper-plane"></span></div>
                            <input type="text" class="form-control" placeholder="Enter Email Address">
                        </div>
                    </form>
                </div>
                <p class="pfooter">
                    Copyright &copy;
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                </p>
            </div>
        </aside>
        <div id="colorlib-main">
            {{ $slot }}
        </div>
    </div>
    <script src="{{ front_asset('js/jquery.min.js') }}"></script>
    <script src="{{ front_asset('js/jquery-migrate-3.0.1.min.js') }}"></script>
    <script src="{{ front_asset('js/popper.min.js') }}"></script>
    <script src="{{ front_asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ front_asset('js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ front_asset('js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ front_asset('js/jquery.stellar.min.js') }}"></script>
    <script src="{{ front_asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ front_asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ front_asset('js/aos.js') }}"></script>
    <script src="{{ front_asset('js/jquery.animateNumber.min.js') }}"></script>
    <script src="{{ front_asset('js/scrollax.min.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&amp;sensor=false">
    </script>
    <script src="{{ front_asset('js/google-map.js') }}"></script>
    <script src="{{ front_asset('js/main.js') }}"></script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-23581568-13');
    </script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/v8b253dfea2ab4077af8c6f58422dfbfd1689876627854"
        integrity="sha512-bjgnUKX4azu3dLTVtie9u6TKqgx29RBwfj3QXYt5EKfWM/9hPSAI/4qcV5NACjwAo8UtTeWefx6Zq5PHcMm7Tg=="
        data-cf-beacon='{"rayId":"7f6fcfe50d0978bb","version":"2023.8.0","b":1,"token":"cd0b4b3a733644fc843ef0b185f98241","si":100}'
        crossorigin="anonymous"></script>
    <!-- Add your other script includes here -->
    @stack('scripts')
</body>

</html>
