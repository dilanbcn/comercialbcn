@extends('layouts.app', [
'class' => '',
'elementActive' => 'cotizador'
])
@section('content')
<form class="form-prevent-multiple-submits" action="{{ route('cotizador.generar') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                @include('layouts.page_templates.messages')
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h5 class="card-title mb-1">Productos</h5>
                            </div>
                            <div class="col-4 text-right">
                                <button type="submit" class="btn btn-sm btn-success btn-round"><i class="fas fa-file-excel"></i>{{ __(' Generar Excel') }}</button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @foreach($ventas as $venta)


                        <div class="card bg-light mb-5 ">
                            <div class="card-body">
                                @if ($venta->tipo_venta_id == 3)
                                <div class="row abs-center">
                                    <div class="col-6">
                                        <h5 class="card-title">{{ $venta->nombre }}</h5>
                                    </div>
                                    <div class="col-3 text-right text-info font-weight-bold">
                                        <div class="form-group">
                                            <label class="mb-0">{{ __('Mínimo') }}</label>
                                            <h5 class="card-title lblPrecioMinimo" id="{{ 'total_curso_minimo_'.$venta->id }}" data-valor="0">0</h5>

                                        </div>
                                    </div>
                                    <div class="col-3 text-right text-info font-weight-bold">
                                        <div class="form-group">
                                            <label class="mb-0">{{ __('Máximo') }}</label>
                                            <h5 class="card-title lblPrecioMaximo" id="{{ 'total_curso_maximo_'.$venta->id }}" data-valor="0">0</h5>

                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="row">
                                    <div class="col-8">
                                        <h5 class="card-title">{{ $venta->nombre }}</h5>
                                    </div>
                                    <div class="col-4 text-right text-info font-weight-bold">
                                        <div class="form-group">
                                            <label class="mb-0">{{ __('Precio') }}</label>
                                            <h5 class="card-title lblPrecioAmbos" id="{{ 'total_curso_'.$venta->id }}" data-valor="{{ ($venta->precio_base > 0) ? $venta->precio_base : 0 }}">{{ ($venta->precio_base > 0) ? number_format($venta->precio_base, 0,',','.') : '0' }}</h5>

                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if ($venta->tipo_venta_id == 1)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table">
                                            <table class="table table-striped" id="tblRangoCotizador" data-venta="{{ $venta->id }}">
                                                <thead class="text-primary text-center">
                                                    <th>Desde</th>
                                                    <th>Hasta</th>
                                                    <th>Valor Implementación</th>
                                                    <th>Valor Mantención</th>
                                                    <th>Seleccionar</th>
                                                </thead>

                                                <tbody>
                                                    @foreach($venta->detalleVentas as $detalle)
                                                    <tr>
                                                        <td class="text-center">{{ $detalle->desde }}</td>
                                                        <td class="text-center">{{ $detalle->hasta }}</td>
                                                        <td class="text-center">{{ number_format($detalle->valor_implementacion, 0,',','.') }}</td>
                                                        <td class="text-center">{{ number_format($detalle->valor_mantencion, 0,',','.') }}</td>
                                                        <td class="text-center">
                                                            <label class="container-chk text-center">
                                                                <input type="radio" class="chk_rango" data-mantencion="{{ $detalle->valor_mantencion }}" data-implementacion="{{ $detalle->valor_implementacion }}" name="{{ 'opt_radio_rango_'.$venta->id }}" value="{{ $detalle->id }}">
                                                                <span class="checkmark" style="left: 50% !important;"></span>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if ($venta->tipo_venta_id != 1)

                                @if ($venta->mostrar_precio_base == 1)
                                <div class="row justify-content-end">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="mb-0">{{ __('Precio base') }} </label>
                                            <input autocomplete="off" type="text" readonly class="form-control text-right" id="{{ 'inptPrecio_base_'.$venta->id }}" data-precio="{{ $venta->precio_base }}" value="{{ number_format($venta->precio_base, 0,',','.') }}">
                                        </div>
                                    </div>
                                </div>
                                @endif


                                @foreach($venta->detalleVentas as $detalle)
                                <div class="row">

                                    <div class=" abs-center text-left {{ $detalle->precio > 0 ? 'col-md-7' : 'col-md-4' }}">
                                        @if ($venta->excluyente == 1)
                                        <label class="container-chk">{{ $detalle->tipo_precio . ' ' . $detalle->descripcion_tipo_precio }}
                                            <input type="radio" name="{{ 'opt_radio_'.$venta->id }}" class="opt-action" id="{{ 'toggle_'.$detalle->id }}" data-venta="{{ $venta->id }}" data-detalle="{{ $detalle->id }}" value="{{ $detalle->id }}">
                                            <span class="checkmark"></span>
                                        </label>
                                        @else
                                        <input type="checkbox" name="{{ 'opt_radio_'.$venta->id }}" data-toggle="toggle" data-size="sm" data-on="Si" data-off="No" data-onstyle="outline-success" class="toggle-action" id="{{ 'toggle_'.$detalle->id }}" data-venta="{{ $venta->id }}" data-detalle="{{ $detalle->id }}" value="{{ $detalle->id }}">
                                        <label class="mb-0 pl-3">{{ $detalle->tipo_precio . ' ' . $detalle->descripcion_tipo_precio }} </label>
                                        @endif
                                    </div>
                                    <div class="col-md-2">
                                        @if ($detalle->mostrar_cantidad == 1)
                                        <div class="form-group">
                                            <label class="mb-0">{{ __('Cant') }}</label>
                                            <input autocomplete="off" disabled type="text" id="{{ 'cant_precio_' . $detalle->id }}" name="{{ 'cant_precio_det_' . $detalle->id }}" class="form-control text-right inputNumber inptCantidad {{ 'cant_precio_' . $venta->id }}" data-detalle="{{ $detalle->id }}" data-venta="{{ $venta->id }}">
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="mb-0">{{ ($detalle->precio > 0) ? 'Precio' : 'Precio mínimo' }}</label>
                                            <input autocomplete="off" readonly type="text" class="form-control text-right" id="{{ 'inpSum_min_'.$detalle->id }}" data-precio="{{ ($detalle->precio > 0) ? $detalle->precio : $detalle->precio_minimo }}" value="{{ ($detalle->precio > 0) ? number_format($detalle->precio, 0,',','.') : number_format($detalle->precio_minimo, 0,',','.')  }}">
                                        </div>
                                    </div>
                                    @if ($detalle->precio <= 0) <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="mb-0">{{ __('Precio máximo') }} </label>
                                            <input autocomplete="off" readonly type="text" class="form-control text-right" id="{{ 'inpSum_max_'.$detalle->id }}" data-precio="{{ $detalle->precio_maximo }}" value="{{ number_format($detalle->precio_maximo, 0,',','.') }}">
                                        </div>
                                </div>
                                @endif
                            </div>
                            @endforeach
                            @endif

                            @if ($venta->valor_multiplicar == 1)
                            <div class="row justify-content-start">
                                <div class="col-md-4 abs-center text-left">
                                    <label class="mb-0">{{ __('Cantidad de Cursos Vendidos') }}</label>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="mb-0">{{ __('Cant') }}</label>
                                        <input autocomplete="off" type="text" name="{{ 'cant_vend_'.$venta->id }}" id="{{ 'inpt_multiplicar_'.$venta->id }}" class="form-control text-right inputNumber inpt-multiplicar" data-venta="{{ $venta->id }}">
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if ($venta->mostrar_extra == 1)
                            <div class="row">
                                <div class="col-md-12 mt-0">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input id="{{ 'chkbox_'.$venta->id }}" class="chkExtra" type="checkbox" name="{{ 'precio_extra_'.$venta->id }}" value="{{ $venta->precio_extra }}" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="outline-success" data-size="sm" data-precio="{{ $venta->precio_extra }}" data-venta="{{ $venta->id }}">
                                            <label for="{{ 'chkbox_'.$venta->id }}" class="form-check-label pl-2 font-weight-bold">{{ $venta->descripcion_extra . ' ' . number_format($venta->precio_extra, 0,',','.') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if ($venta->observaciones == 1)
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Observaciones') }}</label>
                                    <textarea class="form-control" id="observaciones" name="{{ 'observaciones_'.$venta->id }}" rows="3"></textarea>
                                </div>
                            </div>
                            @endif


                        </div>
                    </div>
                    @endforeach
                    <div class="card bg-success mb-5 text-white">
                        <div class="card-body">
                            <div class="row abs-center">
                                <div class="col-6">
                                    <h5 class="card-title">TOTAL</h5>
                                </div>
                                <div class="col-3 text-right font-weight-bold">
                                    <div class="form-group">
                                        <label class="mb-0">{{ __('Mínimo') }}</label>
                                        <h5 class="card-title" id="totalGRAL_min">0</h5>
                                    </div>
                                </div>
                                <div class="col-3 text-right font-weight-bold">
                                    <div class="form-group">
                                        <label class="mb-0">{{ __('Máximo') }}</label>
                                        <h5 class="card-title" id="totalGRAL_max">0</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row abs-center">
                                <div class="col-6">
                                    <h5 class="card-title">Inscripciones para levantamiento de fondos SENCE</h5>
                                </div>
                                <div class="col-3 text-right font-weight-bold">
                                    <div class="form-group">
                                        <h5 class="card-title" id="totSENCE_min">0</h5>
                                    </div>
                                </div>
                                <div class="col-3 text-right font-weight-bold">
                                    <div class="form-group">
                                        <h5 class="card-title" id="totSENCE_max">0</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row abs-center">
                                <div class="col-6">
                                    <h5 class="card-title">Inscripciones e-learning recomendados por BCN</h5>
                                </div>
                                <div class="col-3 text-right font-weight-bold">
                                    <div class="form-group">
                                        <h5 class="card-title" id="totBCN_min">0</h5>
                                    </div>
                                </div>
                                <div class="col-3 text-right font-weight-bold">
                                    <div class="form-group">
                                        <h5 class="card-title" id="totBCN_max">0</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>

@endsection
@push('scripts')
<script src="{{ asset('paper/js/cotizador_comercial.js?v='.time()) }}"></script>
@endpush