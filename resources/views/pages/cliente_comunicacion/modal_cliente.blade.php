<div class="modal fade" id="modal_cliente" tabindex="-1" role="dialog" aria-labelledby="clienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form class="form-prevent-multiple-submits frm_modal_update" action="" id="frm_cliente_prosp" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input autocomplete="off" type="hidden" id="razon_social" name="razon_social" value="{{ (@old('razon_social')) }}">
                                        <input autocomplete="off" type="hidden" id="activo" name="activo" value="{{ (@old('activo')) }}">
                                        <input autocomplete="off" type="hidden" id="rutaDestino" name="rutaDestino" value="cliente-comunicacion.index">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="card-title mb-1" style="color: #35D32F;">Datos del cliente</h5>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>{{ __('Comercial') }}</label>
                                        <h5 id="comercial">Comercial</h5>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>{{ __('Tipo Cliente') }}</label>
                                        <h5 id="tipo_cliente">Tipo Cliente</h5>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>{{ __('Inicio Relación') }}</label>
                                        <h5 id="inicio_relacion">Inicio Relación</h5>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>{{ __('Estado') }}</label>
                                        <h5 id="estado">Estado</h5>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-group">
                                        <label>{{ __('Cliente') }}</label>
                                        <h5 id="nombre_cliente">Cliente</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-9">
                                    <div class="form-group">
                                        <label>{{ __('Holding') }}</label>
                                        <h5 id="holding">Holding</h5>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>{{ __('Rut') }}</label>
                                        <h5 id="rut">Rut</h5>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>{{ __('Rubro') }}</label>
                                        <h5 id="rubro">Rubro</h5>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>{{ __('Teléfono') }}</label>
                                        <h5 id="telefono">Telefono</h5>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>{{ __('Correo') }}</label>
                                        <h5 id="correo">Correo</h5>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>{{ __('Dirección') }}</label>
                                        <h5 id="direccion">Dirección</h5>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>{{ __('Cantidad Empleados') }}</label>
                                        <input autocomplete="off" type="number" id="cantidadEmpleados" name="cantidad_empleados" class="form-control @error('cantidad_empleados') is-invalid @enderror cantidad_empleados" value="{{ (@old('cantidad_empleados')) }}">
                                        
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
            </div>
        </form>
    </div>
</div>