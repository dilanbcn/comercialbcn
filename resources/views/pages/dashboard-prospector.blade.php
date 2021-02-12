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

</div>



<script>

</script>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
        graficos.initChartsPages();
    });
</script>
@endpush