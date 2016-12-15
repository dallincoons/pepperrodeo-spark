<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/sweetalert.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/sweetalert2.min.css">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    <link href="https://fonts.googleapis.com/css?family=Leckerli+One" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <!-- Global Spark Object -->
    <script>
        window.Spark = <?php echo json_encode(array_merge(
                Spark::scriptVariables(), []
        )); ?>;
    </script>
    @include('includes.javascript')

</head>
<body>
    <div id="spark-app">
        <aside id="large-sidebar">
            @unless(!\Auth::user())
                @include('includes.navs.desktop')
            @endunless

            @unless(!\Auth::user())
                @include('includes.footer')
            @endunless
        </aside>

        <div id="main-content">

            @unless(!\Auth::user())
                <header id="header-mobile">
                    <h1>Pepper Rodeo</h1>
                </header>
            @endunless

            @yield('content')

            <nav id="nav-mobile">
                @unless(!\Auth::user())
                    @include('includes.navs.mobile')
                @endunless
            </nav>
        </div>
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <script src="/js/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.6.0/parsley.min.js"></script>

</body>
</html>
