<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <link rel="icon" href="{{ asset('images/fav_logo.png') }}">
        <meta name="author" content="">
        <title>SMT</title>
        <link href="{{asset('css/themes/theme.css')}}" rel="stylesheet">
    </head>
    <body class="bg-gradient-primary">
        <div class="container">
            @yield('content')
        </div>
        <?php $baseUrl = env('APP_URL');?>
            <script>
                var baseUrl = <?php echo json_encode($baseUrl) ?>;
            </script>
        <!-- Custom scripts for all pages-->
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
