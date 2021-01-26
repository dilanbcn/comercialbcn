<div class="modal fade" id="add_proyecto_cliente" tabindex="-1" role="dialog" aria-labelledby="proyectosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form-prevent-multiple-submits" action="{{ route('proyecto.store', $cliente->id) }}" id="frm_add_proyectos" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="card-title mb-1" style="color: #35D32F;">Agregar nuevo proyecto</h5>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-8">
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
                                        <label>{{ __('Fecha Cierre') }}</label>
                                        <input autocomplete="off" type="date" name="fechaCierre" class="form-control @error('fechaCierre') is-invalid @enderror" value="{{ @old('fechaCierre') }}" required>
                                        @if ($errors->has('fechaCierre'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('fechaCierre') }}</strong>
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
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-secondary btn-round button-prevent-submit">Guardar</button>
                    <button type="button" class="btn btn-sm btn-danger btn-round" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>