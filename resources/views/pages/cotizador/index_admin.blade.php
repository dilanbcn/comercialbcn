@extends('layouts.app', [
'class' => '',
'elementActive' => 'cotizador_admin'
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
                            <h5 class="card-title mb-1">Productos</h5>
                        </div>
                        <div class="col-4 text-right">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped" id="tablaCotizador" data-rutaeditar="{{ route('cotizador.edit', '@@') }}">
                            <thead class="text-primary text-center">
                                <th>Nombre</th>
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
@endsection
@push('scripts')
<script src="{{ asset('paper/js/cotizador.js?v='.time()) }}"></script>
@endpush