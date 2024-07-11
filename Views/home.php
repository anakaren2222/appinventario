<?php
headerContent($data);
getModal('modalInventario', $data);
?>

<h1 class="p-3 bg-secondary bg-gradient text-center text-white">
    Control de inventario
</h1>

<div class="container px-4 mt-4">
    <div class="card mb-5">
        <div class="card-header d-flex justify-content-between align-items-center">
            <a href="<?=base_url();?>/Parte" class="btn btn-secondary">
                <i class="fas fa-file"></i>
                No. Parte
            </a>
            <div class="d-flex gap-2">
                <button class="btn btn-secondary" id="btnAgregar">
                    <i class="fas fa-add"></i>
                    Agregar
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                <table id="registros" class="table table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No. Parte</th>
                            <th>Linea</th>
                            <th>Ubicación</th>
                            <th>Responsable</th>
                            <th>Cantidad</th>
                            <th>Costo</th>
                            <th>Costo Total</th>
                            <th>Acciones</th>
                            <th>Descripción</th>
                            <th>Fecha de Creación</th>
                            <th>Última actualización</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
footerContent($data);
?>