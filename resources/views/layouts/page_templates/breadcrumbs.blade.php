<nav aria-label="breadcrumb">
  <ol class="breadcrumb bg-light">
    <li class="breadcrumb-item"><a href="{{ (auth()->user()->rol_id == 1 || auth()->user()->rol_id == 3) ? '/home-comercial' : '/home-prospector' }}">Inicio</a></li>
    @if (isset(auth()->user()->breadcrumbs))
    @foreach(auth()->user()->breadcrumbs as $miga)
    <li class="breadcrumb-item {{ (!$miga['ruta']) ? 'active' : ''}} ">
      @if(!$miga['ruta'])
      {{ $miga['nombre'] }}
      @else
      <a href="{{ $miga['ruta'] }}">{{ $miga['nombre'] }}</a>
      @endif
    </li>
    @endforeach
    @endif
  </ol>
</nav>