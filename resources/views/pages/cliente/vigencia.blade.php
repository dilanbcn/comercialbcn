@extends('layouts.app', [
'class' => '',
'elementActive' => 'vigencia'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            @include('layouts.page_templates.messages')
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <h5 class="card-title mb-1">Vigencia Clientes</h5>
                            
                        </div>
                        @foreach($arrGrupo as $key => $estado)
                        <div class="col-2 text-center font-weight-bold text-white p-2 {{ $key == 'Activos' ? 'bg-activos' : 'bg-inactivos' }}">
                            <span id="{{ 'span-'.$key }}"></span>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped" id="tablaVigencia" data-rol="{{ (auth()->user()->rol_id == 2) ? true : false }}" data-rutainicio="{{ route('cliente.inicio-relacion', '@@') }}" data-rutaactividad="{{ route('cliente.vigencia.actividad', '@@') }}">
                            <thead class="text-primary text-center">
                                <th>Cliente</th>
                                <th>Meses Vigencia</th>
                                <th>Status</th>
                                <th>Comercial</th>
                                <th>Inicio Relación</th>
                                <th>Actividad</th>
                                <th></th>
                                @if(auth()->user()->rol_id == 2)
                                <th>Acciones</th>
                                @endif
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
@include('pages.cliente.modal_inicio_relacion')
@endsection
@push('scripts')
<script src="{{ asset('paper/js/vigencia.js?v='.time()) }}"></script>
@endpush