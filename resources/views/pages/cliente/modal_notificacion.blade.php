<div class="modal fade" id="modal_notificacion_comercial" tabindex="-1" role="dialog" aria-labelledby="asignarProspector" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form-prevent-multiple-submits" action="{{ route('notificaciones.comerciales', ['cli@', 'des@']) }}" id="frm_modal_notificacion_comercial" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="inpt-metodo" name="inpt-metodo" value="{{ @old('inpt-metodo') }}">
                <div class="modal-header">
                    <h5 class="card-title mb-1" style="color: #35D32F;">Nueva Notificación</h5>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Para') }}</label>
                                        <h4 class="mt-0" id="inptNomComercial"></h4>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Cliente') }} </label>
                                        <h4 class="mt-0" id="inptNomCliente"></h4>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('Contenido') }} <span class="text-required">*</span></label>
                                        <textarea name="contenido" class="form-control @error('contenido') is-invalid @enderror" id="not_contenido" rows="5">{{ @old('contenido') }}</textarea>
                                        @if ($errors->has('contenido'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('contenido') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-secondary btn-round button-prevent-submit">Enviar</button>
                    <button type="button" class="btn btn-sm btn-danger btn-round" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>