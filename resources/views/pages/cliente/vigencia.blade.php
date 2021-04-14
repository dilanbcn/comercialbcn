@extends('layouts.app', [
'class' => '',
'elementActive' => 'vigencia'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            @include('layouts.page_templates.messages')
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <h5 class="card-title mb-1">Vigencia Clientes</h5>
                        </div>
                        @foreach($arrGrupo as $key => $estado)
                        <div class="col-2 text-center font-weight-bold text-white p-2 {{ $key == 'Activos' ? 'bg-activos' : 'bg-inactivos' }}">
                            <span>{{ $key . ': ' . $estado}}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped tablaComercialesIndex" id="tableClientes">
                            <thead class="text-primary text-center">
                                <th>Cliente</th>
                                <th>Meses Vigencia</th>
                                <th>Status</th>
                                <th>Actividad</th>
                                <th>Comercial</th>
                                <th>Inicio Relación</th>
                                @if (Auth::user()->rol_id == 2)
                                <th>Acciones</th>
                                @endif
                            </thead>
                            <tbody>
                                @foreach($clientes as $key => $cliente)
                                <tr class="text-center">
                                    <td class="text-left">{{ $cliente->razon_social }}</td>
                                    <td>{{ $cliente->vigenciaMeses }}</td>
                                    <td>{{ $cliente->antiguedad }}</td>
                                    <td><span class="badge p-2 badge-{{ ($cliente->activo) ? 'activos' : 'inactivos' }}">{{ ($cliente->activo) ? 'Activos' : 'Inactivo' }}</span></td>
                                    <td class="text-left">{{ $cliente->user->name . '' . $cliente->user->last_name }}</td>
                                    <td>{{ ($cliente->inicio_relacion) ? date('d/m/Y', strtotime($cliente->inicio_relacion)) : '' }}</td>
                                    @if (Auth::user()->rol_id == 2)
                                    <td>
                                    <div class="btn-group" role="group" aria-label="Grupo Acciones">
                                            <a href="#" title="Editar Inicio Relacion" class="btn btn-xs btn-outline-secondary btnInicio" data-ruta="{{ route('cliente.inicio-relacion', $cliente->id) }}" data-fecha="{{ ($cliente->inicio_relacion) ? date('Y-m-d', strtotime($cliente->inicio_relacion)) : '' }}"><i class="far fa-calendar-alt"></i></a>
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
@include('pages.cliente.modal_inicio_relacion')
@endsection