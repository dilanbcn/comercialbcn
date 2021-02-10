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
                            <h5 class="card-title mb-1">Clientes</h5>
                        </div>
                        <div class="col-4 text-right">
                            <a href="#" class="btn btn-sm btn-secondary btn-round btnAddMeeting"><i class="fas fa-plus"></i> Agregar</a>
                            <a href="{{ route('cliente-comunicacion.resumen') }}" class="btn btn-sm btn-success btn-round"><i class="fas fa-list"></i> Vista Resumen</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped tablaComercialesIndex">
                            <thead class="text-primary text-center">
                                <th>Cliente</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                @foreach($clientes as $key => $cliente)
                                <tr class="text-center">
                                    <td class="text-left">{{ $cliente->razon_social }}</td>
                                    <td>{{ $cliente->telefono }}</td>
                                    <td>{{ $cliente->email }}</td>
                                    <td>{{ ($cliente->activo == 1 ) ? 'Activo' : 'Inactivo' }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Grupo Acciones">
                                            <a href="#" title="Agregar" data-cliente="{{ $cliente->id }}" class="btn btn-xs btn-outline-secondary btnAddMeeting"><i class="fas fa-comment-medical"></i></a>
                                            @if ($cliente->clienteComunicacion->count() > 0)
                                            <a href="{{ route('cliente-comunicacion.conversacion', [$cliente->id]) }}" title="Ver Conversación" class="btn btn-xs btn-outline-secondary"><i class="far fa-comments"></i></a>
                                            @endif
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
@include('pages.cliente_comunicacion.modal_comunicacion')
@endsection