@extends('layouts.app', [
'class' => '',
'elementActive' => 'clientes'
])
@section('content')
@include('layouts.page_templates.messages')

<div class="content" id="msg-modal" data-valor="{{ ($errors->any()) ? 1 : 0 }}" data-metodo="post" data-nombre="modal_factura_proyecto" data-update="modal_update_factura_proyecto">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="card-title mb-1">{{ __('Cliente') }}</h5>
                        </div>
                        <div class="col-4 text-right">
                            <a role="button" href="{{ route('proyecto.cliente-proyecto', $cliente->id) }}" class="btn btn-sm btn-danger btn-round">{{ __('Regresar') }}</a>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('Razón Social') }}</label>
                                <h5>{{ $cliente->razon_social }}</h5>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('Comercial') }}</label>
                                <h5>{{ $cliente->user->name . ' ' . $cliente->user->last_name  }}</h5>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{ __('Tipo Cliente') }}</label>
                                <h5>{{ $cliente->tipoCliente->nombre  }}</h5>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ __('Proyecto') }}</label>
                                <h5>{{ $proyecto->nombre  }}</h5>
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
                            <h5 class="card-title mb-1">Facturación</h5>
                        </div>
                        <div class="col-4 text-right">
                            <a href="#" class="btn btn-sm btn-secondary btn-round" id="btnFactura"><i class="fas fa-plus"></i> Agregar</a>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped tablaComercialesIndex">
                            <thead class="text-primary text-center">
                                <th>Fecha Facturación</th>
                                <th>Monto Venta</th>
                                <th>Inscripción SENCE</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                @foreach($facturas as $factura)
                                <tr class="text-center">
                                    <td>{{  date('d/m/Y', strtotime($factura->fecha_factura)) }}</td>
                                    <td class="text-right pr-5">{{ number_format($factura->monto_venta, 0, ',', '.') }}</td>
                                    <td>{{ $factura->inscripcion_sence }}</td>
                                    <td>{{ $factura->estadoFactura->nombre }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Grupo Acciones">
                                            <a href="#" id="{{ $factura->id }}" title="Editar" class="btn btn-xs btn-outline-secondary btnFactEdit" data-editar="{{ route('factura.edit', $factura) }}" data-actualizar="{{ route('factura.update', $factura) }}"><i class="fa fa-edit"></i></a>
                                            <a href="#" id="{{ $factura->id }}" title="Eliminar Factura" class="btn btn-xs btn-outline-danger delRegistro" data-recurs="0" data-ruta="{{ route('factura.destroy', $factura) }}"><i class="fa fa-times"></i></a>
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
@include('pages.factura.modal_factura')
@include('pages.factura.modal_factura_update')
@endsection