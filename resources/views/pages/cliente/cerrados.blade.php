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
                        <h4 class="card-title mb-1" id="total"></h4>
                        </div>
                        <div class="col-4 text-right">
                        <div class="dropdown">
                                <button class="btn btn-sm btn-secondary btn-round dropdown-toggle" type="button" id="dropdownMenuExport" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Exportar
                                </button>
                                <div class="dropdown-menu dropdown-navbar dropdown-menu-right" aria-labelledby="dropdownMenuExport">
                                    <a class="dropdown-item" href="{{ route('cliente.reportes', [1]) }}"><i class="fas fa-file-pdf"></i> Pdf</a>
                                    <a class="dropdown-item" href="{{ route('cliente.reportes', [2]) }}"><i class="fas fa-file-excel"></i> Excel</a>
                                </div>
                            </div>
                
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped" id="tablaCerrados" data-ruta="{{ route('cliente.cerrados.json') }}">
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
@endsection
@push('scripts')
<script src="{{ asset('paper/js/cerrados.js') }}"></script>
@endpush