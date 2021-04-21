<div class="modal fade" id="add_proyecto_cliente" tabindex="-1" role="dialog" aria-labelledby="proyectosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form-prevent-multiple-submits" action="{{ route('proyecto.store', $cliente->id) }}" id="frm_add_proyectos" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="inpt-metodo" name="inpt-metodo" value="{{ @old('inpt-metodo') }}">
                <div class="modal-header">
                    <h5 class="card-title mb-1" style="color: #35D32F;">Agregar Nuevo Ticket</h5>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('Nombre') }} <span class="text-required">*</span></label>
                                        <input autocomplete="off" type="text" name="nombre" data-rutaproyectos="{{ route('proyectos.json') }}" class="form-control @error('nombre') is-invalid @enderror nombre inpt-proynombre" value="{{ @old('nombre') }}" required>
                                        @if ($errors->has('nombre'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('nombre') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Fecha Cierre') }} <span class="text-required">*</span></label>
                                        <input autocomplete="off" type="date" name="fechaCierre" class="form-control @error('fechaCierre') is-invalid @enderror fechaCierre" value="{{ @old('fechaCierre') }}" max="{{ date('Y-m-d') }}" required>
                                        @if ($errors->has('fechaCierre'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('fechaCierre') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Fecha Facturación') }} <span class="text-required">*</span></label>
                                        <input autocomplete="off" type="date" name="fechaFacturacion" class="form-control @error('fechaFacturacion') is-invalid @enderror fechaFacturacion" value="{{ @old('fechaFacturacion') }}" required>
                                        @if ($errors->has('fechaFacturacion'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('fechaFacturacion') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <!--<div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Fecha Pago') }} <span class="text-required">*</span></label>
                                        <input autocomplete="off" type="date" name="fechaPago" class="form-control @error('fechaPago') is-invalid @enderror fechaPago" value="{{ @old('fechaPago') }}" max="{{ date('Y-m-d') }}" required>
                                        @if ($errors->has('fechaPago'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('fechaPago') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Inscripción SENCE') }} <span class="text-required">*</span></label>
                                        <select class="form-control @error('estado') is-invalid @enderror" name="inscripcionSence">
                                            <option value="" selected>[Seleccione]</option>
                                            <option {{ (@old('inscripcionSence') == 'Si') ? 'selected' : '' }} value="Si">Si</option>
                                            <option {{ (@old('inscripcionSence') == 'No') ? 'selected' : '' }} value="No">No</option>
                                        </select>
                                        @if ($errors->has('inscripcionSence'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('inscripcionSence') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Monto Venta') }} <span class="text-required">*</span></label>
                                        <input autocomplete="off" type="text" name="montoVenta" class="form-control @error('montoVenta') is-invalid @enderror inputNumber montoVenta" value="{{ @old('montoVenta') }}" required>
                                        @if ($errors->has('montoVenta'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('montoVenta') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Estado') }} <span class="text-required">*</span></label>
                                        <select class="form-control @error('estado') is-invalid @enderror estado" name="estado">
                                            <option value="" selected>[Seleccione]</option>
                                            @foreach ($estados as $estado)
                                            <option {{ ( $estado->id == @old('estado')) ? 'selected' : '' }} value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('estado'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('estado') }}</strong>
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