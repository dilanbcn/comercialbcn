@extends('layouts.app', [
'class' => '',
'elementActive' => 'clientes'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            @include('layouts.page_templates.messages')
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h5 class="card-title mb-1">Clientes General</h5>
                        </div>
                        <div class="col-4 text-right">
                            <div class="btn-group mt-2">
                                @if(auth()->user()->rol_id == 2)
                                <a href="{{ route('cliente.create') }}" class="btn btn-sm btn-secondary btn-round mr-1"><i class="fas fa-plus"></i> Agregar</a>
                                @endif

                                <button type="button" class="btn btn-sm btn-secondary btn-round dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Exportar
                                </button>
                                <div class="dropdown-menu dropdown-navbar dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('cliente.reportes', [3]) }}"><i class="fas fa-file-pdf"></i> Pdf</a>
                                    <a class="dropdown-item" href="{{ route('cliente.reportes', [4]) }}"><i class="fas fa-file-excel"></i> Excel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped tablaComercialesIndex" id="tableCliente" data-comercial="{{ ($comercial) ? $comercial->name . ' ' . $comercial->last_name  : '' }}">
                            <thead class="text-primary text-center">
                                <th>Holding</th>
                                <th>Cliente</th>
                                <th>Comercial</th>
                                <th>Tipo</th>
                                <th>Inicio Ciclo</th>
                                <th>Ciclo 8 Meses</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                @foreach($clientes as $key => $cliente)
                                <tr class="text-center">
                                    <td>{{ ($cliente->padre != null) ? $cliente->padre->razon_social : '' }}</td>
                                    <td class="text-left">{{ $cliente->razon_social }}</td>
                                    <td class="text-left">{{ $cliente->user->name . ' ' . $cliente->user->last_name }}</td>
                                    <td><span class="badge p-2 {{ $cliente->tipoCliente->badge }}">{{ $cliente->tipoCliente->nombre }}</span></td>
                                    <td>{{ ($cliente->tipo_cliente_id == 1) ? date('d/m/Y', strtotime($cliente->inicio_ciclo)) : '' }}</td>
                                    <td>{{ ($cliente->tipo_cliente_id == 1) ? $cliente->ciclo : '' }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Grupo Acciones">
                                            @if(auth()->user()->id == $cliente->destino_user_id && auth()->user()->rol_id != 2)
                                            <a href="{{ route('proyecto.cliente-proyecto', $cliente->id) }}" title="Proyectos" class="btn btn-xs btn-outline-secondary"><i class="far fa-handshake"></i></a>
                                            <a href="#" title="Desechar Cliente" class="btn btn-xs btn-outline-warning disRegistro" data-ruta="{{ route('cliente.discard', $cliente->id) }}"><i class="fa fa-recycle"></i></a>
                                            @endif
                                            @if(auth()->user()->rol_id == 2)
                                            <a href="{{ route('proyecto.cliente-proyecto', $cliente->id) }}" title="Proyectos" class="btn btn-xs btn-outline-secondary"><i class="far fa-handshake"></i></a>
                                            <a href="{{ route('cliente-contacto.index', $cliente->id) }}" title="Contactos" class="btn btn-xs btn-outline-secondary"><i class="fas fa-user-friends"></i></a>
                                            <a href="{{ route('cliente.edit', $cliente->id) }}" title="Editar" class="btn btn-xs btn-outline-secondary"><i class="fa fa-edit"></i></a>
                                            <a href="#" title="Desechar Cliente" class="btn btn-xs btn-outline-warning disRegistro" data-ruta="{{ route('cliente.discard', $cliente->id) }}"><i class="fa fa-recycle"></i></a>
                                            <a href="#" id="{{ $cliente->id }}" title="Eliminar Cliente" class="btn btn-xs btn-outline-danger delRegistro" data-recurs="0" data-ruta="{{ route('cliente.destroy', $cliente->id) }}"><i class="fa fa-times"></i></a>
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
@include('layouts.page_templates.form_delete')
@include('layouts.page_templates.form_validar')
@endsection