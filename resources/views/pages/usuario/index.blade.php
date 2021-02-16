@extends('layouts.app', [
'class' => '',
'elementActive' => 'comerciales'
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
                            <h5 class="card-title mb-1">{{  (auth()->user()->rol_id == 2) ? 'Comerciales' : 'Prospectores' }}</h5>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('user.create') }}" class="btn btn-sm btn-secondary btn-round"><i class="fas fa-plus"></i> Agregar</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped tablaComercialesIndex">
                            <thead class="text-primary text-center">
                                <th>Rut</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Correo</th>
                                <th>Estado</th>
                                @if(auth()->user()->rol_id == 2 || auth()->user()->rol_id == 4)
                                <th>Acciones</th>
                                @endif
                            </thead>
                            <tbody>
                                @foreach($comerciales as $key => $usuario)
                                <tr class="text-center">
                                    <td>{{ $usuario->id_number }}</td>
                                    <td class="text-left">{{ $usuario->name }}</td>
                                    <td class="text-left">{{ $usuario->last_name }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>{{ ($usuario->activo) ? 'Activo' : 'Inactivo' }}</td>
                                    @if(auth()->user()->rol_id == 2 || auth()->user()->rol_id == 4)
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Grupo Acciones">
                                            <a href="{{ route('user.edit', $usuario->id) }}" title="Editar" class="btn btn-xs btn-outline-secondary"><i class="fa fa-edit"></i></a>
                                            <a href="#" id="{{ $usuario->id }}" title="Eliminar Comercial" class="btn btn-xs btn-outline-danger delRegistro" data-recurs="0" data-ruta="{{ route('user.destroy', $usuario->id) }}"><i class="fa fa-times"></i></a>
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