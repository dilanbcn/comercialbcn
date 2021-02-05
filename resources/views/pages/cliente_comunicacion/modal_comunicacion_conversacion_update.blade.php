<div class="modal fade" id="upd_comunicacion_conversacion" tabindex="-1" role="dialog" aria-labelledby="updateComunicacionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form-prevent-multiple-submits frm_modal_update" action="" id="frm_upd_comunicacion_conversacion" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" class="inpt-metodo" name="inpt-metodo" value="{{ @old('inpt-metodo') }}">
                <input type="text" class="inpt-ruta" name="inpt-ruta" value="{{ @old('inpt-ruta') }}">
                <div class="modal-header">
                    <h5 class="card-title mb-1" style="color: #35D32F;">Editar comunicación con el cliente</h5>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label class="mb-0">{{ __('Cliente') }}</label>
                                        <h4 class="mt-0">{{ $cliente->razon_social }}</h4>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>{{ __('Tipo') }} </label>
                                        <div class="form-check">
                                            <input type="checkbox" {{ (@old('tipoComunicacion')) ? 'checked' : '' }} id="tipoComunicacion" name="tipoComunicacion" value="1" data-toggle="toggle" data-off="Correo" data-on="Llamada" data-offstyle="outline-info" data-onstyle="outline-warning" data-width="100">
                                            @if ($errors->has('tipoComunicacion'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('tipoComunicacion') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Fecha Contacto') }} <span class="text-required">*</span></label>
                                        <input autocomplete="off" type="date" id="fechaContacto" name="fechaContacto" class="form-control @error('fechaContacto') is-invalid @enderror fechaContacto" value="{{ (@old('fechaContacto')) ? @old('fechaContacto') : date('Y-m-d', strtotime($hoy)) }}" max="{{ date('Y-m-d', strtotime($hoy)) }}" required>
                                        @if ($errors->has('fechaContacto'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('fechaContacto') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ __('Agenda Reunión') }}</label>
                                        <input autocomplete="off" type="date" id="fechaReunion" name="fechaReunion" class="form-control @error('fechaReunion') is-invalid @enderror" value="{{ @old('fechaReunion') }}" min="{{ date('Y-m-d', strtotime($hoy)) }}">
                                        @if ($errors->has('fechaReunion'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('fechaReunion') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ __('Hora Reunión') }}</label>
                                        <input autocomplete="off" type="time" id="horaReunion" name="horaReunion" class="form-control @error('horaReunion') is-invalid @enderror" value="{{ @old('horaReunion') }}" min="{{ date('Y-m-d', strtotime($hoy)) }}">
                                        @if ($errors->has('horaReunion'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('horaReunion') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Acepta LinkedIn') }}</label>
                                        <div class="form-check">
                                            <input type="checkbox" {{ (@old('linkedin')) ? 'checked' : '' }} id="linkedin" name="linkedin" value="1" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="outline-success" data-size="sm">
                                            @if ($errors->has('linkedin'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('linkedin') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Envío de Correo') }} </label>
                                        <div class="form-check">
                                            <input type="checkbox" {{ (@old('envioCorreo')) ? 'checked' : '' }} id="envioCorreo" name="envioCorreo" value="1" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="outline-success" data-size="sm">
                                            @if ($errors->has('envioCorreo'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('envioCorreo') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Respuesta') }} </label>
                                        <div class="form-check">
                                            <input type="checkbox" {{ (@old('respuesta')) ? 'checked' : '' }} id="respuesta" name="respuesta" value="1" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="outline-success" data-size="sm">
                                            @if ($errors->has('respuesta'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('respuesta') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('Observaciones') }} <span class="text-required">*</span></label>
                                        <textarea id="observaciones" name="observaciones" class="form-control @error('observaciones') is-invalid @enderror" rows="5">{{ @old('observaciones') }}</textarea>
                                        @if ($errors->has('observaciones'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('observaciones') }}</strong>
                                        </span>
                                        @endif
                                    </div>
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