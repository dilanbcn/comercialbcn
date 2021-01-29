@extends('layouts.app', [
'class' => '',
'elementActive' => 'comerciales'
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
                            <h5 class="card-title mb-1">Detalle Comerciales</h5>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('principal') }}" class="btn btn-sm btn-danger btn-round">Regresar</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped" id="tablaComercialesIdex">
                            <thead class="text-primary text-center">
                                <th>Comercial</th>
                                <th>Total Prospectos</th>
                                <th>Efctividad</th>
                                <th>Total Clientes</th>
                                <th>% Clientes Activos</th>
                            </thead>
                            <tbody>
                                @foreach($users as $key => $usuario)
                                <tr class="text-center">
                                    <td class="text-left">{{ $usuario->name . ' ' . $usuario->last_name }}</td>
                                    <td>{{ $usuario->prospectos }}</td>
                                    <td>
                                        <div class="progress"  style="height: 5px;width: 100%;">
                                            <div class="progress-bar {{ $usuario->efect_color }}" role="progressbar" style="{{ $usuario->width_efectividad }}" aria-valuenow="{{ $usuario->efectividad }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div style="padding-left: 1rm;">{{ $usuario->efectividad . '%' }}</div>
                                    </td>
                                    <td>{{ $usuario->clientes }}</td>
                                    <td>
                                        <div class="chart" data-percent="{{ $usuario->pct_activos }}">
                                            <span class="percent">{{ $usuario->pct_activos . '%' }}</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
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