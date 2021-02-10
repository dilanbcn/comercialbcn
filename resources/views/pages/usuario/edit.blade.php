@extends('layouts.app', [
'class' => '',
'elementActive' => 'comerciales'
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
                                <h5 class="card-title mb-1">Editar comercial</h5>
                            </div>
                            <div class="col-md-4 text-right">
                                <button type="submit" class="btn btn-sm btn-secondary btn-round button-prevent-submit"><i class="spinner fa fa-spinner fa-spin"></i>{{ __('Modificar') }}</button>
                                <a role="button" href="{{ route('user.index') }}" class="btn btn-sm btn-danger btn-round">{{ __('Regresar') }}</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
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
                            <div class="row">
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
                                <div class="col-md-3">
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
                                <div class="col-md-3">
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
                                
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection