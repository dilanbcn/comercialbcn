<div class="modal fade" id="asing_prospector" tabindex="-1" role="dialog" aria-labelledby="asignarProspector" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form-prevent-multiple-submits" action="{{ route('prospeccion.asignacion.store') }}" id="frm_asing_prospector" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="inpt-metodo" name="inpt-metodo" value="{{ @old('inpt-metodo') }}">
                <div class="modal-header">
                    <h5 class="card-title mb-1" style="color: #35D32F;">Asignar Prospector</h5>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('Prospector') }}</label>
                                        <select class="form-control @error('prospectorId') is-invalid @enderror" id="prospectorId" name="prospectorId">
                                            <option value="" selected>[Seleccione]</option>
                                            @foreach ($prospectores as $prospector)
                                            <option {{ ( $prospector->id == @old('prospectorId')) ? 'selected' : ''}} value="{{ $prospector->id }}">{{ $prospector->name . ' ' . $prospector->last_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('prospectorId'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('prospectorId') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="table">
                                    <table class="table table-striped" id="tableSelect">
                                        <thead class="text-primary text-center">
                                            <th>Rut</th>
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            <th>Acciones</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-secondary btn-round button-prevent-submit">Asignar</button>
                    <button type="button" class="btn btn-sm btn-danger btn-round" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>