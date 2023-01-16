<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="icon" href="{{ asset('images/fav_logo.png') }}">
        <meta name="author" content="">
        <title>SMT</title>
        <link href="{{asset('css/themes/theme.css')}}" rel="stylesheet">
    </head>
    <body id="page-top" class="sidebar-toggled">
        @php $apps = getApplications(); @endphp
        <div id="wrapper">
            @if(count($apps)) @include('layouts.sidebar') @endif
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    @include('layouts.header', ['apps' => $apps])
                    @yield('content')
                </div>
                @include('layouts.footer')
            </div>
        </div>
        <!-- Scroll to Top Button -->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <!-- Loading spinner -->
        <div class="loader-wrapper">        
            <div class="half-circle-spinner">
                <div id="spinner-text" class="loader-text"></div>
                <div class="circle circle-1"></div>
                <div class="circle circle-2"></div>
            </div>
        </div>
        <?php $baseUrl = env('APP_URL');
        $constants = Config::get('constants'); ?>
            <script>
                var constants = <?php echo json_encode($constants) ?>;
                var baseUrl = <?php echo json_encode($baseUrl) ?>;
            </script>
        <script src="{{ asset('js/app.js') }}"></script>
        @yield('scripts')
    </body>
</html>
