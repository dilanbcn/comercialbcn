<div class="modal fade" id="add_prospeccion_contacto" tabindex="-1" role="dialog" aria-labelledby="prospeccionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form-prevent-multiple-submits" action="{{ route('prospeccion.contactos.store') }}" id="frm_add_prospeccion_contacto" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="inpt-metodo" name="inpt-metodo" value="{{ @old('inpt-metodo') }}">
                <div class="modal-header">
                    <h5 class="card-title mb-1" style="color: #35D32F;">Agregar nuevo contacto</h5>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('Cliente') }} <span class="text-required">*</span></label>
                                        <select class="form-control @error('cliente') is-invalid @enderror cliente" name="cliente" required>
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Nombre') }} <span class="text-required">*</span></label>
                                        <input autocomplete="off" type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror nombre" value="{{ @old('nombre') }}" required>
                                        @if ($errors->has('nombre'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('nombre') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Apellido') }}</label>
                                        <input autocomplete="off" type="text" name="apellido" class="form-control @error('apellido') is-invalid @enderror" value="{{ @old('apellido') }}">
                                        @if ($errors->has('apellido'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('apellido') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>{{ __('Cargo') }} </label>
                                        <input autocomplete="off" type="text" name="cargo" class="form-control @error('cargo') is-invalid @enderror" value="{{ @old('cargo') }}">
                                        @if ($errors->has('cargo'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('cargo') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Fono Fijo') }} </label>
                                        <input autocomplete="off" type="number" placeholder="2XXXXXXXX" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ @old('telefono') }}">
                                        @if ($errors->has('telefono'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('telefono') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Celular') }}</label>
                                        <input autocomplete="off" type="text" name="celular" class="form-control @error('celular') is-invalid @enderror" value="{{ @old('celular') }}">
                                        @if ($errors->has('celular'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('celular') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Correo') }}</label>
                                        <input autocomplete="off" type="email" name="email" class="form-control @error('email') is-invalid @enderror bloquear" value="{{ @old('email') }}">
                                        @if ($errors->has('email'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Confirmación Correo') }}</label>
                                        <input autocomplete="off" type="email" name="email_confirmation" class="form-control @error('email') is-invalid @enderror bloquear" value="{{ @old('email_confirmation') }}">
                                        @if ($errors->has('email'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
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