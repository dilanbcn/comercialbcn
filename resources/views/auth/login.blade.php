@extends('layouts.app', [
'class' => 'login-page',
'backgroundImagePath' => 'img/bg/background.jpg'
])

@section('content')

<div class="content">
    <div class="container">
        @if (session('error'))
        <div class="row">
            <div class="col-md-6 ml-auto mr-auto">
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                    </button>
                    <span> {{ session('error') }}</span>
                </div>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-md-6 ml-auto mr-auto login-form-2">
                <h3>{{ __('Iniciar Sesión') }}</h3>
                <form class="form" method="POST" action="{{ route('custom-login') }}">
                    @csrf
                    <div class="form-group">
                        <input class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="{{ __('Usuario') }}" type="text" name="username" value="{{ old('username') }}" required autofocus>
                        @if ($errors->has('username'))
                        <span class="invalid-text" style="display: block;" role="alert">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Clave') }}" type="password" required>
                        @if ($errors->has('password'))
                        <span class="invalid-text" style="display: block;" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-light btn-round mb-3">{{ __('Ingresar') }}</button>
                    </div>
                </form>

            </div>

        </div>
        <div class="row">
            <div class="col-md-6 ml-auto mr-auto">
                <a href="{{ route('password.request') }}" class="btn btn-link">
                    {{ __('Olvidó su contraseña') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        graficos.checkFullPageBackgroundImage();
    });
</script>
@endpush