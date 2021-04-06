<div class="modal fade" id="modal_inicio_relacion" tabindex="-1" role="dialog" aria-labelledby="inicioRelacionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form-prevent-multiple-submits" action="" id="frm_inicio_relacion" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="inpt-ruta" name="inpt-ruta" value="{{ @old('inpt-ruta') }}">
                <div class="modal-header">
                    <h5 class="card-title mb-1" style="color: #35D32F;">Editar Inicio Relación</h5>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Inicio Relación') }} <span class="text-required">*</span></label>
                                        <input autocomplete="off" type="date" name="inicio_relacion" id="inp_inicio_relacion" class="form-control @error('inicio_relacion') is-invalid @enderror inicio_relacion" max="{{ date('Y-m-d') }}">

                                        @if ($errors->has('inicio_relacion'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('inicio_relacion') }}</strong>
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
                    <button type="submit" class="btn btn-sm btn-secondary btn-round button-prevent-submit">Modificar</button>
                    <button type="button" class="btn btn-sm btn-danger btn-round" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>