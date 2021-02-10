@extends('layouts.app', [
'class' => '',
'elementActive' => 'reuniones'
])
@section('content')
<div class="content" id="msg-modal" data-valor="{{ ($errors->any()) ? 1 : 0 }}" data-nombre="add_comunicacion_conversacion" data-update="upd_comunicacion_conversacion">
    <div class="row">
        <div class="col-md-12">
            @include('layouts.page_templates.messages')
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="card-title mb-1">{{ 'Comunicación con ' . $cliente->razon_social }}</h5>
                        </div>
                        <div class="col-4 text-right">
                            <a href="#" class="btn btn-sm btn-secondary btn-round" id="btnAddComunicacion"><i class="fas fa-plus"></i> Agregar</a>
                            <a role="button" href="{{ route('cliente-comunicacion.index') }}" class="btn btn-sm btn-danger btn-round">{{ __('Regresar') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="timeline">
                                                @if (isset($comunicaciones))
                                                @foreach($comunicaciones as $comunicacion)
                                                <li>
                                                    <div class="row bg-light mr-2 pt-2 pb-2">
                                                        <div class="col-8">
                                                            <h4 class="mt-0 mb-1"><i class="{{ $comunicacion->tipoComunicacion->icono }}"></i> {{ $comunicacion->tipoComunicacion->nombre }}</h4>
                                                            <p class="mb-1"><a target="_blank" href="#">{{ $comunicacion->comercial_nombre }}</a></p>
                                                            <p class="mb-1">{{ ($comunicacion->fecha_contacto) ? 'Fecha Contacto: '.date('d/m/Y', strtotime($comunicacion->fecha_contacto)) : '' }}
                                                            <p>
                                                            <p class="mb-1">
                                                                <span class="badge badge-info p-2 mr-1" {{ ($comunicacion->linkedin == 1) ? '' : 'hidden' }}>LinkedIn <i class="fas fa-check"></i></span>
                                                                <span class="badge badge-warning p-2 mr-1" {{ ($comunicacion->envia_correo == 1) ? '' : 'hidden' }}>Envía Correo <i class="fas fa-check"></i></span>
                                                                <span class="badge badge-success p-2 mr-1" {{ ($comunicacion->respuesta == 1) ? '' : 'hidden' }}>Respuesta <i class="fas fa-check"></i></span>
                                                            </p>
                                                        </div>
                                                        <div class="col-4 text-right">
                                                            <p class="mb-1"><a href="#" title="Editar" class="btn btn-xs btn-outline-secondary btnEditComunicacion" data-editar="{{ route('cliente-comunicacion.edit', $comunicacion->id) }}" data-actualizar="{{ route('cliente-comunicacion.update', $comunicacion->id) }}"><i class="fa fa-edit"></i></a></p>
                                                            <p class="mb-1"><a href="#">{{ date('d/m/Y H:i:s', strtotime($comunicacion->created_at)) }}</a></p>
                                                            @if ($comunicacion->fecha_reunion)
                                                            <p class="mb-1">
                                                                @if($comunicacion->reunion_valida == 1)
                                                                <button type="button" class="btn btn-primary btn-xs"><i class="fas fa-calendar-check"></i></button>
                                                                @else
                                                                <button type="button" class="btn btn-secondary btn-xs validarReunion" data-ruta="{{ route('cliente-comunicacion.validar', $comunicacion->id) }}"><i class="far fa-calendar-alt"></i></button>
                                                                @endif
                                                                {{ ($comunicacion->fecha_reunion) ? 'Reunión: ' . date('d/m/Y H:i', strtotime($comunicacion->fecha_reunion)) : ''}}
                                                            </p>
                                                            @endif
                                                        </div>
                                                        <div class="col-12 text-justify">
                                                            <p class="mt-3">{{ $comunicacion->observaciones}}</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                                @else
                                                <li>
                                                    <p class="text-center">no hay registros</p>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('pages.cliente_comunicacion.modal_comunicacion_conversacion')
@include('pages.cliente_comunicacion.modal_comunicacion_conversacion_update')
@include('layouts.page_templates.form_validar')
@endsection