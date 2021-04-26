@extends('layouts.app', [
'class' => '',
'elementActive' => 'notificacion'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-8">
            @include('layouts.page_templates.messages')
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-4">
                            <h5 class="card-title mb-1">Notificaciones</h5>
                        </div>
                        <div class="col-8 text-right">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped" id="tablaNotificaciones" data-rutarecientes="{{ route('notificaciones.recientes') }}" data-rutamarcar="{{ route('notificaciones.marcar') }}">
                            <thead class="text-primary text-center">
                                <th>Fecha</th>
                                <th>Tipo</th>
                                <th>Remitente</th>
                                <th>Cliente</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="card-title mb-1">Notificaciones Recientes</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="notifRecientes">
                   
                </div>
            </div>
        </div>
    </div>
</div>
@include('pages.notificacion.modal_notificacion')
@endsection
@push('scripts')
<script src="{{ asset('paper/js/notificaciones.js') }}"></script>
@endpush