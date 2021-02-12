@extends('layouts.app', [
'class' => '',
'elementActive' => 'indicadores'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="card-title mb-1">{{ __('Criterios de Búsqueda') }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form-prevent-multiple-submits" id="frm_filtar_indicador" action="{{ route('prospeccion.indicadores') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div class="row  align-items-center">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ __('Comercial') }}</label>
                                    <select class="form-control @error('comercialId') is-invalid @enderror" id="comercialId" name="comercialId" required>
                                        <option value="">[Selecciones Uno]</option>
                                        <option value="all" {{ (@old('comercialId') == 'all') ? 'selected' : ( $inptComercial == 'all' ? 'selected' : '' ) }}>Todos los comerciales</option>
                                        @foreach ($comerciales as $comercial)
                                        <option {{  ($comercial->id == @old('comercialId')) ? 'selected' : ( $comercial->id == $inptComercial ? 'selected' : '' ) }} value="{{ $comercial->id }}">{{ $comercial->name . ' ' . $comercial->last_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('comercialId'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('comercialId') }}</strong>
                                        </span>
                                        @endif
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>{{ __('Desde') }}</label>
                                    <input autocomplete="off" type="date" name="desde" class="form-control @error('desde') is-invalid @enderror desde" value="{{ (@old('hasta')) ? @old('hasta') : $desde }}" max="{{ date('Y-m-d', strtotime(date('Y-m-d'))) }}" required>
                                    @if ($errors->has('desde'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('desde') }}</strong>
                                        </span>
                                        @endif
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>{{ __('Hasta') }}</label>
                                    <input autocomplete="off" type="date" name="hasta" class="form-control @error('hasta') is-invalid @enderror hasta" value="{{ (@old('hasta')) ? @old('hasta') : $hasta }}" max="{{ date('Y-m-d', strtotime(date('Y-m-d'))) }}" required>
                                    @if ($errors->has('hasta'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('hasta') }}</strong>
                                        </span>
                                        @endif
                                </div>
                            </div>
                            <div class="col-md-4 pt-2">
                                <button type="submit" class="btn btn-sm btn-info btn-round button-prevent-submit"><i class="spinner fa fa-spinner fa-spin"></i>{{ __('Buscar') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if ($show)
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <h5 class="card-title mb-1">{{ __('Indicadores Prospección') }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table table-responsive">
                        <table class="table table-striped tablaIndicadores">
                            <thead class="text-primary text-center">
                                <tr>
                                    <th rowspan="2">Nombre</th>
                                    <th rowspan="2">Concepto</th>
                                    @foreach($arrHead as $head)
                                    <th colspan="2">{{ $head }}</th>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($arrHead as $head)
                                    <th>Cant</th>
                                    <th>%</th>
                                    @endforeach
                                </tr>

                            </thead>
                            <tbody>
                                @foreach($arrData as $key => $data)
                                <tr>
                                    @foreach($data['contactados'] as $valor)
                                    <td class="text-center">{{ $valor }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($data['reuniones'] as $valor)
                                    <td class="text-center">{{ $valor }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($data['cerrados'] as $valor)
                                    <td class="text-center">{{ $valor }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($data['ingresos'] as $valor)
                                    <td class="text-center">{{ $valor }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection