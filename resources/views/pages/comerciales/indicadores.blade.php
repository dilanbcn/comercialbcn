@extends('layouts.app', [
'class' => '',
'elementActive' => 'indica_comercial'
])
@section('content')
<div class="content">
    @if(auth()->user()->rol_id == 2)
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
                                <p class="card-category">Prospectos</p>
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
                                <i class="fas fa-user-tie text-blue" style="color:blue"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Clientes</p>
                                <p class="card-title">{{ $arrData['tipo']['Cliente'] }}
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
                        <div class="col-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="fas fa-user-check" style="color:green"></i>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="numbers">
                                <p class="card-category">Activos</p>
                                <p class="card-title">{{ $arrData['estado']['Activo'] }}
                                <p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="numbers">
                                <p class="card-category">Inactivos</p>
                                <p class="card-title">{{ $arrData['estado']['Inactivo'] }}
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
                                <i class="fas fa-users" style="color:orange"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Comerciales</p>
                                <p class="card-title">{{ $arrData['comerciales']['activo'] }}
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row" id="card-grafico">
        <div class="col-lg-3 col-md-12 col-sm-12">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-title">Clientes</h5>
                </div>
                <div class="card-body">
                    <canvas id="chDonut1" height="208" data-activos="{{ $arrData['estado']['Activo'] }}" data-inactivos="{{ $arrData['estado']['Inactivo'] }}"></canvas>
                </div>
                <div class="card-footer">
                    <hr />
                    <div class="card-stats text-right">
                        <a class="dropdown-item" href="{{ route('cliente.index') }}">{{ __('Ver Clientes') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-12 col-sm-12">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-title">Top Comerciales</h5>
                </div>
                <div class="card-body">
                    <canvas id="comercialChart" data-nombres='["{{ implode('","', $arrData['grafico']['nombres']) }}"]' data-prospecto='[{{ implode(",", $arrData['grafico']['Prospecto']) }}]' data-cliente='[{{ implode(",", $arrData['grafico']['Cliente']) }}]' width="400" height="100"></canvas>

                </div>
                <div class="card-footer">
                    <hr />
                    <div class="card-stats text-right">
                        <a class="dropdown-item" href="{{ route('user.grafico') }}">{{ __('Ver Detalle') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @elseif(auth()->user()->rol_id == 1)
    <div class="row">
        <div class="col-md-12">
            @include('layouts.page_templates.messages')
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <h5 class="card-title mb-1">Clientes</h5>
                        </div>
                        @foreach($arrGrupo as $key => $estado)
                        <div class="col-2 text-center font-weight-bold text-white p-2 {{ $key == 'Activos' ? 'bg-info' : 'bg-danger' }}">
                            <span>{{ $key . ': ' . $estado}}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped tablaComercialesIndex">
                            <thead class="text-primary text-center">
                                <th>Holding</th>
                                <th>Cliente</th>
                                <th>Comercial</th>
                                <th>Tipo</th>
                                <th>Inicio Ciclo</th>
                                <th>Ciclo 8 Meses</th>
                                <th>Estado</th>
                                <th>Cant Proyectos</th>
                            </thead>
                            <tbody>
                                @foreach($clientes as $key => $cliente)
                                <tr class="text-center">
                                    <td>{{ ($cliente->holding != null) ? $cliente->holding : '' }}</td>
                                    <td class="text-left">{{ $cliente->razon_social }}</td>
                                    <td class="text-left">{{ $cliente->user->name . ' ' . $cliente->user->last_name }}</td>
                                    <td><span class="badge p-2 {{ $cliente->tipoCliente->badge }}">{{ $cliente->tipoCliente->nombre }}</span></td>
                                    <td>{{ ($cliente->tipo_cliente_id == 1) ? date('d/m/Y', strtotime($cliente->inicio_ciclo)) : '' }}</td>
                                    <td>{{ ($cliente->tipo_cliente_id == 1) ? $cliente->ciclo : '' }}</td>
                                    <td>{{ ($cliente->activo) ? 'Activo' : 'Inactivo' }}</td>
                                    <td>{{ $cliente->proyecto_count }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
        graficos.initChartsPages();
    });
</script>
@endpush