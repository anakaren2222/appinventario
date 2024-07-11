<?php
headerContent($data);
getModal('modalPartes', $data);
?>

<h1 class="p-3 bg-secondary bg-gradient text-center text-white">
    No. Partes
</h1>

<div class="container px-4 mt-4">
    <div class="card mb-5">
        <div class="card-header d-flex justify-content-between align-items-center">
            <a href="<?=base_url();?>/Home" class="btn btn-secondary">
                <i class="fas fa-file"></i>
                inventario
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
                <table id="registros_Partes" class="table table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Codigo</th>
                            <th>Costo</th>
                            <th>Status</th>
                            <th>Fecha de Creación</th>
                            <th>Acciones</th>
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