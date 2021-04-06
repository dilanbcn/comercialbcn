<div class="modal fade" id="modal_cambio_pass" data-valorpass="{{ ($errors->has('old_password') || $errors->has('password') || $errors->has('password_confirmation')) ? 1 : 0 }}" data-nombre="modal_cambio_pass" tabindex="-1" role="dialog" aria-labelledby="cambioPassModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xs" role="document">
        <div class="modal-content">
            <form class="form-prevent-multiple-submits" action="{{ route('usuario.contrasena') }}" id="frm_cambio_pass" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="inpt-ruta" name="inpt-ruta" value="{{ Request::route()->getName() }}">
                <div class="modal-header">
                    <h5 class="card-title mb-1" style="color: #35D32F;">Cambiar Contraseña</h5>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('Contraseña Actual') }} <span class="text-required">*</span></label>
                                        <input autocomplete="off" type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror">

                                        @if ($errors->has('old_password'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('Contraseña Nueva') }} <span class="text-required">*</span></label>
                                        <input autocomplete="off" type="password" name="password" class="form-control @error('password') is-invalid @enderror">

                                        @if ($errors->has('password'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('Confirmar Contraseña') }} <span class="text-required">*</span></label>
                                        <input autocomplete="off" type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">

                                        @if ($errors->has('password_confirmation'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
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