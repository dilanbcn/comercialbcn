@extends('layouts.app', [
'class' => '',
'elementActive' => 'clientes'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="form-prevent-multiple-submits" action="{{ route('cliente.update', $cliente->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="card-title mb-1">Editar cliente</h5>
                            </div>
                            <div class="col-md-4 text-right">
                                <button type="submit" class="btn btn-sm btn-secondary btn-round button-prevent-submit"><i class="spinner fa fa-spinner fa-spin"></i>{{ __('Modificar') }}</button>
                                <a role="button" href="{{ route('cliente.index') }}" class="btn btn-sm btn-danger btn-round">{{ __('Regresar') }}</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Holding') }}</label>
                                        <select class="form-control @error('padre') is-invalid @enderror" id="padre" name="padre">
                                            <option value="" selected>[Seleccione]</option>
                                            @foreach ($holdings as $holding)
                                            <option {{ (@old('padre')) ? (@old('padre') == $holding->id ? 'selected' : '' ) : ($holding->id == $cliente->padre_id ? 'selected' : '') }} value="{{ $holding->id }}">{{ $holding->razon_social }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('padre'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('padre') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Cliente') }} <span class="text-required">*</span></label>
                                        <input autocomplete="off" type="text" name="razon_social" class="form-control @error('razon_social') is-invalid @enderror" value="{{ (old('razon_social')) ? old('razon_social') : $cliente->razon_social }}" required>
                                        @if ($errors->has('razon_social'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('razon_social') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>{{ __('Rut (Sin puntos ni guión)') }}</label>
                                        <input autocomplete="off" type="text" name="rut" id="usr_create_rut" maxlength="9" class="form-control @error('rut') is-invalid @enderror" value="{{ (old('rut')) ? old('rut') : $cliente->rut_format }}">
                                        @if ($errors->has('rut'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('rut') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>{{ __('Estado') }}</label>
                                    <div class="form-check">
                                        <input type="checkbox" {{ ($cliente->activo) ? 'checked' : '' }} name="activo" value="1" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="outline-success" data-size="sm">
                                        @if ($errors->has('activo'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('activo') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-md-2">
                                    <div class="form-group">
                                        <label>{{ __('Cantidad Empleados') }}</label>
                                        <input autocomplete="off" type="number" name="cantidad_empleados" class="form-control @error('cantidad_empleados') is-invalid @enderror bloquear" value="{{ (old('cantidad_empleados')) ? old('cantidad_empleados') : $cliente->cantidad_empleados }}">
                                        @if ($errors->has('cantidad_empleados'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('cantidad_empleados') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>{{ __('Teléfono') }}</label>
                                        <input autocomplete="off" type="number" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ (old('telefono')) ? old('telefono') : $cliente->telefono }}">
                                        @if ($errors->has('telefono'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('telefono') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Correo') }}</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ (old('email')) ? old('email') : $cliente->email }}">
                                        @if ($errors->has('email'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Confirmación Correo') }}</label>
                                        <input type="email" name="email_confirmation" class="form-control @error('email') is-invalid @enderror" value="{{ (old('email_confirmation')) ? old('email_confirmation') : $cliente->email }}">
                                        @if ($errors->has('email'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                               
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label>{{ __('Dirección') }}</label>
                                        <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror" value="{{ (old('direccion')) ? old('direccion') : $cliente->direccion }}">
                                        @if ($errors->has('direccion'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('direccion') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ __('Rubro') }}</label>
                                        <input type="text" name="rubro" class="form-control @error('rubro') is-invalid @enderror" value="{{ (old('rubro')) ? old('rubro') : $cliente->rubro }}">
                                        @if ($errors->has('rubro'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('rubro') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                @if (Auth::user()->rol_id == 2)
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>{{ __('Tipo Cliente') }} <span class="text-required">*</span></label>
                                        <select class="form-control @error('tipo_cliente') is-invalid @enderror" id="tipo_cliente" name="tipo_cliente" required>
                                            @foreach ($tipoClientes as $tipoCliente)
                                            <option {{  (@old('tipo_cliente')) ? (@old('tipo_cliente') == $tipoCliente->id ? 'selected' : '' ) : ($tipoCliente->id == $cliente->tipo_cliente_id ? 'selected' : '') }} value="{{ $tipoCliente->id }}">{{ $tipoCliente->nombre }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('tipo_cliente'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('tipo_cliente') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>{{ __('Inicio Relación') }}</label>
                                        <input autocomplete="off" type="date" name="inicio_relacion" class="form-control @error('inicio_relacion') is-invalid @enderror inicio_relacion" value="{{ (@old('inicio_relacion')) ? @old('inicio_relacion') : ( $cliente->inicio_relacion ? date('d/m/Y', strtotime($cliente->inicio_relacion)) : '' )       }}" max="{{ date('Y-m-d', strtotime($hoy)) }}">

                                        @if ($errors->has('inicio_relacion'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('inicio_relacion') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Comercial Origen') }} <span class="text-required">*</span></label>
                                        <select class="form-control @error('comercial') is-invalid @enderror" id="comercial" name="comercial" required>
                                            @foreach ($usuarios as $usuario)
                                            <option {{  (@old('comercial')) ? (@old('comercial') == $usuario->id ? 'selected' : '' ) : ($usuario->id == $cliente->user_id ? 'selected' : '') }} value="{{ $usuario->id }}">{{ $usuario->name . ' ' . $usuario->last_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('comercial'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('comercial') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Comercial Destino') }} </label>
                                        <select class="form-control @error('comercialDestino') is-invalid @enderror" id="comercialDestino" name="comercialDestino" required>
                                            <option value="">[Seleccione Uno]</option>    
                                        @foreach ($usuarios as $usuario)
                                            <option {{  (@old('comercialDestino')) ? (@old('comercialDestino') == $usuario->id ? 'selected' : '' ) : ($usuario->id == $cliente->destino_user_id ? 'selected' : '') }} value="{{ $usuario->id }}">{{ $usuario->name . ' ' . $usuario->last_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('comercialDestino'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('comercialDestino') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection