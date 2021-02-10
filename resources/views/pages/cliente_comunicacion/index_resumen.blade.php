@extends('layouts.app', [
'class' => '',
'elementActive' => 'reuniones'
])
@section('content')
<div class="content" id="msg-modal" data-valor="{{ ($errors->any()) ? 1 : 0 }}" data-nombre="add_cliente_comunicacion">
    <div class="row">
        <div class="col-md-12">
            @include('layouts.page_templates.messages')
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="card-title mb-1">Comuncacion Resumen</h5>
                        </div>
                        <div class="col-4 text-right">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped tablaComercialesIndex">
                            <thead class="text-primary text-center">
                                <th>Prospector</th>
                                <th>Comercial</th>
                                <th>Cliente</th>
                                <th>N° Trabajadores</th>
                                <th>Rubro</th>
                                <th>Nombre Contacto</th>
                                <th>Fono Fijo</th>
                                <th>Correo</th>
                                <th>Celular</th>
                                <th>Fecha Contacto</th>
                                <th>Acepta LinkedIn</th>
                                <th>Envía Correo</th>
                                <th>Fecha Reunión</th>
                                <th>Observaciones</th>
                            </thead>
                            <tbody>
                                @foreach($comunicaciones as $key => $comunicacion)
                                <tr class="text-center">
                                    <td class="text-left">{{ $comunicacion->prospector_nombre }}</td>
                                    <td class="text-left">{{ $comunicacion->comercial_nombre }}</td>
                                    <td class="text-left">{{ $comunicacion->cliente->razon_social }}</td>
                                    <td>{{ $comunicacion->cliente->cantidad_empleados }}</td>
                                    <td>{{ $comunicacion->cliente->rubro }}</td>
                                    <td>{{ $comunicacion->nombre_contacto . ' ' . $comunicacion->apellido_contacto }}</td>
                                    <td>{{ $comunicacion->telefono_contacto }}</td>
                                    <td>{{ $comunicacion->correo_contacto }}</td>
                                    <td>{{ $comunicacion->celular_contacto }}</td>
                                    <td>{{ date('d/m/Y', strtotime($comunicacion->fecha_contacto)) }}</td>
                                    <td>{{ ($comunicacion->linkedin) ? 'Si' : '' }}</td>
                                    <td>{{ ($comunicacion->envia_correo) ? 'Si' : '' }}</td>
                                    <td>{{ ($comunicacion->fecha_reunion) ? date('d/m/Y H:i', strtotime($comunicacion->fecha_reunion)) : '' }}</td>
                                    <td class="text-left">{{ $comunicacion->observaciones }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection