<div class="modal fade" id="modal_detalle_venta" tabindex="-1" role="dialog" aria-labelledby="modalDetalleVenta" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form-prevent-multiple-submits frm_detalle_venta" action="" id="frm_detalle_venta" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="tipo_venta" id="tipo_venta">
                <div class="modal-header">
                    <h5 class="card-title mb-1" style="color: #35D32F;">Editar Detalle</h5>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row modal_tipoVenta" id="tipoVenta3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Tipo') }}</label>
                                        <h4 class="mt-0" id="inptTipoPrecio"></h4>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Descripción') }} </label>
                                        <h4 class="mt-0" id="inptDescripcionPrecio"></h4>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Precio / Precio Mínimo') }}</label>
                                        <input autocomplete="off" type="text" id="inp_precio_minimo" name="inp_precio_minimo" class="form-control inputNumber">
                                        <span class="invalid-feedback" id="inp_precio_minimo_error" data-mensaje="El precio / precio mínimo es obligatorio" role="alert">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Precio Máximo') }}</label>
                                        <input autocomplete="off" type="text" id="inp_precio_maximo" name="inp_precio_maximo" class="form-control inputNumber">
                                    </div>
                                </div>
                            </div>
                            <div class="row modal_tipoVenta" id="tipoVenta2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Orden') }}</label>
                                        <h4 class="mt-0" id="inptOrden"></h4>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Tipo') }} </label>
                                        <h4 class="mt-0" id="inptTipo"></h4>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Descripción') }} </label>
                                        <h4 class="mt-0" id="inptDescripcion"></h4>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Precio') }}</label>
                                        <input autocomplete="off" type="text" id="inp_precio" name="inp_precio" class="form-control inputNumber">
                                        <span class="invalid-feedback" data-mensaje="El precio es obligatorio" role="alert">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row modal_tipoVenta" id="tipoVenta1">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Desde') }}</label>
                                        <h4 class="mt-0" id="inptDesde"></h4>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Hasta') }} </label>
                                        <h4 class="mt-0" id="inptHasta"></h4>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Valor Implementación') }}</label>
                                        <input autocomplete="off" type="text" id="inp_valor_implementacion" name="inp_valor_implementacion" class="form-control inputNumber">
                                        <span class="invalid-feedback" data-mensaje="El valor implementación es obligatorio" role="alert">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Valor Mantención') }}</label>
                                        <input autocomplete="off" type="text" id="inp_valor_mantencion" name="inp_valor_mantencion" class="form-control inputNumber">
                                        <span class="invalid-feedback" data-mensaje="El valor mantención es obligatorio" role="alert">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnEditarDetalle" class="btn btn-sm btn-secondary btn-round button-prevent-submit">Guardar</button>
                        <button type="button" class="btn btn-sm btn-danger btn-round" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>