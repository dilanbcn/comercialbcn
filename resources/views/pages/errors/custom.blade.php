@extends('layouts.app_nonavbar', [
'class' => '',
'elementActive' => 'error'
])
@section('content')
<style>
.kt-error-v3 .kt-error_container .kt-error_number > h1 {
    font-size: 15.7rem;
    margin-left: 7.85rem;
    margin-top: 11.4rem;
    font-weight: 500;
    -webkit-text-stroke-width: 0.35rem;
    color: #A3DCF0;
    -webkit-text-stroke-color: white;
}
.kt-error-v3 {
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
}
</style>
<!--begin::Error-->
<div class="d-flex flex-row-fluid flex-column bgi-size-cover bgi-position-center bgi-no-repeat p-10 p-sm-30" style="background-image: url('paper/img/bg3.jpg'); height: 100%;">
    <!--begin::Content-->
    <h1 class="font-weight-boldest text-dark-75 mt-15" style="font-size: 10rem;">
        404
    </h1>
    <p class="font-size-h3 text-muted font-weight-normal">
        OOPS! Something went wrong here
    </p>
    <!--end::Content-->
</div>
<!--end::Error-->
@endsection