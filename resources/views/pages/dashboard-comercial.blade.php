@extends('layouts.app', [
'class' => '',
'elementActive' => 'dashboard'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats" style="height:100px; background-color: #D2E9FF;">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-2 col-md-2">
                            <div class="icon-big text-center icon-warning">
                                <img src="{{ asset('paper/img/prosp_disp.svg') }}">
                            </div>
                        </div>
                        <div class="col-10 col-md-10">
                            <div class="numbers">
                                <p class="card-category">Prospectos Disponibles sin Asignar</p>
                                <p class="card-title">{{ $prospDisp }}
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats" style="height:100px; background-color: #D2E9FF;">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-3 col-md-3">
                            <div class="icon-big text-center icon-warning">
                                <img src="{{ asset('paper/img/cerrados.png') }}">
                            </div>
                        </div>
                        <div class="col-9 col-md-9">
                            <div class="numbers">
                                <p class="card-category">{{ 'Cerrados en '. date('Y')  }}</p>
                                <p class="card-title">{{ number_format($totFact, 0, ',', '.') }}
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats" style="height:100px; background-color: #D2E9FF;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 pr-0 text-center">
                            Clientes General
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5 pr-0">
                            <div class="numbers text-center">
                                <p class="card-category">Clientes</p>
                                <p class="card-title">{{ $countClientes }}
                                <p>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="numbers text-center">
                                <p class="card-category">  </p>
                            </div>
                        </div>
                        <div class="col-5  pl-0">
                            <div class="numbers  text-center">
                                <p class="card-category">Prospectos</p>
                                <p class="card-title">{{ $countProspectos }}
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @include('layouts.page_templates.messages')
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="card-title mb-1">Dashboard Comerciales</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped tablaComercialesIndex">
                            <thead class="text-primary text-center">
                                <th>Clientes</th>
                                <th>Comercial</th>
                                <th>% Activos</th>
                                <th>Meses</th>
                            </thead>
                            <tbody>
                                @foreach($users as $key => $usuario)
                                <tr class="text-center">
                                    <td>{{ $usuario->total_general }}</td>
                                    <td class="text-left">{{ $usuario->name . ' ' . $usuario->last_name }}</td>
                                    <td>
                                        <canvas class="pieChart" data-act="{{ $usuario->activos }}" data-inact="{{ ($usuario->total_general - $usuario->activos) }}" style="max-width: 150px;">5</canvas>
                                    </td>
                                    <td>{{ $usuario->meses }}
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
@endsection

@push('scripts')
<script src="{{ asset('paper/js/dash-comercial.js?v='.time()) }}"></script>
@endpush