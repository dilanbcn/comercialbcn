<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
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