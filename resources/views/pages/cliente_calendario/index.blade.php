@extends('layouts.app', [
'class' => '',
'elementActive' => 'calendario'
])
@section('content')
@include('layouts.page_templates.messages')
<div class="content" id="msg-modal" data-valor="{{ ($errors->any()) ? 1 : 0 }}" data-nombre="add_reunion" data-update="updt_reunion">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title mb-1">Calendario Reuniones</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id='calendar'></div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('pages.cliente_calendario.modal_add_reunion')
@include('pages.cliente_calendario.modal_update_reunion')
@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.5.1/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.5.1/locales-all.js'></script>
<script src="{{ asset('paper/js/calendario.js') }}"></script>
@endpush