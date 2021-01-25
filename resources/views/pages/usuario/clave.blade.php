@extends('layouts.app', [
'class' => '',
'elementActive' => 'password'
])
@section('content')
<div class="content">
    @include('layouts.page_templates.messages')
    <div class="row">
        
        
        <div class="col-md-12">
            <div class="card">
                <form class="col-md-12" action="{{ route('user.password') }}" method="POST">
                    @csrf
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="card-title mb-1">{{ __('Cambiar Clave')}}</h5>
                            </div>
                            <div class="col-md-4 text-right">
                                <button type="submit" class="btn btn-sm btn-secondary btn-round button-prevent-submit"><i class="spinner fa fa-spinner fa-spin"></i>{{ __('Cambiar') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <label class="col-md-3 col-form-label">{{ __('Clave Actual') }}</label>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="password" name="clave_anterior" class="form-control" placeholder="Clave Actual" required>
                                    @if ($errors->has('clave_anterior'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('clave_anterior') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">{{ __('Nueva Clave') }}</label>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" placeholder="Nueva Clave" required>
                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">{{ __('Confirmar Clave') }}</label>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar Clave" required>
                                    @if ($errors->has('password_confirmation'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>
@endsection