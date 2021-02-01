@extends('layouts.app', [
'class' => '',
'elementActive' => 'clientes'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="form-prevent-multiple-submits" action="{{ route('cliente-contacto.store', [$cliente->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="card-title mb-1">Agregar nuevo contacto</h5>
                                <p class="card-category">Cliente: {{ $cliente->razon_social }}</p>

                            </div>
                            <div class="col-md-4 text-right">
                                <button type="submit" class="btn btn-sm btn-secondary btn-round button-prevent-submit"><i class="spinner fa fa-spinner fa-spin"></i>{{ __('Guardar') }}</button>
                                <a role="button" href="{{ route('cliente-contacto.index', [$cliente->id]) }}" class="btn btn-sm btn-danger btn-round">{{ __('Regresar') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ __('Nombre') }} <span class="text-required">*</span></label>
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
                                    <label>{{ __('Apellido') }} <span class="text-required">*</span></label>
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
                                    <input autocomplete="off" type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ @old('telefono') }}">
                                    @if ($errors->has('telefono'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('telefono') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>{{ __('Celular') }}</label>
                                    <input autocomplete="off" type="text" name="celular" class="form-control @error('celular') is-invalid @enderror" value="{{ @old('celular') }}">
                                    @if ($errors->has('celular'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('celular') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2">
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
                            <div class="col-md-2">
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