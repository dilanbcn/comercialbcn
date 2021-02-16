@extends('layouts.app', [
'class' => '',
'elementActive' => 'productos'
])
@section('content')
<div class="content" id="msg-modal" data-valor="{{ ($errors->any()) ? 1 : 0 }}" data-nombre="add_producto" data-update="update_producto">
    <div class="row">
        <div class="col-md-12">
            @include('layouts.page_templates.messages')
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="card-title mb-1">Productos</h5>
                        </div>
                        <div class="col-4 text-right">
                        @if(auth()->user()->rol_id == 4)
                        <a href="#" class="btn btn-sm btn-secondary btn-round" id="btnModalProd"><i class="fas fa-plus"></i> Agregar</a>
                        @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped tablaComercialesIndex">
                            <thead class="text-primary text-center">
                                <th>Nombre</th>
                                <th>Archivo</th>
                                <th>Extensión</th>
                                <th>Fecha Creación</th>
                                <th>Usuario</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                @foreach($productos as $producto)
                                <tr class="text-center">
                                    <td class="text-left">{{ $producto->nombre }}</td>
                                    <td class="text-left">{{ $producto->archivo }}</td>
                                    <td>{{ $producto->extension }}</td>
                                    <td>{{ date('d/m/Y H:i:s', strtotime($producto->created_at)) }}</td>
                                    <td>{{ $producto->user->name . ' ' . $producto->user->last_name }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Grupo Acciones">
                                            <a href="{{ $producto->ruta }}" target="_blank" title="Descargar" class="btn btn-xs btn-outline-secondary"><i class="fas fa-download"></i></a>
                                            @if(auth()->user()->rol_id == 4)
                                            <a href="#" id="{{ $producto->id }}" title="Eliminar Producto" class="btn btn-xs btn-outline-danger delRegistro" data-recurs="0" data-ruta="{{ route('producto.destroy', $producto->id) }}"><i class="fa fa-times"></i></a>
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
@include('pages.producto.modal_producto')
@endsection