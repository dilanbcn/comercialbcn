@extends('layouts.app_error', [
'class' => '',
'elementActive' => 'error'
])
@section('content')
<div class="kt-grid kt-grid--ver kt-grid--root">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid  kt-error-v3" style="background-image: url(../../paper/img/bg/bg3.jpg);">
            <div class="kt-error_container">
                <span class="kt-error_number mb-0">
						<h1>{{ $error['numero'] }}</h1>
					</span>
                <p class="kt-error_title kt-font-light">
                    {{ $error['titulo'] }}
                </p>
                <p class="kt-error_description">
                    {!! $error['descripcion'] !!}
                </p>
                <p class="kt-error_subtitle mt-0">
                   <a role="button" href="{{ url('/') }}" class="btn btn-sm btn-primary btn-round">{{ __('Ir al Inicio') }}</a>
                </p>
            </div>
        </div>
    </div>
@endsection