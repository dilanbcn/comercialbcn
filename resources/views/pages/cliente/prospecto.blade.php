@extends('layouts.app', [
'class' => '',
'elementActive' => 'prospectos'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            @include('layouts.page_templates.messages')
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="card-title mb-1">Prospectos Disponibles</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped tablaComercialesIndex">
                            <thead class="text-primary text-center">
                                <th>Cuenta</th>
                                <th>Origen</th>
                                <th>Nuevo Comercial</th>
                                @if(auth()->user()->rol_id == 2)
                                <th>Acciones</th>
                                @endif

                            </thead>
                            <tbody>
                                @foreach($clientes as $key => $cliente)
                                <tr class="text-center">
                                    <td class="text-left">{{ $cliente->razon_social }}</td>
                                    <td class="text-left">{{ $cliente->user->name . ' ' . $cliente->user->last_name }}</td>
                                    <td class="text-left">{{ ($cliente->destino) ? $cliente->destino->name . ' ' . $cliente->user->last_name : '' }}</td>
                                    @if(auth()->user()->rol_id == 2)

                                    <td>
                                        <div class="btn-group" role="group" aria-label="Grupo Acciones">
                                            <a href="{{ route('cliente.edit', $cliente->id) }}" title="Editar" class="btn btn-xs btn-outline-secondary"><i class="fa fa-edit"></i></a>
                                            <a href="#" id="{{ $cliente->id }}" title="Eliminar Cliente" class="btn btn-xs btn-outline-danger delRegistro" data-recurs="0" data-ruta="{{ route('cliente.destroy', $cliente->id) }}"><i class="fa fa-times"></i></a>
                                        </div>
                                    </td>
                                    @endif
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
@endsection