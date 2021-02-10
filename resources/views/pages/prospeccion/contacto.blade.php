@extends('layouts.app', [
'class' => '',
'elementActive' => 'contactos'
])
@section('content')
<div class="content"  id="msg-modal" data-valor="{{ ($errors->any()) ? 1 : 0 }}" data-nombre="add_prospeccion_contacto" data-update="modal_update_prospeccion_contacto">
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
                            <a href="#" class="btn btn-sm btn-secondary btn-round" id="btnModalContactoPros"><i class="fas fa-plus"></i> Agregar</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped tablaComercialesIndex">
                            <thead class="text-primary text-center">
                                <th>Comercial</th>
                                <th>Cliente</th>
                                <th>N° Trabajadores</th>
                                <th>Rubro</th>
                                <th>Nombre Contacto</th>
                                <th>Correo</th>
                                <th>Fono Fijo</th>
                                <th>Celular</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                @foreach($contactos as $key => $contacto)
                                <tr class="text-center">
                                    <td class="text-left">{{ $contacto->cliente->user->name . ' '. $contacto->cliente->user->last_name }}</td>
                                    <td class="text-left">{{ $contacto->cliente->razon_social }}</td>
                                    <td>{{ $contacto->cliente->cantidad_empleados }}</td>
                                    <td class="text-left">{{ $contacto->cliente->rubro }}</td>
                                    <td class="text-left">{{ $contacto->nombre . ' ' . $contacto->apellido }}</td>
                                    <td>{{ $contacto->email }}</td>
                                    <td>{{ $contacto->telefono }}</td>
                                    <td>{{ $contacto->celular }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Grupo Acciones">
                                            <a href="#" title="Editar" class="btn btn-xs btn-outline-secondary btnProspContacto" data-editar="{{ route('prospeccion.contactos.edit', $contacto->id) }}" data-actualizar="{{ route('prospeccion.contactos.update', $contacto->id) }}"><i class="fa fa-edit"></i></a>
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
@include('pages.prospeccion.modal_contacto')
@include('pages.prospeccion.modal_contacto_update')
@endsection