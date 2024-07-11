<!-- Modal para agregar registros -->
<div class="modal fade" id="modalAgregar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Nuevo registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="formRegistros" name="formRegistros">
                    <p class="text-danger">Todos los campos son requeridos</p>

                    <div class="container">
                        <div class="row mb-2">
                            <div class="form-group col-md-12 mb-3">
                                <label for="txtCodigo">Código: </label>
                                <input type="number" class="form-control" id="txtCodigo" name="txtCodigo" required>
                            </div>

                            <div class="form-group col-md-12 mb-3">
                                <label for="txtCosto">Costo: </label>
                                <input type="text" class="form-control" id="txtCosto" name="txtCosto" required>
                            </div>

                            <div class="form-group col-md-12 mb-3">
                                <label for="intStatus">Status: </label>
                                <select type="text" class="form-control" id="intStatus" name="intStatus">
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary">
                            <i class="fas fa-add"></i>
                            Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para actualizar registros -->
<div class="modal fade" id="modalUpdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Actualizar registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="formRegistrosUpdate" name="formRegistrosUpdate">
                    <p class="text-danger">Todos los campos son requeridos</p>
                    <input type="hidden" name="idParte" id="idParte">

                    <div class="container">
                        <div class="row mb-2">
                            <div class="form-group col-md-12 mb-3">
                                <label for="txtCodigoUpdate">Código: </label>
                                <input type="number" class="form-control" id="txtCodigoUpdate" name="txtCodigoUpdate" required>
                            </div>

                            <div class="form-group col-md-12 mb-3">
                                <label for="txtCostoUpdate">Costo: </label>
                                <input type="text" class="form-control" id="txtCostoUpdate" name="txtCostoUpdate" required>
                            </div>

                            <div class="form-group col-md-12 mb-3">
                                <label for="intStatusUpdate">Status: </label>
                                <select type="text" class="form-control" id="intStatusUpdate" name="intStatusUpdate">
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary">
                            <i class="fas fa-add"></i>
                            Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>