@extends('layouts.app', [
'class' => '',
'elementActive' => 'usuario'
])

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="form-prevent-multiple-submits" action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="card-title mb-1">Agregar nuevo usuario</h5>
                            </div>
                            <div class="col-md-4 text-right">
                                <button type="submit" class="btn btn-sm btn-secondary btn-round button-prevent-submit"><i class="spinner fa fa-spinner fa-spin"></i>{{ __('Guardar') }}</button>
                                <a role="button" href="{{ route('user.index') }}" class="btn btn-sm btn-danger btn-round">{{ __('Regresar') }}</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ __('Departamento') }}</label>
                                        <select class="form-control @error('departamento') is-invalid @enderror" id="departamento" name="departamento" required>
                                            <option value="" selected>[Seleccione]</option>
                                            @foreach ($departamentos as $departamento)
                                            <option {{ ( $departamento->id == @old('departamento')) ? 'selected' : ''}} value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('departamento'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('departamento') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ __('Rol') }}</label>
                                        <select class="form-control @error('rol') is-invalid @enderror" id="rol" name="rol" required>
                                            <option value="" selected>[Seleccione]</option>
                                            @foreach ($roles as $rol)
                                            <option {{ ( $rol->id == @old('rol')) ? 'selected' : ''}} value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('rol'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('rol') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Institución') }}</label>
                                        <select class="form-control @error('institucion') is-invalid @enderror" id="institucion" name="institucion">
                                            <option value="" selected>[Seleccione]</option>
                                            @foreach ($instituciones as $institucion)
                                            <option {{ ( $institucion->id == @old('institucion')) ? 'selected' : ''}} value="{{ $institucion->id }}">{{ $institucion->nombre }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('institucion'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('institucion') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>{{ __('Rut (Sin puntos ni guión)') }}</label>
                                        <input autocomplete="off" type="text" name="rut" id="usr_create_rut" maxlength="9" class="form-control @error('rut') is-invalid @enderror" value="{{ @old('rut') }}" required>
                                        @if ($errors->has('rut'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('rut') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Nombres') }}</label>
                                        <input autocomplete="off" type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ @old('nombre') }}" required>
                                        @if ($errors->has('nombre'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('nombre') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Apellidos') }}</label>
                                        <input autocomplete="off" type="text" name="apellido" class="form-control @error('apellido') is-invalid @enderror" value="{{ @old('apellido') }}" required>
                                        @if ($errors->has('apellido'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('apellido') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>{{ __('Teléfono') }}</label>
                                        <input autocomplete="off" type="number" name="telefono" maxlength="9" id="usr_create_telefono" placeholder="9XXXXXXXX" class="form-control @error('telefono') is-invalid @enderror" value="{{ @old('telefono') }}">
                                        @if ($errors->has('telefono'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('telefono') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>{{ __('Correo') }}</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror bloquear" value="{{ @old('email') }}" required>
                                        @if ($errors->has('email'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>{{ __('Confirmación Correo') }}</label>
                                        <input type="email" name="email_confirmation" class="form-control @error('email') is-invalid @enderror bloquear" value="{{ @old('email_confirmation') }}" required>
                                        @if ($errors->has('email'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>{{ __('País') }}</label>
                                        <select class="form-control @error('nombrePais') is-invalid @enderror" id="nombrePais" name="nombrePais">
                                            <option value="" selected>[Seleccione]</option>
                                            @foreach ($paises as $pais)
                                            <option {{ ( $pais->id == @old('nombrePais')) ? 'selected' : ''}} value="{{ $pais->id }}">{{ $pais->nombre }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('nombrePais'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('nombrePais') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ __('Región') }}</label>
                                        <select {{ (@old('nombrePais')) ? '' : 'disabled' }} class="form-control @error('nombreRegion') is-invalid @enderror" id="nombreRegion" name="nombreRegion">
                                            <option value="" selected>[Seleccione]</option>
                                            @foreach ($regiones as $region)
                                            <option {{ ( $region->id == @old('nombrePais')) ? 'selected' : ''}} value="{{ $region->id }}">{{ $region->nombre }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('nombreRegion'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('nombreRegion') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ __('Comuna') }}</label>
                                        <select {{ (@old('nombreComuna')) ? '' : 'disabled' }} class="form-control @error('nombreComuna') is-invalid @enderror" id="nombreComuna" name="nombreComuna">
                                            <option value="" selected>[Seleccione]</option>
                                            @foreach ($comunas as $comunas)
                                            <option {{ ( $comunas->id == @old('nombreComuna')) ? 'selected' : ''}} value="{{ $comunas->id }}">{{ $comunas->nombre }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('nombreComuna'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('nombreComuna') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('Direccion') }}</label>
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
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection