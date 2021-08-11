@extends('layouts.app', [
'class' => '',
'elementActive' => 'cotizador_admin'
])
@section('content')
<div class="content">
    <div class="row">
    @include('layouts.page_templates.messages')
        <div class="col-md-12">
            <form class="form-prevent-multiple-submits" action="{{ route('cotizador.update', $venta->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="tipo_venta" id="tipo_venta" value="{{ $venta->tipo_venta_id }}">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="card-title mb-1">Detalles</h5>
                            </div>
                            <div class="col-md-4 text-right">
                            <button type="submit" class="btn btn-sm btn-secondary btn-round button-prevent-submit"><i class="spinner fa fa-spinner fa-spin"></i>{{ __('Guardar') }}</button>
                                <a role="button" href="{{ route('cotizador.admin') }}" class="btn btn-sm btn-danger btn-round">{{ __('Regresar') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Producto') }} <span class="text-required">*</span></label>
                                    <input autocomplete="off" type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ (old('nombre')) ? old('nombre') : $venta->nombre }}">
                                    @if ($errors->has('nombre'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Tipo') }} <span class="text-required">*</span></label>
                                    <select class="form-control @error('tipo_venta_id') is-invalid @enderror" id="tipo_venta_id" name="tipo_venta_id" disabled>
                                        <option value="" selected>[Seleccione Uno]</option>
                                        @foreach ($tipoVenta as $tipo)
                                        <option {{  (@old('tipo_venta_id')) ? (@old('tipo_venta_id') == $tipo->id ? 'selected' : '' ) : ($tipo->id == $venta->tipo_venta_id ? 'selected' : '') }} value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('tipo_venta_id'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('tipo_venta_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ ($venta->mostrar_precio_base == 1) ? '': 'd-none' }}">
                                    <label>{{ __('Precio Base') }}</label>
                                    <input autocomplete="off" type="text" id="precio_base" name="precio_base" class="form-control @error('precio_base') is-invalid @enderror" value="{{ (old('precio_base')) ? old('precio_base') : number_format($venta->precio_base, 0,',','.') }}">
                                    @if ($errors->has('precio_base'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('precio_base') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <h5 class="card-subtitle mb-1">Detalle</h5>
                            </div>
                            <div class="col-md-12">
                                <div class="table">
                                    <table class="table table-striped" id="tablaCotizadorDetalle" data-detalleactualizar="{{ route('cotizador.update.detalle', '@@') }}">
                                    @if ($venta->tipo_venta_id == 1)
                                        <thead class="text-primary text-center">
                                            <th>Desde</th>
                                            <th>Hasta</th>
                                            <th>Valor Implementación</th>
                                            <th>Valor Mantención</th>
                                            <th>Acciones</th>
                                        </thead>
                                        @endif
                                        @if ($venta->tipo_venta_id == 2)
                                        <thead class="text-primary text-center">
                                            <th>Orden</th>
                                            <th>Tipo</th>
                                            <th>Descripción</th>
                                            <th>Precio</th>
                                            <th>Acciones</th>
                                        </thead>
                                        @endif
                                        @if ($venta->tipo_venta_id == 3)
                                        <thead class="text-primary text-center">
                                            <th>Tipo</th>
                                            <th>Descripción</th>
                                            <th>Precio / Precio Mínimo</th>
                                            <th>Precio Máximo</th>
                                            <th>Acciones</th>
                                        </thead>
                                        @endif
                                        @if ($venta->tipo_venta_id == 1)
                                        <tbody>
                                            @foreach($venta->detalleVentas as $detalle)
                                            <tr>
                                                <td class="text-center">{{ $detalle->desde }}</td>
                                                <td class="text-center">{{ $detalle->hasta }}</td>
                                                <td class="text-center">{{ number_format($detalle->valor_implementacion, 0,',','.') }}</td>
                                                <td class="text-center">{{ number_format($detalle->valor_mantencion, 0,',','.') }}</td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group" aria-label="Grupo Acciones">
                                                        <a href="{{ route('cotizador.detalle.edit', $detalle->id) }}" title="Editar" class="btn btn-xs btn-outline-secondary btnEdi"><i class="fa fa-edit"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        @endif
                                        @if ($venta->tipo_venta_id == 2)
                                        <tbody>
                                            @foreach($venta->detalleVentas as $detalle)
                                            <tr>
                                                <td class="text-center">{{ $detalle->orden }}</td>
                                                <td class="text-center">{{ $detalle->tipo_precio }}</td>
                                                <td class="text-center">{{ $detalle->descripcion_tipo_precio }}</td>
                                                <td class="text-center">{{ number_format($detalle->precio, 0,',','.') }}</td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group" aria-label="Grupo Acciones">
                                                        <a href="{{ route('cotizador.detalle.edit', $detalle->id) }}" title="Editar" class="btn btn-xs btn-outline-secondary btnEdi"><i class="fa fa-edit"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        @endif
                                        @if ($venta->tipo_venta_id == 3)
                                        <tbody>
                                            @foreach($venta->detalleVentas as $detalle)
                                            <tr>
                                                <td class="text-left">{{ $detalle->tipo_precio }}</td>
                                                <td class="text-left">{{ $detalle->descripcion_tipo_precio }}</td>
                                                <td class="text-center">{{ ($detalle->precio_minimo > 0) ? number_format($detalle->precio_minimo, 0,',','.') : number_format($detalle->precio, 0,',','.') }}</td>
                                                <td class="text-center">{{ ($detalle->precio_maximo > 0) ? number_format($detalle->precio_maximo, 0,',','.') : ''}}</td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group" aria-label="Grupo Acciones">
                                                        <a href="{{ route('cotizador.detalle.edit', $detalle->id) }}" title="Editar" class="btn btn-xs btn-outline-secondary btnEdi"><i class="fa fa-edit"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                        @if ($venta->valor_multiplicar == 1)
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label>{{ __('Multiplicar cantidad de vendidos') }} </label>
                                    <div class="form-check">
                                        <input type="checkbox" {{ (old('multiplicar')) ? 'checked' : $venta->chk_multiplicar  }} name="multiplicar" value="1" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="outline-success" data-size="sm">
                                        @if ($errors->has('multiplicar'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('multiplicar') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if ($venta->mostrar_extra == 1)
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <h5 class="card-subtitle mb-1">Extra</h5>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>{{ __('Descripción') }}</label>
                                    <input autocomplete="off" type="text" id="descripcion_extra" name="descripcion_extra" class="form-control @error('descripcion_extra') is-invalid @enderror" value="{{ (old('descripcion_extra')) ? old('descripcion_extra') : $venta->descripcion_extra }}">
                                    @if ($errors->has('descripcion_extra'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('descripcion_extra') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ __('Precio') }}</label>
                                    <input autocomplete="off" type="text" id="precio_extra" name="precio_extra" class="form-control @error('precio_extra') is-invalid @enderror" value="{{ (old('precio_extra')) ? old('precio_extra') : $venta->precio_extra }}">
                                    @if ($errors->has('precio_extra'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('precio_extra') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="row text-right">
                            <div class="col-md-12 text-right text-danger">
                                (*) campos obligatorios
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@include('pages.cotizador.modal_detalle')
@push('scripts')
<script src="{{ asset('paper/js/cotizador.js?v='.time()) }}"></script>
@endpush