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
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped" id="tablaClientes" data-rolexportar="{{ (auth()->user()->rol_id == 2 || auth()->user()->rol_id == 3) ? 'B' : ''}}"  data-comercial="{{ ($comercial) ? $comercial->name . ' '  . $comercial->last_name : '' }}" data-rutaeliminar="{{ route('cliente.destroy', '@@') }}" data-rutadesechar="{{ route('cliente.discard', '@@') }}" data-rutaeditar="{{ route('cliente.edit', '@@') }}" data-rutarestart="{{ route('cliente.restart') }}" data-rutacontacto="{{ route('cliente-contacto.index', '@@') }}" data-rutaproyecto="{{ route('proyecto.cliente-proyecto', '@@') }}" data-rol="{{ (auth()->user()->rol_id == 2) ? true : false }}" data-user="{{ auth()->user()->id }}">
                            <thead class="text-primary text-center">
                                <th>Holding</th>
                                <th>Cliente</th>
                                <th>Comercial</th>
                                <th>Tipo</th>
                                <th>Inicio Ciclo</th>
                                <th>Ciclo Días</th>
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
@include('pages.cliente.modal_notificacion')
@endsection
@push('scripts')
<script src="{{ asset('paper/js/cliente.js?v='.time()) }}"></script>
@endpush