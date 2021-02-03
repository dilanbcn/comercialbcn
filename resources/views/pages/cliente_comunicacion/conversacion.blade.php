@extends('layouts.app', [
'class' => '',
'elementActive' => 'prospeccion'
])
@section('content')
<div class="content" id="msg-modal" data-valor="{{ ($errors->any()) ? 1 : 0 }}" data-nombre="add_comunicacion_conversacion">
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
                            <a role="button" href="{{ route('comunicacion.index') }}" class="btn btn-sm btn-danger btn-round">{{ __('Regresar') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4><i class="far fa-envelope"></i> Correos</h4>
                                            <ul class="timeline">
                                                @if (isset($comunicaciones[1]))
                                                @foreach($comunicaciones[1] as $correo)
                                                <li>
                                                    <div class="row bg-light mr-2 pt-2 pb-2">
                                                        <div class="col-8">
                                                        <p class="mb-1"><a target="_blank" href="#">{{ $correo->comercial_nombre }}</a></p>
                                                            <p class="mb-1">{{ ($correo->fecha_contacto) ? 'Fecha Contacto: '.date('d/m/Y', strtotime($correo->fecha_contacto)) : '' }}<p>
                                                            <p class="mb-1">
                                                                <span class="badge badge-info p-2 mr-1" {{ ($correo->linkedin == 1) ? '' : 'hidden' }}>LinkedIn <i class="fas fa-check"></i></span>
                                                                <span class="badge badge-warning p-2 mr-1" {{ ($correo->envia_correo == 1) ? '' : 'hidden' }}>Envía Correo <i class="fas fa-check"></i></span>
                                                                <span class="badge badge-success p-2 mr-1" {{ ($correo->respuesta == 1) ? '' : 'hidden' }}>Respuesta <i class="fas fa-check"></i></span>
                                                            </p>
                                                        </div>
                                                        <div class="col-4 text-right">
                                                            <p class="mb-1"><a href="#">{{ date('d/m/Y H:i:s', strtotime($correo->created_at)) }}</a></p>
                                                            
                                                            @if ($correo->fecha_reunion)
                                                            <p class="mb-1">
                                                                @if($correo->reunion_valida == 1)
                                                                <button type="button"  class="btn btn-success btn-xs"><i class="fas fa-calendar-check"></i></button>
                                                                @else
                                                                <button type="button" class="btn btn-secondary btn-xs validarReunion" data-ruta="{{ route('comunicacion.validar', $correo->id) }}"><i class="far fa-calendar-alt"></i></button> 
                                                                @endif
                                                                {{ ($correo->fecha_reunion) ? 'Reunión: ' . date('d/m/Y H:i', strtotime($correo->fecha_reunion)) : ''}}</p>
                                                            @endif
                                                        </div>
                                                        <div class="col-12 text-justify">
                                                            <p class="mt-3">{{ $correo->observaciones}}</p>
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
                        <div class="col-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4><i class="fas fa-phone"></i> Llamadas</h4>
                                            <ul class="timeline">
                                            @if (isset($comunicaciones[2]))
                                                @foreach($comunicaciones[2] as $llamada)
                                                <li>
                                                    <div class="row bg-light mr-2 pt-2 pb-2">
                                                        <div class="col-8">
                                                        <p class="mb-1"><a target="_blank" href="#">{{ $llamada->comercial_nombre }}</a></p>
                                                            <p class="mb-1">{{ ($llamada->fecha_contacto) ? 'Fecha Contacto: '.date('d/m/Y', strtotime($llamada->fecha_contacto)) : '' }}<p>
                                                            <p class="mb-1">
                                                                <span class="badge badge-info p-2 mr-1" {{ ($llamada->linkedin == 1) ? '' : 'hidden' }}>LinkedIn <i class="fas fa-check"></i></span>
                                                                <span class="badge badge-warning p-2 mr-1" {{ ($llamada->envia_correo == 1) ? '' : 'hidden' }}>Envía Correo <i class="fas fa-check"></i></span>
                                                                <span class="badge badge-success p-2 mr-1" {{ ($llamada->respuesta == 1) ? '' : 'hidden' }}>Respuesta <i class="fas fa-check"></i></span>
                                                            </p>
                                                        </div>
                                                        <div class="col-4 text-right">
                                                            <p class="mb-1"><a href="#">{{ date('d/m/Y H:i:s', strtotime($llamada->created_at)) }}</a></p>
                                                            
                                                            @if ($llamada->fecha_reunion)
                                                            <p class="mb-1">
                                                                @if($llamada->reunion_valida == 1)
                                                                <button type="button"  class="btn btn-success btn-xs"><i class="fas fa-calendar-check"></i></button>
                                                                @else
                                                                <button type="button" class="btn btn-secondary btn-xs validarReunion" data-ruta="{{ route('comunicacion.validar', $llamada->id) }}"><i class="far fa-calendar-alt"></i></button> 
                                                                @endif
                                                                {{ ($llamada->fecha_reunion) ? 'Reunión: ' . date('d/m/Y H:i', strtotime($llamada->fecha_reunion)) : ''}}</p>
                                                            @endif
                                                        </div>
                                                        <div class="col-12 text-justify">
                                                            <p class="mt-3">{{ $llamada->observaciones}}</p>
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
@include('layouts.page_templates.form_validar')
@endsection