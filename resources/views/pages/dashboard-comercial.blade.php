@extends('layouts.app', [
'class' => '',
'elementActive' => 'dashboard'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats" style="height:100px; background-color: #D2E9FF;">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-2 col-md-2">
                            <div class="icon-big text-center icon-warning">
                                <i class="fas fa-user-clock" style="color:gray"></i>
                            </div>
                        </div>
                        <div class="col-10 col-md-10">
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
            <div class="card card-stats" style="height:100px; background-color: #D2E9FF;">
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
            <div class="card card-stats" style="height:100px; background-color: #D2E9FF;">
                <div class="card-body">
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
            <div class="card card-stats" style="height:100px; background-color: #D2E9FF;">
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
                                        <div >
                                        <canvas class="pieChart" data-act="{{ $usuario->activos }}" data-inact="{{ ($usuario->total_general - $usuario->activos) }}" style="max-width: 150px;"></canvas>
                                        </div>
                                        
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