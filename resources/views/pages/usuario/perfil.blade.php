@extends('layouts.app', [
'class' => '',
'elementActive' => 'perfil'
])
@section('content')
<div class="content">
    @include('layouts.page_templates.messages')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-user">
                <div class="image">
                    <img src="{{ asset('paper/img/damir-bosnjak.jpg') }}" alt="...">
                </div>
                <div class="card-body">
                    <div class="author">
                        <a href="#">
                            <img class="avatar border-gray" src="{{ asset('paper/img/default-avatar.png') }}" alt="...">
                            <h5 class="title text-center">{{ __($usuario->name) }}</h5>
                        </a>
                        <p class="description text-left">{{ __('RUT: '.$usuario->id_number) }}</p>
                        <p class="description text-left">{{ __('Correo: '.$usuario->email) }}</p>
                        <p class="description text-left">{{ __('Institución: '.$usuario->institucion->nombre) }}</p>
                        <p class="description text-left">{{ __('Departamento: '.$usuario->departamento->nombre) }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <form class="col-md-12" action="{{ route('perfil.update', $usuario->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="card-title mb-1">{{ __('Perfil')}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ __('Nombres') }}</label>
                                    <input disabled autocomplete="off" type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ (old('nombre')) ? old('nombre') : $usuario->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ __('Apellidos') }}</label>
                                    <input disabled autocomplete="off" type="text" name="apellido" class="form-control @error('apellido') is-invalid @enderror" value="{{ (old('apelliddo')) ? old('apelliddo') : $usuario->last_name }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ __('Correo') }}</label>
                                    <input disabled type="email" name="correo" class="form-control" value="{{ $usuario->email }}">

                                </div>
                            </div>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
       
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Mis Evaluaciones') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped">
                            <thead class="text-primary text-center">
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Fecha Inicio</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                @if($evaluaciones->count())
                                @foreach($evaluaciones as $key => $miEvaluacion)
                                @if($miEvaluacion->evaluacion->estado_evaluacion_id > 1)
                                <tr class="text-center">
                                    <td>{{ $miEvaluacion->evaluacion->nombre }}</td>
                                    <td>{{ $miEvaluacion->evaluacion->descripcion }}</td>
                                    <td>{{ ($miEvaluacion->fecha_inicio) ? date('d/m/Y', strtotime($miEvaluacion->fecha_inicio)) : '' }}</td>
                                    <td>{{ $miEvaluacion->estadoEvaluacionEmpleado->nombre }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Grupo Acciones">
                                            @if($miEvaluacion->estado_evaluacion_empleado_id != 3 && $miEvaluacion->estado_evaluacion_empleado_id < 4) <a href="{{ route('evaluacion-empleado.iniciar', $miEvaluacion->id) }}" title="Responder Evaluación" class="btn btn-xs btn-outline-secondary"><i class="fas fa-file-signature"></i></a>
                                                @else
                                                <a href="{{ route('evaluacion-empleado.show', $miEvaluacion->id) }}" title="Ver Evaluación" class="btn btn-xs btn-outline-secondary"><i class="fa fa-eye"></i></a>
                                                @endif
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="text-center">No hay registros</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection