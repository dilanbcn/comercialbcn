<div class="modal fade" id="modal_asignar" tabindex="-1" role="dialog" aria-labelledby="asignarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form-prevent-multiple-submits" action="" id="frm_inicio_relacion" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="inpt-ruta" name="inpt-ruta" value="{{ @old('inpt-ruta') }}">
                <div class="modal-header">
                    <h5 class="card-title mb-1" style="color: #35D32F;" id="titleModalAsignar">Asignar Clientes</h5>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('Comercial') }} <span class="text-required">*</span></label>

                                        <select class="form-control @error('comercial') is-invalid @enderror" id="sel_comercial" name="comercial" required>
                                            @foreach ($comerciales as $usuario)
                                            <option value="{{ $usuario->id }}">{{ $usuario->name . ' ' . $usuario->last_name }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('comercial'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('comercial') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="alert alert-info" role="alert" id="div_texto_asignacion">
                                    Asignar xx clientes a XXX
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
                    <button type="button" id="btnAsignar" class="btn btn-sm btn-secondary btn-round button-prevent-submit">Asignar</button>
                    <button type="button" class="btn btn-sm btn-danger btn-round" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>