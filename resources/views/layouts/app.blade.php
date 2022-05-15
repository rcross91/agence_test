<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
   
    <meta name="description" content="Agence Test" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{config('app.name')}} | @yield('title')</title>
   
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <!-- Styles -->
   
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{asset('assets/node_modules/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/node_modules/bootstrap-select/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/node_modules/multiselect/css/multi-select.css')}}" rel="stylesheet" />
  
   
        <!-- Custom CSS -->
    <link href="{{asset('css/style.min.css')}}" rel="stylesheet">
      
    @yield('style')
</head>
<body class="skin-default fixed-layout">
    <div id="app">
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">{{config('app.name')}} </p>
            </div>
        </div>

        <div id="main-wrapper">
            @include('partials.topbar')
            @include('partials.sidebar')

            <div class="page-wrapper">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            
        </div>
    </div>
    
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.js') }}"></script>

    <script src="{{ asset('dist/js/perfect-scrollbar.jquery.min.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('dist/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('dist/js/custom.min.js') }}"></script>
    
    <script src="{{ asset('assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/sweet-alert.init.js') }}"></script>
    <script src="{{ asset('assets/node_modules/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('assets/node_modules/multiselect/js/jquery.multi-select.js') }}"></script>
    <script src="{{asset('assets/inputmask/dist/inputmask/inputmask.js')}}"></script>
    <script src="{{asset('assets/inputmask/dist/inputmask/jquery.inputmask.js')}}"></script>
    <script src="{{asset('assets/inputmask/dist/inputmask/inputmask.date.extensions.js')}}"></script>
    <script src="{{ asset('assets/node_modules/multiselect/js/jquery.multi-select.js') }}" type="text/javascript"></script>

    @yield('javascript')
</body>
</html>