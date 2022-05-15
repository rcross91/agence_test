 <aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User Profile-->
        <div class="user-profile">
            <div class="user-pro-body">
                <div>
                    <img src="{{asset('images/user.png')}}" alt="user-img" class="img-circle">
                </div>
                <div class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle u-dropdown link hide-menu" data-toggle="dropdown" role="button" aria-haspopup="true"
                        aria-expanded="false">Rafael Cruz Enjamio
                        <span class="caret"></span>
                    </a>
                    
                </div>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li >
                    <a aria-expanded="false" style="color: #8d97ad;">
                        <i class="ti-home"></i>
                        <span class="hide-menu">Agence</span>
                    </a>
                </li>

                <li >
                    <a aria-expanded="false" style="color: #8d97ad;">
                        <i class="ti-briefcase"></i>
                        <span class="hide-menu">Proyectos</span>
                    </a>
                </li>

                <li >
                    <a aria-expanded="false" style="color: #8d97ad;">
                        <i class="ti-pencil-alt"></i>
                        <span class="hide-menu">Administrativo</span>
                    </a>
                </li>

                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="ti-settings"></i>
                        <span class="hide-menu">Comercial
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{URL::to('performanceComercial')}}">Performance Comercial</a></li>
                    </ul>
                </li>

                <li >
                    <a aria-expanded="false"style="color: #8d97ad;">
                        <i class="ti-stats-up"></i>
                        <span class="hide-menu">Financiero</span>
                    </a>
                </li>

                 <li >
                    <a aria-expanded="false" style="color: #8d97ad;">
                        <i class="ti-user"></i>
                        <span class="hide-menu">Usuario</span>
                    </a>
                </li>

                <li>
                    <a class="waves-effect waves-dark"aria-expanded="false" style="color: #8d97ad;"
                        >
                        <i class="far fa-circle text-success"></i>
                        <span class="hide-menu">Cerrar sesion</span>
                        
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>