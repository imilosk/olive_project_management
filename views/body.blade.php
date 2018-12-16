<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Home</title>

        <!-- CSS, Fonts, Links -->
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/style.css" />
    </head>

    <body class="preload">
        @yield('content')  
        <!--
        <header class="header-wrapper">
            @include('includes/navbar')
        </header>
        

        <div class="container">
            @yield('content')  
        </div>
        -->
        <!-- JS Scripts -->
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/calendar.js"></script>
        <script type="text/javascript" src="js/script.js"></script>
    </body>

</html>