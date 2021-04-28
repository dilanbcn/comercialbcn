<div class="modal fade" id="modal_notificacion" tabindex="-1" role="dialog" aria-labelledby="asignarProspector" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <form class="form-prevent-multiple-submits" action="{{ route('notificacion.store') }}" id="frm_modal_notificacion" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="inpt-metodo" name="inpt-metodo" value="{{ @old('inpt-metodo') }}">
                <div class="modal-header">
                    <h5 class="card-title mb-1" style="color: #35D32F;">Nueva Notificación</h5>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                            <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('Para') }} <span class="text-required">*</span></label>
                                        <select class="form-control @error('destino') is-invalid @enderror destino selectpicker show-tick" title="[Seleccione]" multiple data-style="btn-light"  data-live-search="false" id="destino" name="destino[]" required>
                                            @foreach ($usuarios as $usuario)
                                            <option {{  (@old('destino')) ? (in_array($usuario->id, @old('destino'))) ? 'selected' : '' : '' }} value="{{ $usuario->id }}">{{ $usuario->name . ' ' . $usuario->last_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('desstino'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('desstino') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>{{ __('Cliente') }} <span class="text-required">*</span></label>
                                        <select class="form-control @error('cliente') is-invalid @enderror cliente" data-style="btn-light"  data-live-search="true" id="cliente" name="cliente" required>
                                            <option value="">[Seleccione]</option>
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('Contenido') }} <span class="text-required">*</span></label>
                                        <textarea name="mensaje" class="form-control @error('mensaje') is-invalid @enderror mensaje" id="mensaje" rows="5">{{ @old('mensaje') }}</textarea>
                                        @if ($errors->has('mensaje'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('mensaje') }}</strong>
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