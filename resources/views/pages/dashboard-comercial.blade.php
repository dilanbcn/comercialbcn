@extends('layouts.app', [
'class' => '',
'elementActive' => 'dashboard'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="fas fa-user-clock" style="color:gray"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Prospectos Disponibles</p>
                                <p class="card-title">{{ $arrData['tipo']['Prospecto'] }}
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="far fa-handshake" style="color:blue"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">{{ 'Cerrados '.date('m') . '-' . date('y')  }}</p>
                                <p class="card-title">{{ number_format($totFact, 0, ',', '.') }}
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 pr-0">
                            <div class="numbers text-center">
                                <p class="card-category">Total Clientes</p>
                                <p class="card-title">{{ $totClientes }}
                                <p>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="numbers text-center">
                                <p class="card-category"> vs </p>
                            </div>
                        </div>
                        <div class="col-5  pl-0">
                            <div class="numbers  text-center">
                                <p class="card-category">Eficiencia Comercial</p>
                                <p class="card-title">{{ number_format($eficiencia, 2, ',', '.') .' %' }}
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="fas fa-hourglass-end" style="color:orange"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Vigencia de Clientes</p>
                                <p class="card-title">{{ $totalAct }}
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
                                <th>Comercial</th>
                                <th>Total Prospectos</th>
                                <th>Efctividad</th>
                                <th>Total Clientes</th>
                                <th>% Clientes Activos</th>
                                <th>Meses</th>
                            </thead>
                            <tbody>
                                @foreach($users as $key => $usuario)
                                <tr class="text-center">
                                    <td class="text-left">{{ $usuario->name . ' ' . $usuario->last_name }}</td>
                                    <td>{{ $usuario->prospectos }}</td>
                                    <td>
                                        <div class="progress" style="height: 5px;width: 100%;">
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
                                    <td>
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