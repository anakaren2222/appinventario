<!-- Modal para agregar registros -->
<div class="modal fade" id="modalAgregar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
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
                            <div class="form-group col-md-4">
                                <label for="txtCantidad">Cantidad: </label>
                                <input type="number" class="form-control" id="txtCantidad" name="txtCantidad" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="txtParte">No. Parte: </label>
                                <select type="number" class="form-control" id="txtParte" name="txtParte" required>
                                    <!--Opciones cargadas desde ajax-->
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="txtCosto">Costo: </label>
                                <input type="hidden" id="txtCostoHidden" name="txtCosto" value="">
                                <input type="text" class="form-control" id="txtCosto"  readonly>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="form-group col-md-6">
                                <label for="txtUbicacion">Ubicación: </label>
                                <input type="text" class="form-control" id="txtUbicacion" name="txtUbicacion" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="txtLinea">Linea: </label>
                                <input type="text" class="form-control" id="txtLinea" name="txtLinea" required>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="txtResponsable">Reponsable: </label>
                                <input type="text" class="form-control" id="txtResponsable" name="txtResponsable" required>
                            </div>


                            <div class="form-group col-md-6">
                                <label for="txtDescripcion">Descripción: </label>
                                <input type="text" class="form-control" id="txtDescripcion" name="txtDescripcion" required>
                            </div>
                        </div>

                        <div class="row">

                            <div class="form-group col-md-6">
                                <label for="txtCostoTotal">Costo Total: </label>
                                <input type="hidden" id="txtCostoTotalHidden" name="txtCostoTotal" value="">
                                <input type="text" class="form-control" id="txtCostoTotal" readonly>
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

<!--Modal para ver la informacion del registro-->
<div class="modal fade" id="modalView" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: #5F5F5F; color:#fff">
                <h5 class="modal-title"> Información del registro </h5>
                <button type="button" class="btn-close btn-dark " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>No. Parte: </td>
                            <td id="cellParte"></td>
                        </tr>
                        <tr>
                            <td>Linea: </td>
                            <td id="cellLinea"></td>
                        </tr>
                        <tr>
                            <td>Ubicación: </td>
                            <td id="cellUbicacion"></td>
                        </tr>
                        <tr>
                            <td>Descripción: </td>
                            <td id="cellDescripcion"></td>
                        </tr>
                        <tr>
                            <td>Responsable: </td>
                            <td id="cellResponsable"></td>
                        </tr>
                        <tr>
                            <td>Cantidad: </td>
                            <td id="cellCantidad"></td>
                        </tr>
                        <tr>
                            <td>Fecha de creación: </td>
                            <td id="cellCreacion"></td>
                        </tr>
                        <tr>
                            <td>Ultima actualización: </td>
                            <td id="cellActualizacion"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">
                    <i class="fas fa-fw fa-times-circle"></i>
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar la informacion de los registros -->
<div class="modal fade" id="modalEditar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Editar información del registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="formRegistrosUpdate" name="formRegistrosUpdate">
                    <p class="text-danger">Todos los campos son requeridos</p>
                    <input type="hidden" name="idInventario" id="idInventario">

                    <div class="container">
                        <div class="row mb-2">
                            <div class="form-group col-md-4">
                                <label for="txtCantidad">Cantidad: </label>
                                <input type="number" class="form-control" id="txtCantidadUpdate" name="txtCantidadUpdate" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="txtParte">No. Parte: </label>
                                <select type="number" class="form-control" id="txtParteUpdate" name="txtParteUpdate" required>
                                    <!--Datos cargados a traves de ajax-->
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="txtCostoUpdate">Costo: </label>
                                <input type="hidden" id="txtCostoHiddenUpdate" name="txtCostoUpdate" value="">
                                <input type="text" class="form-control" id="txtCostoUpdate" name="txtCostoUpdate" disabled>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="form-group col-md-6">
                                <label for="txtUbicacion">Ubicación: </label>
                                <input type="text" class="form-control" id="txtUbicacionUpdate" name="txtUbicacionUpdate" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="txtLinea">Linea: </label>
                                <input type="text" class="form-control" id="txtLineaUpdate" name="txtLineaUpdate" required>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="txtResponsable">Reponsable: </label>
                                <input type="text" class="form-control" id="txtResponsableUpdate" name="txtResponsableUpdate" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="txtDescripcion">Descripción: </label>
                                <input type="text" class="form-control" id="txtDescripcionUpdate" name="txtDescripcionUpdate" required>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="txtCostoTotalUpdate">Costo Total: </label>
                                <input type="hidden" id="txtCostoTotalHiddenUpdate" name="txtCostoTotalUpdate" value="">
                                <input type="text" class="form-control" id="txtCostoTotalUpdate" name="txtCostoTotalUpdate" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary">
                            <i class="fas fa-edit"></i>
                            Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>