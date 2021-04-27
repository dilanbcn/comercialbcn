@extends('layouts.app', [
'class' => '',
'elementActive' => 'cliente_nuevo'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="form-prevent-multiple-submits" action="{{ route('cliente.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="card-title mb-1">Agregar nuevo cliente</h5>
                            </div>
                            <div class="col-md-4 text-right">
                                <button type="submit" class="btn btn-sm btn-secondary btn-round button-prevent-submit"><i class="spinner fa fa-spinner fa-spin"></i>{{ __('Guardar') }}</button>
                                <a role="button" href="{{ route('cliente.index') }}" class="btn btn-sm btn-danger btn-round">{{ __('Regresar') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ __('Holding') }}</label>
                                    <input autocomplete="off" type="text" id="holding" name="holding" data-rutaholding="{{ route('clientes.json') }}" class="form-control @error('holding') is-invalid @enderror" value="{{ @old('holding') }}" required>
                                    @if ($errors->has('holding'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('holding') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ __('Cliente') }} <span class="text-required">*</span></label>
                                    <input autocomplete="off" type="text" name="razon_social" class="form-control @error('razon_social') is-invalid @enderror" value="{{ @old('razon_social') }}" required>
                                    @if ($errors->has('razon_social'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('razon_social') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @if (Auth::user()->rol_id == 2)

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ __('Tipo Cliente') }} <span class="text-required">*</span></label>
                                    <select class="form-control @error('tipo_cliente') is-invalid @enderror" id="tipo_cliente" name="tipo_cliente" required>
                                        @foreach ($tipoClientes as $tipoCliente)
                                        <option {{ ( $tipoCliente->id == @old('tipo_cliente')) ? 'selected' : '' }} value="{{ $tipoCliente->id }}">{{ $tipoCliente->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('tipo_cliente'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('tipo_cliente') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ __('Comercial') }} <span class="text-required">*</span></label>
                                    <select class="form-control @error('comercial') is-invalid @enderror" id="comercial" name="comercial" required>
                                        @foreach ($usuarios as $usuario)
                                        <option {{ ( $usuario->id == @old('comercial')) ? 'selected' : ((Auth::user()->id == $usuario->id) ? 'selected' : '') }} value="{{ $usuario->id }}">{{ $usuario->name . ' ' . $usuario->last_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('comercial'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('comercial') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ __('Externo') }}</label>
                                    <select class="form-control @error('externo') is-invalid @enderror" id="externo" name="externo">
                                        <option value="">[Seleccione]</option>
                                        <option {{ (@old('externo') == 'Externo') ? 'selected' : '' }} value="Externo">Si</option>
                                    </select>
                                    @if ($errors->has('externo'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('externo') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ __('Compartido') }}</label>
                                    <select class="form-control @error('compartido_user') is-invalid @enderror" id="compartido_user" name="compartido_user" required>
                                        <option value="" selected>[Seleccione Uno]</option>
                                        @foreach ($usuarios as $usuario)
                                        <option {{ ( $usuario->id == @old('compartido_user') ) ? 'selected' : '' }} value="{{ $usuario->id }}">{{ $usuario->name . ' ' . $usuario->last_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('compartido_user'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('compartido_user') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ __('Rut (Sin puntos ni guión)') }}</label>
                                    <input autocomplete="off" type="text" name="rut" id="usr_create_rut" maxlength="9" class="form-control @error('rut') is-invalid @enderror" value="{{ @old('rut') }}">
                                    @if ($errors->has('rut'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('rut') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ __('Cantidad Empleados') }}</label>
                                    <input autocomplete="off" type="number" name="cantidad_empleados" class="form-control @error('cantidad_empleados') is-invalid @enderror bloquear" value="{{ @old('cantidad_empleados') }}">
                                    @if ($errors->has('cantidad_empleados'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('cantidad_empleados') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ __('Rubro') }}</label>
                                    <input autocomplete="off" type="text" name="rubro" class="form-control @error('rubro') is-invalid @enderror" value="{{ @old('rubro') }}">
                                    @if ($errors->has('rubro'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('rubro') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ __('Teléfono') }}</label>
                                    <input autocomplete="off" type="number" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ @old('telefono') }}">
                                    @if ($errors->has('telefono'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('telefono') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ __('Correo') }}</label>
                                    <input autocomplete="off" type="email" name="email" class="form-control @error('email') is-invalid @enderror bloquear" value="{{ @old('email') }}">
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ __('Confirmación Correo') }}</label>
                                    <input autocomplete="off" type="email" name="email_confirmation" class="form-control @error('email') is-invalid @enderror bloquear" value="{{ @old('email_confirmation') }}">
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Dirección') }}</label>
                                    <input autocomplete="off" type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror" value="{{ @old('direccion') }}">
                                    @if ($errors->has('direccion'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('direccion') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                        </div>
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
@push('scripts')
<script src="{{ asset('paper/js/cliente.js?v='.time()) }}"></script>
@endpush