@extends('layouts.app', [
'class' => '',
'elementActive' => 'reuniones'
])
@section('content')
<div class="content" id="msg-modal" data-valor="{{ ($errors->any()) ? 1 : 0 }}" data-nombre="add_cliente_comunicacion">
    <div class="row">
        <div class="col-md-12">
            @include('layouts.page_templates.messages')
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="card-title mb-1">Llamados y Reuniones - Clientes</h5>
                        </div>
                        <div class="col-4 text-right">
                            <a href="#" class="btn btn-sm btn-secondary btn-round btnAddMeeting"><i class="fas fa-plus"></i> Agregar</a>
                            <a href="{{ route('cliente-comunicacion.resumen') }}" class="btn btn-sm btn-success btn-round"><i class="fas fa-list"></i> Vista Resumen</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped" id="tablaComunicacion" data-rutaedit="{{ route('cliente.update', '@@') }}" data-rutacomunicacion="{{ route('cliente-comunicacion.conversacion', '@@') }}">
                            <thead class="text-primary text-center">
                                <th>Cliente</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th>Estado</th>
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
@include('pages.cliente_comunicacion.modal_comunicacion')
@include('pages.cliente_comunicacion.modal_cliente')
@endsection
@push('scripts')
<script src="{{ asset('paper/js/comunicacion.js?v='.time()) }}"></script>
@endpush