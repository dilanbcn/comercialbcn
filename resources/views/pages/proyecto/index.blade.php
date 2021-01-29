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
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="card-title mb-1">Proyectos</h5>
                            <p class="card-category">Cliente: {{ $cliente->nombre }}</p>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('proyecto.create') }}" class="btn btn-sm btn-secondary btn-round"><i class="fas fa-plus"></i> Agregar</a>
                            <a role="button" href="{{ route('cliente.index') }}" class="btn btn-sm btn-danger btn-round">{{ __('Regresar') }}</a>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped" id="tablaComercialesIdex">
                            <thead class="text-primary text-center">
                                <th>Nombre</th>
                                <th>Fecha Cierre</th>
                                <th>Cant. Facturas</th>
                                <th>Total Facturas</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                @foreach($proyectos as $proyecto)
                                <tr class="text-center">
                                    <td class="text-left">{{ $proyecto->nombre }}</td>
                                    <td>{{ date('d/m/Y', strtotime($proyecto->fecha_cierre)) }}</td>
                                    <td></td>
                                    <td>{{ number_format($proyecto->sum_facturas, 2, '.', '.') }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Grupo Acciones">
                                            <a href="{{ route('proyecto.edit', $proyecto->id) }}" title="Editar" class="btn btn-xs btn-outline-secondary"><i class="fa fa-edit"></i></a>
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
@endsection