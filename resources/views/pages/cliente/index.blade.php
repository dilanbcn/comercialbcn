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
                    <div class="row">
                        <div class="col-8">
                            <h5 class="card-title mb-1">Clientes General</h5>
                        </div>
                        <div class="col-4 text-right">
                            <div class="btn-group mt-2">
                                <!-- @if(auth()->user()->rol_id == 2)
                                <a href="{{ route('cliente.create') }}" class="btn btn-sm btn-secondary btn-round mr-1"><i class="fas fa-plus"></i> Agregar</a>
                                @endif -->

                                <!-- <button type="button" class="btn btn-sm btn-secondary btn-round dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Exportar
                                </button>
                                <div class="dropdown-menu dropdown-navbar dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('cliente.reportes', [3]) }}"><i class="fas fa-file-pdf"></i> Pdf</a>
                                    <a class="dropdown-item" href="{{ route('cliente.reportes', [4]) }}"><i class="fas fa-file-excel"></i> Excel</a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped" id="tablaClientes" data-rutaeliminar="{{ route('cliente.destroy', '@@') }}" data-rutadesechar="{{ route('cliente.discard', '@@') }}" data-rutaeditar="{{ route('cliente.edit', '@@') }}" data-rutacontacto="{{ route('cliente-contacto.index', '@@') }}" data-rutaproyecto="{{ route('proyecto.cliente-proyecto', '@@') }}" data-rol="{{ (auth()->user()->rol_id == 2) ? true : false }}" data-user="{{ auth()->user()->id }}">
                            <thead class="text-primary text-center">
                                <th>Holding</th>
                                <th>Cliente</th>
                                <th>Comercial</th>
                                <th>Tipo</th>
                                <th>Inicio Ciclo</th>
                                <th>Ciclo 8 Meses</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.page_templates.form_delete')
@include('layouts.page_templates.form_validar')
@endsection
@push('scripts')
<script src="{{ asset('paper/js/clientes.js') }}"></script>
@endpush