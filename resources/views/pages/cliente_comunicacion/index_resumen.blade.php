@extends('layouts.app', [
'class' => '',
'elementActive' => 'prospeccion'
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
                                <th>Razón Social</th>
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
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                @foreach($comunicaciones as $key => $comunicacion)
                                <tr class="text-center">
                                    <td class="text-left">{{ $comunicacion->cliente->razon_social }}</td>
                                    <td>{{ $comunicacion->cliente->cantidad_empleados }}</td>
                                    <td>{{ $comunicacion->cliente->rubro }}</td>
                                    <td></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Grupo Acciones">
                                        </div>
                                    </td>
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