@extends('layouts.app', [
'class' => '',
'elementActive' => 'acciones'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            @include('layouts.page_templates.messages')
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center justify-content-start">
                        <div class="col-4">
                            <h5 class="card-title mb-1">Acciones Masivas</h5>
                        </div>
                        <div class="col-md-4 text-center">
                            <h4 class="card-title mb-1" id="customTotal"></h4>
                        </div>
                        <div class="col-4 text-right">
                            <a role="button" id="btn_modal_asignar" href="#" class="btn btn-sm btn-primary btn-round">{{ __('Asignar') }}</a>
                                <a role="button" id="btn_modal_desechar" href="#" class="btn btn-sm btn-warning btn-round">{{ __('Desechar') }}</a>
                                <a role="button" href="#" class="btn btn-sm btn-danger btn-round">{{ __('Regresar') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table">
                                <table class="table table-striped" id="tablaAcciones" data-desecharlote="{{ route('cliente.discard.all') }}" data-asignarlote="{{ route('cliente.asign.all') }}">
                                    <thead class="text-primary text-center">
                                        <th>Holding</th>
                                        <th>Cliente</th>
                                        <th>Comercial</th>
                                        <th>Tipo</th>
                                        <th>Seleccionar</th>
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
        @include('pages.cliente.modal_notificacion')
        @include('pages.cliente.modal_asignar')
        @endsection
        @push('scripts')
        <script src="{{ asset('paper/js/acciones.js?v='.time()) }}"></script>
        @endpush