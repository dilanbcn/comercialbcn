@extends('layouts.app', [
    'class' => 'login-page',
    'backgroundImagePath' => 'img/bg/fabio-mangione.jpg'
])

@section('content')
    <div class="content">
        <div class="container">
        <div class="row">
            <div class="col-md-6 ml-auto mr-auto login-form-2">
                <h3>{{ __('Reestablecer Clave') }}</h3>
                <form class="form" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group">
                        <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Correo') }}" type="email" name="email" value="{{ old('email') }}" required autofocus>
                        @if ($errors->has('email'))
                        <span class="invalid-text" style="display: block;" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-light btn-round mb-3">{{ __('Reestablecer') }}</button>
                        <a role="button" href="{{ url()->previous() }}" class="btn btn-outline-light btn-round mb-3">{{ __('Cancelar') }}</a>
                    </div>
                </form>
            </div>
        </div>
           
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            demo.checkFullPageBackgroundImage();
        });
    </script>
@endpush