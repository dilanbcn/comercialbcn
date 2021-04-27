@extends('layouts.app', [
'class' => '',
'elementActive' => $active
])
@section('content')
@include('layouts.page_templates.messages')
<div class="content" id="msg-modal" data-valor="{{ ($errors->any()) ? 1 : 0 }}" data-nombre="add_reunion" data-update="updt_reunion">
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title mb-1">Calendario Reuniones</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title mb-1">Comunicaciones</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="list-group card-scroll">
                        @if(count($comunicaciones) > 0)

                        @foreach($comunicaciones as $comunicacion)
                        <a href="#" id="{{ $comunicacion->id }}" class="list-group-item list-group-item-action flex-column align-items-start comunicacionEdit">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $comunicacion->cliente->razon_social }}</h5>
                                <small>{{ date('d/m/Y', strtotime($comunicacion->fecha_contacto)) }}</small>
                            </div>
                            <p class="mb-1">{{ $comunicacion->observaciones }}</p>
                            <small><i class="{{ $comunicacion->tipoComunicacion->icono }}"></i> {{ $comunicacion->tipoComunicacion->nombre }}</small>
                        </a>
                        @endforeach
                        @else
                        <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                            <p class="mb-1">No hay comunicaciones</p>
                        </a>
                        @endif
                        
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('pages.cliente_calendario.modal_add_reunion')
@include('pages.cliente_calendario.modal_update_reunion')
@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.5.1/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.5.1/locales-all.js'></script>
<script src="{{ asset('paper/js/calendario.js?v='.time()) }}"></script>
@endpush