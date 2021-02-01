<nav class="navbar navbar-expand-lg navbar navbar-dark bg-success">
    <div class="container-fluid">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <a href="{{ (auth()->user()->rol_id == 2) ? route('home') : route('user.perfil') }}">
                <img src="{{ asset('paper/img/logo_bcn_horizon.png') }}" height="50" class="d-inline-block align-top" alt="">
            </a>
            <ul class="navbar-nav mr-auto ml-5">
                <li class="nav-item {{ $elementActive == 'dashboard' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ (auth()->user()->rol_id == 2) ? route('home') : route('user.perfil') }}">Inicio <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item btn-rotate dropdown {{ $elementActive == 'comerciales' ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Comerciales 
                        <p>
                            <span class="d-lg-none d-md-block">{{ __('Comerciales') }}</span>
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('user.index') }}">{{ __('Lista de Comerciales') }}</a>
                        <a class="dropdown-item" href="{{ route('user.grafico') }}">{{ __('Detalle Comerciales') }}</a>
                    </div>
                </li>
                <li class="nav-item btn-rotate dropdown {{ ($elementActive == 'clientes' || $elementActive == 'contacto') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Clientes 
                        <p>
                            <span class="d-lg-none d-md-block">{{ __('Clientes') }}</span>
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('cliente.index') }}">{{ __('Lista de Clientes') }}</a>
                        <a class="dropdown-item" href="{{ route('cliente.prospectos') }}">{{ __('Prospectos Disponibles') }}</a>
                    </div>
                </li>
                <li class="nav-item btn-rotate dropdown {{ $elementActive == 'comerciales' ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Prospección 
                        <p>
                            <span class="d-lg-none d-md-block">{{ __('Prospección') }}</span>
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">{{ __('Asignacion de Prospectores') }}</a>
                        <a class="dropdown-item" href="#">{{ __('Llamados y Reuniones') }}</a>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item btn-rotate dropdown">
                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="far fa-user"></i>
                        <p>
                            <span class="d-lg-none d-md-block">{{ __('Some Actions') }}</span>
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">{{ __('Perfil') }}</a>
                        <a class="dropdown-item" href="{{ route('logout') }}">{{ __('Cerrar Sesión') }}</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>