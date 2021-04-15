@extends('layouts.app', [
'class' => '',
'elementActive' => 'prospectos'
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
                            <h5 class="card-title mb-1">Prospectos Disponibles</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped tablaProspectos" id="tableProspectos" data-rol="{{ (auth()->user()->rol_id == 2) ? true : false }}" data-rutadel="{{ route('cliente.destroy', '@@') }}" data-rutaedit="{{ route('cliente.edit', '@@') }}">
                            <thead class="text-primary text-center">
                                <th>Cuenta</th>
                                <th>Origen</th>
                                <th>Nuevo Comercial</th>
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
@endsection
@push('scripts')
<script src="{{ asset('paper/js/prospectos_disponibles.js') }}"></script>
@endpush