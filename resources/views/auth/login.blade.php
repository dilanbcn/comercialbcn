@extends('layouts.app', [
'class' => 'login-page',
'backgroundImagePath' => 'img/bg/background.jpg'
])

@section('content')

<div class="content">
    <div class="container">
        
        <div class="row mb-5">
            <div class="col-md-5 ml-auto mr-auto">
                <img src="{{ asset('paper/img/img_login.png') }}">
            </div>
        </div>
        @if (session('error'))
        <div class="row">
            <div class="col-md-5 ml-auto mr-auto">
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                    </button>
                    <span> {{ session('error') }}</span>
                </div>
            </div>
        </div>
        @endif
        <form class="form" method="POST" action="{{ route('custom-login') }}">
            @csrf
            <div class="row">
                <div class="col-md-5 ml-auto mr-auto">
                    <div class="input-group input-group-lg mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-user" style="width: 45px !important; color:white; opacity:unset !important;"></i></span>
                        </div>
                        <input class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="{{ __('Nombre de usuario') }}" type="text" name="username" value="{{ old('username') }}" required autofocus>
                        @if ($errors->has('username'))
                        <span class="invalid-text" style="display: block;" role="alert">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="input-group input-group-lg">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-lock" style="width: 45px !important; color:white; opacity:unset !important;"></i></span>
                        </div>
                        <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('******') }}" type="password" required>
                        @if ($errors->has('password'))
                    <span class="invalid-text" style="display: block;" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                    </div>
                    <button type="submit" class="btn btn-success btn-lg btn-block mt-5">ENTRAR</button>
                </div>
            </div>
        </form>
        <div class="row mt-5">
            <div class="col-md-5 ml-auto mr-auto text-right pr-0">
                <hr style="background-color: #9EABBE;">
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