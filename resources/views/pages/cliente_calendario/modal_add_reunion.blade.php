<div class="modal fade" id="add_reunion" tabindex="-1" role="dialog" aria-labelledby="addReunionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form-prevent-multiple-submits" action="{{ route('cliente-calendario.store') }}" id="frm_add_reunion" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="inpt-metodo" name="inpt-metodo" value="{{ @old('inpt-metodo') }}">
                <div class="modal-header">
                    <h5 class="card-title mb-1" style="color: #35D32F;">Agregar Reunión</h5>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>{{ __('Cliente') }} <span class="text-required">*</span></label>
                                        <select class="form-control @error('cliente') is-invalid @enderror cliente optCliente" id="cliente" name="cliente" required>
                                            <option value="" selected>[Seleccione]</option>
                                            @foreach ($clientes as $cliente)
                                            <option {{ ( $cliente->id == @old('cliente')) ? 'selected' : '' }} value="{{ $cliente->id }}">{{ $cliente->razon_social }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('cliente'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('cliente') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Tipo') }} </label>
                                        <select class="form-control @error('tipoComunicacion') is-invalid @enderror" id="updt_tipoComunicacion" name="tipoComunicacion" required>
                                            @foreach ($tipoComunicaciones as $tipo)
                                            <option {{ ( $tipo->id == @old('tipoComunicacion')) ? 'selected' : '' }} value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label>{{ __('Contacto') }} </label>
                                        <select class="form-control @error('contactoId') is-invalid @enderror contactoId" id="contactoId" name="contactoId">
                                            <option value="" selected>[Seleccione]</option>
                                        </select>
                                        @if ($errors->has('contactoId'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('contactoId') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>{{ __('Nuevo Contacto') }} </label>
                                        <div class="form-check">
                                            <input type="checkbox" {{ (@old('nuevoContacto')) ? 'checked' : '' }} name="nuevoContacto" id="nuevoContacto" value="1" data-toggle="toggle" data-off="No" data-on="Si" data-onstyle="outline-success" data-offstyle="outline-dark" data-width="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="row pl-3 pr-3 {{ (@old('nuevoContacto')) ? '' : 'd-none' }}" id="rowContacto" >
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ __('Nombre') }}  <span class="text-required">*</span></label>
                                            <input autocomplete="off" type="text" id="nombreContacto" name="nombreContacto" class="form-control @error('nombreContacto') is-invalid @enderror nombreContacto" value="{{ (@old('nombreContacto')) }}">
                                            @if ($errors->has('nombreContacto'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('nombreContacto') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ __('Apellido') }} </label>
                                            <input autocomplete="off" type="text" id="apellidoContacto" name="apellidoContacto" class="form-control @error('apellidoContacto') is-invalid @enderror apellidoContacto" value="{{ (@old('apellidoContacto')) }}" >
                                            @if ($errors->has('apellidoContacto'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('apellidoContacto') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ __('Cargo') }}</label>
                                            <input autocomplete="off" type="text" id="cargoContacto" name="cargoContacto" class="form-control @error('cargoContacto') is-invalid @enderror cargoContacto" value="{{ (@old('cargoContacto')) }}">
                                            @if ($errors->has('cargoContacto'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('cargoContacto') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ __('Fono Fijo') }} </label>
                                            <input autocomplete="off" type="text" id="fonoContacto" name="fonoContacto" class="form-control @error('fonoContacto') is-invalid @enderror fonoContacto" value="{{ (@old('fonoContacto')) }}">
                                            @if ($errors->has('fonoContacto'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('fonoContacto') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ __('Celular') }} </label>
                                            <input autocomplete="off" type="text" id="celularContacto" name="celularContacto" class="form-control @error('celularContacto') is-invalid @enderror celularContacto" value="{{ (@old('celularContacto')) }}">
                                            @if ($errors->has('celularContacto'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('celularContacto') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ __('Correo') }} </label>
                                            <input autocomplete="off" type="text" id="correoContacto" name="correoContacto" class="form-control @error('correoContacto') is-invalid @enderror correoContacto" value="{{ (@old('correoContacto')) }}">
                                            @if ($errors->has('correoContacto'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('correoContacto') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Fecha Contacto') }} <span class="text-required">*</span></label>
                                        <input autocomplete="off" type="date" name="fechaContacto" class="form-control @error('fechaContacto') is-invalid @enderror fechaContacto" value="{{ (@old('fechaContacto')) ? @old('fechaContacto') : date('Y-m-d', strtotime($hoy)) }}" max="{{ date('Y-m-d', strtotime($hoy)) }}" required>
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
                                        <input autocomplete="off" type="time" name="horaReunion" class="form-control @error('horaReunion') is-invalid @enderror" value="{{ @old('horaReunion') }}" min="{{ date('Y-m-d', strtotime($hoy)) }}">
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
                                            <input type="checkbox" {{ (@old('linkedin')) ? 'checked' : '' }} name="linkedin" value="1" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="outline-success" data-size="sm">
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
                                            <input type="checkbox" {{ (@old('envioCorreo')) ? 'checked' : '' }} name="envioCorreo" value="1" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="outline-success" data-size="sm">
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
                                            <input type="checkbox" {{ (@old('respuesta')) ? 'checked' : '' }} name="respuesta" value="1" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="outline-success" data-size="sm">
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
                                        <textarea name="observaciones" class="form-control @error('observaciones') is-invalid @enderror" rows="5">{{ @old('observaciones') }}</textarea>
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
                    <button type="submit" class="btn btn-sm btn-secondary btn-round button-prevent-submit">Agregar</button>
                    <button type="button" class="btn btn-sm btn-danger btn-round" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>