@extends('layouts.app', [
'class' => '',
'elementActive' => 'contacto'
])
@section('content')
<div class="content" id="msg-modal" data-valor="{{ ($errors->any()) ? 1 : 0 }}" data-nombre="add_contacto_cliente" data-update="modal_update_cliente_contacto">
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
            @include('layouts.page_templates.messages')
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="card-title mb-1">Contactos</h5>
                        </div>
                        <div class="col-4 text-right">
                            <a href="#" class="btn btn-sm btn-secondary btn-round" id="btnModalContacto"><i class="fas fa-plus"></i> Agregar</a>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped tablaComercialesIndex">
                            <thead class="text-primary text-center">
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Cargo</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Celular</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                @foreach($contactos as $key => $contacto)
                                <tr class="text-center">
                                    <td class="text-left">{{ $contacto->nombre }}</td>
                                    <td class="text-left">{{ $contacto->apellido }}</td>
                                    <td class="text-left">{{ $contacto->cargo }}</td>
                                    <td>{{ $contacto->correo }}</td>
                                    <td>{{ $contacto->telefono }}</td>
                                    <td>{{ $contacto->celular }}</td>
                                    <td>{{ ($contacto->activo) ? 'Activo' : 'Inactivo' }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Grupo Acciones">
                                            <a href="#" title="Editar" class="btn btn-xs btn-outline-secondary btnContactoEdit" data-editar="{{ route('cliente-contacto.edit', $contacto->id) }}" data-actualizar="{{ route('cliente-contacto.update', $contacto->id) }}"><i class="fa fa-edit"></i></a>
                                            <a href="#" id="{{ $contacto->id }}" title="Eliminar Contacto" class="btn btn-xs btn-outline-danger delRegistro" data-recurs="0" data-ruta="{{ route('cliente-contacto.destroy', $contacto->id) }}"><i class="fa fa-times"></i></a>
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
@include('pages.cliente_contacto.modal_contacto')
@include('pages.cliente_contacto.modal_contacto_update')
@endsection