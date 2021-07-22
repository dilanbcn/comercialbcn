@extends('layouts.app', [
'class' => '',
'elementActive' => 'cerrados'
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
                            <h5 class="card-title mb-1">Cerrados</h5>
                        </div>
                        <div class="col-md-4 text-center">
                            <h4 class="card-title mb-1" id="customTotal"></h4>
                        </div>
                        <div class="col-4 text-right">
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row mb-5 align-items-center">
                            <div class="col-12  bg-light p-3">
                                <a class="d-flex align-items-center justify-content-between text-decoration-none" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    <span>Filtrar por fecha</span>
                                </a>
                            </div>
                            <div class="col-12 bg-light ">
                                <div class="collapse pt-2" id="collapseExample">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ __('Fecha') }} </label>
                                                <select class="form-control inpt-filter" id="filterFecha" name="inscripcionSence">
                                                    <option value="" selected>[Seleccione]</option>
                                                    <option value="1">Mes Cierre</option>
                                                    <option value="2">Mes Facturacion</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ __('Desde') }} </label>
                                                <input autocomplete="off" type="date" name="desde" id="filterDesde" class="form-control inpt-filter">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ __('Hasta') }} </label>
                                                <input autocomplete="off" type="date" name="hasta" id="filterHasta" class="form-control inpt-filter">
                                            </div>
                                        </div>
                                        <div class="col-md-3 pt-4 mt-2">
                                            <button type="button" id="btn-filtrar" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">Filtrar</button>
                                            <button type="button" id="btn-limpiar" class="btn btn-sm btn-warning btn-round" data-dismiss="modal">Limpiar</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table">
                                <table class="table table-striped" id="tablaCerrados" data-proyeditar="{{ route('proyecto.edit', '@@') }}" data-proyactualizar="{{ route('proyecto.update', '@@') }}" data-admin="{{ (auth()->user()->rol_id == 2) ? true : false }}" data-rol="{{ auth()->user()->rol_id }}" data-rolexportar="{{ (auth()->user()->rol_id == 2 || auth()->user()->rol_id == 3 || auth()->user()->rol_id == 6) ? 'B' : ''}}" data-ruta="{{ route('cliente.cerrados.json') }}" data-rutastatus="{{ route('cliente.cerrados.status', '@@') }}" data-user="{{ auth()->user()->id }}">
                                    <thead class="text-primary text-center">
                                        <th>Status</th>
                                        <th>Mes Cierre</th>
                                        <th>Mes Facturación</th>
                                        <th>Cliente</th>
                                        <th>Venta</th>
                                        <th>Inscripción SENCE</th>
                                        <th>Status</th>
                                        <th>Comercial</th>
                                        <th>Proyecto</th>
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
    </div>
</div>
@include('layouts.page_templates.form_delete')
@include('pages.cliente.modal_proyecto_update')
@endsection
@push('scripts')
<script src="{{ asset('paper/js/cerrado.js?v='.time()) }}"></script>
@endpush