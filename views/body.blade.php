<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Home</title>

        <!-- CSS, Fonts, Links -->
        <link rel="stylesheet" href="css/bootstrap.min.css" />
    </head>

    <body class="preload">
        <header class="header-wrapper">
            @include('includes/navbar')
        </header>
        
        <div class="container">
            <div class="row">
                <div class="column-12">
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- JS Scripts -->
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/calendar.js"></script>
    </body>

</html>