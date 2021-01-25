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
                                <h5 class="card-title mb-1">Agregar nuevo comercial</h5>
                            </div>
                            <div class="col-md-4 text-right">
                                <button type="submit" class="btn btn-sm btn-secondary btn-round button-prevent-submit"><i class="spinner fa fa-spinner fa-spin"></i>{{ __('Guardar') }}</button>
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
                            </div>
                            <div class="row">
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
                                <div class="col-md-3">
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
                                <div class="col-md-3">
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
                                        <label>{{ __('Correo') }}</label>
                                        <input autocomplete="off" type="email" name="email" class="form-control @error('email') is-invalid @enderror bloquear" value="{{ @old('email') }}" required>
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
                                        <input autocomplete="off" type="email" name="email_confirmation" class="form-control @error('email') is-invalid @enderror bloquear" value="{{ @old('email_confirmation') }}" required>
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