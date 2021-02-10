@extends('layouts.app', [
'class' => '',
'elementActive' => 'asignacion'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="card-title mb-1">{{ __('Filtro Búsqueda') }}</h5>
                        </div>
                        <div class="col-4 text-right">
                            <a role="button" href="{{ route('cliente.index') }}" class="btn btn-sm btn-danger btn-round">{{ __('Regresar') }}</a>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <form method="GET" id="frm_filtro_asignacion">
                                    <label>{{ __('Prospector') }}</label>
                                    <select class="form-control @error('filtro') is-invalid @enderror" id="filtro" name="filtro">
                                        <option value="" selected>[Todos]</option>
                                        <option value="sin_prospector" {{  ($filtro == 'sin_prospector') ? 'selected' : '' }}>[Sin Prospector]</option>
                                        @foreach ($prospectores as $prospector)
                                        <option {{ ( $prospector->id == $filtro) ? 'selected' : ''}} value="{{ $prospector->id }}">{{ $prospector->name . ' ' . $prospector->last_name }}</option>
                                        @endforeach
                                    </select>
                                </form>
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
                            <h5 class="card-title mb-1">Comerciales</h5>
                        </div>
                        <div class="col-4 text-right">
                            <a href="#" id="btnAsingProsp" class="btn btn-sm btn-secondary btn-round"><i class="fas fa-plus"></i> Asignar Prospector</a>
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
                                <th>Prospector</th>
                                <th>Seleccionar</th>
                            </thead>
                            <tbody>
                                @foreach($comerciales as $key => $usuario)
                                <tr class="text-center">
                                    <td>{{ $usuario->id_number }}</td>
                                    <td class="text-left">{{ $usuario->name }}</td>
                                    <td class="text-left">{{ $usuario->last_name }}</td>
                                    <td>{{ ($usuario->prospector != null ) ? $usuario->prospector->name . ' ' . $usuario->prospector->last_name : ''}}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Grupo Acciones">
                                            <input class="chkSel" type="checkbox" id="{{ $usuario->id }}" name="activo[]" data-rut="{{ $usuario->id_number }}" data-nom="{{$usuario->name }}" data-ape="{{ $usuario->last_name }}" value="1" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="outline-success" data-size="sm">
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
@include('pages.prospeccion.modal_asignacion')
@endsection