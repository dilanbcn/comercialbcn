<div class="modal fade" id="modal_update_prospeccion_contacto" tabindex="-1" role="dialog" aria-labelledby="contactoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form-prevent-multiple-submits frm_modal_update" action="" id="frm_update_prospeccion_contacto" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" class="inpt-metodo" name="inpt-metodo" value="{{ @old('inpt-metodo') }}">
                <input type="hidden" class="inpt-ruta" name="inpt-ruta" value="{{ @old('inpt-ruta') }}">
                <div class="modal-header">
                    <h5 class="card-title mb-1" style="color: #35D32F;">Editar contacto</h5>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('Cliente') }} <span class="text-required">*</span></label>
                                        <select class="form-control @error('cliente') is-invalid @enderror cliente" name="cliente" id="cliente" required>
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
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>{{ __('Nombre') }} <span class="text-required">*</span></label>
                                        <input autocomplete="off" type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror nombre" value="{{ @old('nombre') }}" required>
                                        @if ($errors->has('nombre'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('nombre') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>{{ __('Apellido') }} </label>
                                        <input autocomplete="off" type="text" id="apellido" name="apellido" class="form-control @error('apellido') is-invalid @enderror apellido" value="{{ @old('apellido') }}">
                                        @if ($errors->has('apellido'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('apellido') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>{{ __('Estado') }} <span class="text-required">*</span></label>
                                        <div class="form-check">
                                            <input type="checkbox" {{ (@old('activo')) ? 'checked' : '' }} id="activo" name="activo" value="1" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="outline-success" data-size="sm"  data-width="100">
                                            @if ($errors->has('activo'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('activo') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>{{ __('Cargo') }} </label>
                                        <input autocomplete="off" type="text" id="cargo" name="cargo" class="form-control @error('cargo') is-invalid @enderror cargo" value="{{ @old('cargo') }}">
                                        @if ($errors->has('cargo'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('cargo') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Fono Fijo') }}</label>
                                        <input autocomplete="off" type="number" id="telefono" name="telefono" class="form-control @error('telefono') is-invalid @enderror telefono" value="{{ @old('telefono') }}">
                                        @if ($errors->has('telefono'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('telefono') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Celular') }} </label>
                                        <input autocomplete="off" type="number" id="celular" name="celular" class="form-control @error('celular') is-invalid @enderror celular" value="{{ @old('celular') }}">
                                        @if ($errors->has('celular'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('celular') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Correo') }} </label>
                                        <input autocomplete="off" type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror email" value="{{ @old('email') }}">
                                        @if ($errors->has('email'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Correo') }} </label>
                                        <input autocomplete="off" type="email" id="email_confirmation" name="email_confirmation" class="form-control @error('email_confirmation') is-invalid @enderror email_confirmation" value="{{ @old('email_confirmation') }}">
                                        @if ($errors->has('email_confirmation'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('email_confirmation') }}</strong>
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