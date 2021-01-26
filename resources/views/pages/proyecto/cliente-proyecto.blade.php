@extends('layouts.app', [
'class' => '',
'elementActive' => 'clientes'
])
@section('content')
@include('layouts.page_templates.messages')
<div class="content" id="msg-modal" data-valor="{{ ($errors->any()) ? 1 : '' }}" data-nombre="add_proyecto_cliente">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="card-title mb-1">{{ __('Cliente') }}</h5>
                        </div>
                        <div class="col-4 text-right">
                            <a role="button" href="{{ route('cliente.index') }}" class="btn btn-sm btn-danger btn-round">{{ __('Regresar') }}</a>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ __('Razón Social') }}</label>
                                <h5>{{ $cliente->razon_social }}</h5>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ __('Comercial') }}</label>
                                <h5>{{ $cliente->user->name . ' ' . $cliente->user->last_name  }}</h5>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ __('Tipo Cliente') }}</label>
                                <h5>{{ $cliente->tipoCliente->nombre  }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="card-title mb-1">Proyectos</h5>
                        </div>
                        <div class="col-4 text-right">
                            <a href="#" class="btn btn-sm btn-secondary btn-round" id="btnModalProy"><i class="fas fa-plus"></i> Agregar</a>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped" id="tablaComercialesIdex">
                            <thead class="text-primary text-center">
                                <th>Nombre</th>
                                <th>Fecha Cierre</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                @foreach($proyectos as $proyecto)
                                <tr class="text-center">
                                    <td class="text-left">{{ $proyecto->nombre }}</td>
                                    <td>{{ date('d/m/Y', strtotime($proyecto->fecha_cierre)) }}</td>
                                    <td>
                                        <a href="{{ route('proyecto.proyecto-factura', $proyecto->id) }}" title="Facturación" class="btn btn-xs btn-outline-secondary"><i class="fas fa-file-invoice-dollar"></i></a>
                                        <div class="btn-group" role="group" aria-label="Grupo Acciones">
                                            <a href="#" title="Editar" class="btn btn-xs btn-outline-secondary"><i class="fa fa-edit"></i></a>
                                            <a href="#" id="{{ $proyecto->id }}" title="Eliminar Proyecto" class="btn btn-xs btn-outline-danger delRegistro" data-recurs="0" data-ruta="{{ route('proyecto.destroy', $proyecto->id) }}"><i class="fa fa-times"></i></a>
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
@include('pages.proyecto.modal_proyecto')
@endsection