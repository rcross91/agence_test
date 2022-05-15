<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ url('/') }}">
                <!-- Logo icon --><b>
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon 
                    <img src="{{asset('images/logo-dark.png')}}" alt="homepage" class="dark-logo" />
                    Light Logo icon 
                    <img src="{{asset('images/logo-light.png')}}" alt="homepage" class="light-logo" />-->
                </b>
                <!--End Logo icon -->
                <!-- Logo text --><span>
                 <!-- dark Logo text -->
                 <img src="{{asset('images/logo.gif')}}" alt="homepage" class="dark-logo" />
                 <!-- Light Logo text -->    
                 <img src="{{asset('images/logo.gif')}}" class="light-logo" alt="homepage" /></span> </a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav mr-auto">
                <!-- This is  -->
                <li class="nav-item"> <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                <!-- ============================================================== -->
                <!-- Search -->
                <!-- ============================================================== -->
               
            </ul>
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <ul class="navbar-nav my-lg-0">
               
                <li class="nav-item right-side-toggle"> <a class="nav-link  waves-effect waves-light" href="javascript:void(0)"><i class="ti-settings"></i></a></li>
            </ul>
        </div>
    </nav>

</header>

<div class="right-sidebar">
    <div class="slimscrollright">
        <div class="rpanel-title"> Panel de Servicio <span><i class="ti-close right-side-toggle"></i></span> </div>
        <div class="r-panel-body">
            <ul id="themecolors" class="m-t-20">
                <li><b>Con barra lateral clara</b></li>
                <li><a href="javascript:void(0)" data-skin="skin-default" class="default-theme working">1</a></li>
                <li><a href="javascript:void(0)" data-skin="skin-green" class="green-theme">2</a></li>
                <li><a href="javascript:void(0)" data-skin="skin-red" class="red-theme">3</a></li>
                <li><a href="javascript:void(0)" data-skin="skin-blue" class="blue-theme">4</a></li>
                <li><a href="javascript:void(0)" data-skin="skin-purple" class="purple-theme">5</a></li>
                <li><a href="javascript:void(0)" data-skin="skin-megna" class="megna-theme">6</a></li>
                <li class="d-block m-t-30"><b>Con barra lateral oscura</b></li>
                <li><a href="javascript:void(0)" data-skin="skin-default-dark" class="default-dark-theme ">7</a></li>
                <li><a href="javascript:void(0)" data-skin="skin-green-dark" class="green-dark-theme">8</a></li>
                <li><a href="javascript:void(0)" data-skin="skin-red-dark" class="red-dark-theme">9</a></li>
                <li><a href="javascript:void(0)" data-skin="skin-blue-dark" class="blue-dark-theme">10</a></li>
                <li><a href="javascript:void(0)" data-skin="skin-purple-dark" class="purple-dark-theme">11</a></li>
                <li><a href="javascript:void(0)" data-skin="skin-megna-dark" class="megna-dark-theme ">12</a></li>
            </ul>
            
        </div>
    </div>
</div>