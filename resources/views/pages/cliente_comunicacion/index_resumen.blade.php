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
                        <h5 class="card-title mb-1">Llamados y Reuniones - Resumen</h5>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('cliente-comunicacion.index') }}" class="btn btn-sm btn-success btn-round"><i class="fas fa-list"></i> Vista Clientes</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped" id="tablaLlamados" >
                            <thead class="text-primary text-center">
                                <th>&nbsp;</th>
                                <th>Prospector</th>
                                <th>Comercial</th>
                                <th>Cliente</th>
                                <th>Mes Seguimiento</th>
                                <th>Contacto</th>
                                <th>Comunicaciones</th>
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
@endsection
@push('scripts')
<script src="{{ asset('paper/js/comunicacion.js?v='.time()) }}"></script>
@endpush