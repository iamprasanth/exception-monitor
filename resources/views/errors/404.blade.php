<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SMT</title>
    <!-- Custom fonts for this template-->
    {{-- <link href="all.min.css" rel="stylesheet" type="text/css"> --}}
    {{-- <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css"> --}}
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Css for theme -->
    <link href="{{asset('css/themes/theme.css')}}" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- 404 Error Text -->
        <div class="text-center">
            <div class="error mx-auto" data-text="404">404</div>
            <p class="lead text-gray-800 mb-5">Page Not Found</p>
            <p class="text-gray-500 mb-0">It looks like you found a glitch in the matrix...</p>
            <a href="{{ url('/') }}">&larr; Back to Dashboard</a>
        </div>
    </div>
    <!-- End of Page Content -->
    @include('layouts.footer')
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <?php $baseUrl = env('APP_URL');?>
    <script>
    var baseUrl = < ? php echo json_encode($baseUrl) ? > ;
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>