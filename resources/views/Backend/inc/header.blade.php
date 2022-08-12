<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">



        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="{{asset("Frontend/avatar.png")}}" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline">{{\Illuminate\Support\Facades\Auth::user()->name}}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                    <img src="{{asset("Frontend/avatar.png")}}" class="img-circle elevation-2" alt="User Image">

                    <p>
                        {{\Illuminate\Support\Facades\Auth::user()->name}} - {{\Illuminate\Support\Facades\Auth::user()->email}}


                    </p>
                </li>
                <!-- Menu Body -->

                <!-- Menu Footer-->
                <li class="user-footer">
                    <a href="/" target="_blank" class="btn btn-default btn-flat">Siteyi Aç</a>
                    <a href="{{route("Backend.logout")}}" class="btn btn-default btn-flat float-right">Sign out</a>
                </li>
            </ul>
        </li>


    </ul>
</nav>
<!-- /.navbar -->
