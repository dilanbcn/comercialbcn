<nav class="navbar navbar-expand-lg navbar navbar-dark bg-success">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <a href="{{ (auth()->user()->rol_id == 4 || auth()->user()->rol_id == 5) ? route('cliente-comunicacion.calendario') : route('home.comercial') }}">
                <img src="{{ asset('paper/img/logo_bcn_horizon.png') }}" height="50" class="d-inline-block align-top" alt="">
            </a>
            <ul class="navbar-nav mr-auto ml-5">
                <li class="nav-item {{ $elementActive == 'dashboard' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ (auth()->user()->rol_id == 4 || auth()->user()->rol_id == 5) ? route('cliente-comunicacion.calendario') : route('home.comercial') }}">Inicio <span class="sr-only">(current)</span></a>
                </li>
                @if(auth()->user()->rol_id == 2)
                <li class="nav-item btn-rotate dropdown {{ ($elementActive == 'comerciales' || $elementActive == 'detalle' || $elementActive == 'comerciales_new') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Comerciales
                        <p>
                            <span class="d-lg-none d-md-block">{{ __('Comerciales') }}</span>
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-navbar dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item {{ ($elementActive == 'comerciales_new') ? 'menu-activo' : '' }}" href="{{ route('user.create') }}">{{ __('Nuevo Comercial') }}</a>
                        <a class="dropdown-item {{ ($elementActive == 'comerciales') ? 'menu-activo' : '' }}" href="{{ route('user.index') }}">{{ __('Lista de Comerciales') }}</a>
                        <a class="dropdown-item {{ ($elementActive == 'detalle') ? 'menu-activo' : '' }}" href="{{ route('user.grafico') }}">{{ __('Detalle Comerciales') }}</a>
                    </div>
                </li>
                @endif
                @if(auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2)
                @if (auth()->user()->rol_id == 2)
                <li class="nav-item btn-rotate dropdown {{ ($elementActive == 'cliente_nuevo' || $elementActive == 'clientes') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Clientes General
                        <p>
                            <span class="d-lg-none d-md-block">{{ __('Clientes General') }}</span>
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-navbar dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item {{ ($elementActive == 'cliente_nuevo') ? 'menu-activo' : '' }}" href="{{ route('cliente.create') }}">{{ __('Nuevo Cliente') }}</a>
                        <a class="dropdown-item {{ ($elementActive == 'clientes') ? 'menu-activo' : '' }}" href="{{ route('cliente.index') }}">{{ __('Lista de Clientes') }}</a>
                    </div>
                </li>
                @else
                <li class="nav-item {{ $elementActive == 'clientes' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('cliente.index') }}">{{ __('Clientes General') }}</a>
                </li>
                @endif
                <li class="nav-item {{ $elementActive == 'prospectos' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('cliente.prospectos') }}">{{ __('Prospectos Disponibles') }}</a>
                </li>
                <li class="nav-item {{ $elementActive == 'vigencia' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('cliente.vigencia') }}">{{ __('Vigencia Clientes') }}</a>
                </li>
                <li class="nav-item {{ $elementActive == 'cerrados' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('cliente.cerrados') }}">{{ __('Cerrados') }}</a>
                </li>
                <!-- <li class="nav-item {{ $elementActive == 'productos' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('producto.index') }}">Productos</a>
                </li>
                <li class="nav-item {{ $elementActive == 'indica_comercial' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('comercial.indicadores') }}">Indicadores</a>
                </li>
                <li class="nav-item btn-rotate dropdown {{ ($elementActive == 'clientes' || $elementActive == 'prospectos' || $elementActive == 'vigencia' || $elementActive == 'cerrados') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Clientes
                        <p>
                            <span class="d-lg-none d-md-block">{{ __('Clientes') }}</span>
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item {{ ($elementActive == 'clientes') ? 'menu-activo' : '' }}" href="{{ route('cliente.index') }}">{{ __('Clientes General') }}</a>
                        <a class="dropdown-item {{ ($elementActive == 'prospectos') ? 'menu-activo' : '' }}" href="{{ route('cliente.prospectos') }}">{{ __('Prospectos Disponibles') }}</a>
                        <a class="dropdown-item {{ ($elementActive == 'vigencia') ? 'menu-activo' : '' }}" href="{{ route('cliente.vigencia') }}">{{ __('Vigencia Clientes') }}</a>
                        @if(auth()->user()->rol_id == 2)
                        <a class="dropdown-item {{ ($elementActive == 'cerrados') ? 'menu-activo' : '' }}" href="{{ route('cliente.cerrados') }}">{{ __('Cerrados') }}</a>
                        @endif
                    </div>
                </li> -->
                @endif
                @if(auth()->user()->rol_id == 4)
                <li class="nav-item {{ $elementActive == 'comerciales' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('user.index') }}">{{ __('Prospectores') }}</a>
                </li>
                @endif
                @if(auth()->user()->rol_id == 4 || auth()->user()->rol_id == 5 )
                <li class="nav-item {{ $elementActive == 'contactos' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('prospeccion.contactos') }}">{{ __('Contactos') }}</a>
                </li>

                <li class="nav-item {{ $elementActive == 'reuniones' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('cliente-comunicacion.index') }}">{{ __('Llamados y Reuniones') }}</a>
                </li>
                <li class="nav-item {{ $elementActive == 'calendario' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('cliente-comunicacion.calendario') }}">{{ __('Calendario') }}</a>
                </li>

                @if(auth()->user()->rol_id == 4)
                <li class="nav-item {{ $elementActive == 'asignacion' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('prospeccion.asignacion.index') }}">{{ __('Asignacion de Prospectores') }}</a>
                </li>
                <li class="nav-item {{ $elementActive == 'indicadores' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('prospeccion.indicadores') }}">{{ __('Indicadores') }}</a>
                </li>
                @endif

                <!-- <li class="nav-item btn-rotate dropdown {{ ($elementActive == 'contactos' || $elementActive == 'asignacion' || $elementActive == 'reuniones' || $elementActive == 'calendario' || $elementActive == 'indicadores') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Prospección
                        <p>
                            <span class="d-lg-none d-md-block">{{ __('Prospección') }}</span>
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item {{ ($elementActive == 'contactos') ? 'menu-activo' : '' }}" href="{{ route('prospeccion.contactos') }}">{{ __('Contactos') }}</a>
                        @if(auth()->user()->rol_id == 4)
                        <a class="dropdown-item {{ ($elementActive == 'asignacion') ? 'menu-activo' : '' }}" href="{{ route('prospeccion.asignacion.index') }}">{{ __('Asignacion de Prospectores') }}</a>
                        @endif
                        <a class="dropdown-item {{ ($elementActive == 'reuniones') ? 'menu-activo' : '' }}" href="{{ route('cliente-comunicacion.index') }}">{{ __('Llamados y Reuniones') }}</a>
                        <a class="dropdown-item {{ ($elementActive == 'calendario') ? 'menu-activo' : '' }}" href="{{ route('cliente-comunicacion.calendario') }}">{{ __('Calendario Reuniones') }}</a>
                        @if(auth()->user()->rol_id == 4)
                        <a class="dropdown-item {{ ($elementActive == 'indicadores') ? 'menu-activo' : '' }}" href="{{ route('prospeccion.indicadores') }}">{{ __('Indicadores') }}</a>
                        @endif
                    </div>
                </li> -->
                @endif
            </ul>

        </div>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <div class="col-6 text-right text-white">
                &nbsp;
                Hola, {{ auth()->user()->name }}
            </div>

            <ul class="navbar-nav">
                <li class="nav-item btn-rotate dropdown">
                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="far fa-user"></i>
                        <p>
                            <span class="d-lg-none d-md-block">{{ __('Some Actions') }}</span>
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-navbar dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('logout') }}">{{ __('Cerrar Sesión') }}</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
@include('layouts.page_templates.breadcrumbs')