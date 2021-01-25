@extends('layouts.app', [
'class' => '',
'elementActive' => 'usuario'
])

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="form-prevent-multiple-submits" action="{{ route('user.update', $usuario->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="card-title mb-1">Editar usuario</h5>
                            </div>
                            <div class="col-md-4 text-right">
                                <button type="submit" class="btn btn-sm btn-secondary btn-round button-prevent-submit"><i class="spinner fa fa-spinner fa-spin"></i>{{ __('Modificar') }}</button>
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
                                            <option {{ (@old('departamento')) ? (@old('departamento') == $departamento->id ? 'selected' : '') : ($departamento->id == $usuario->departamento_id ? 'selected' : '') }} value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
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
                                            <option {{ (@old('rol')) ? (@old('rol') == $rol->id ? 'selected' : '' ) : ($rol->id == $usuario->rol_id ? 'selected' : '') }} value="{{ $rol->id }}">{{ $rol->nombre }}</option>
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
                                        <label>{{ __('Institución')}}</label>
                                        <select class="form-control @error('institucion') is-invalid @enderror" id="institucion" name="institucion">
                                            <option value="" selected>[Seleccione]</option>
                                            @foreach ($instituciones as $institucion)
                                            <option {{ (@old('institucion')) ? (@old('institucion') == $institucion->id ? 'selected' : '') : ($institucion->id == $usuario->institucion_id ? 'selected' : '')}} value="{{ $institucion->id }}">{{ $institucion->nombre }}</option>
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
                                        <input autocomplete="off" type="text" name="rut" id="usr_create_rut" maxlength="9" class="form-control @error('rut') is-invalid @enderror" value="{{ (old('rut')) ? old('rut') : $usuario->rut_format }}" required>
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
                                        <input autocomplete="off" type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ (old('nombre')) ? old('nombre') : $usuario->name }}" required>
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
                                        <input autocomplete="off" type="text" name="apellido" class="form-control @error('apellido') is-invalid @enderror" value="{{ (old('apellido')) ? old('apellido') : $usuario->last_name }}" required>
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
                                        <input autocomplete="off" type="text" name="telefono" maxlength="9" id="usr_create_telefono" placeholder="9XXXXXXXX" class="form-control @error('telefono') is-invalid @enderror" value="{{ (old('telefono')) ? old('telefono') : $usuario->phone1 }}">
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
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ (old('email')) ? old('email') : $usuario->email }}" required>
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
                                        <input type="email" name="email_confirmation" class="form-control @error('email') is-invalid @enderror" value="{{ (old('email_confirmation')) ? old('email_confirmation') : $usuario->email }}" required>
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
                                            <option {{ (@old('nombrePais')) ? (@old('nombrePais') == $pais->id ? 'selected' : '') : ($pais->id == $usuario->pais_id ? 'selected' : '') }} value="{{ $pais->id }}">{{ $pais->nombre }}</option>
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
                                        <select class="form-control @error('nombreRegion') is-invalid @enderror" id="nombreRegion" name="nombreRegion">
                                            <option value="" selected>[Seleccione]</option>
                                            @foreach ($regiones as $region)
                                            <option {{ (@old('nombreRegion')) ? (@old('nombreRegion') == $region->id ? 'selected' : '') : ($region->id == $usuario->region_id ? 'selected' : '') }} value="{{ $region->id }}">{{ $region->nombre }}</option>
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
                                        <select class="form-control @error('nombreComuna') is-invalid @enderror" id="nombreComuna" name="nombreComuna">
                                            <option value="" selected>[Seleccione]</option>
                                            @foreach ($comunas as $comuna)
                                            <option {{ (@old('nombreComuna')) ? (@old('nombreComuna') == $comuna->id ? 'selected' : '') : ($comuna->id == $usuario->comuna_id ? 'selected' : '') }} value="{{ $comuna->id }}">{{ $comuna->nombre }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('nombreComuna'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('nombreComuna') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label>{{ __('Direccion') }}</label>
                                        <input autocomplete="off" type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror" value="{{ (old('direccion')) ? old('direccion') : $usuario->address }}">
                                        @if ($errors->has('direccion'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('direccion') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>{{ __('Estado') }}</label>
                                    <div class="form-check">
                                        <input type="checkbox" {{ ($usuario->activo) ? 'checked' : '' }} name="activo" value="1" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="outline-success" data-size="sm">
                                        @if ($errors->has('activo'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('activo') }}</strong>
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