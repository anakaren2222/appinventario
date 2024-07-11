<!--Libreria de alertas-->
<script src="<?= media(); ?>/plugins/sweetalert2.all.min.js"></script>

<!--Libreria de DataTable-->
<script type="text/javascript" src="<?= media(); ?>/js/DataTable/jquery-3.7.1.js"></script>
<script type="text/javascript" src="<?= media(); ?>/js/DataTable/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="<?= media(); ?>/js/DataTable/dataTables.js"></script>
<script type="text/javascript" src="<?= media(); ?>/js/DataTable/dataTables.bootstrap5.js"></script>
<script type="text/javascript" src="<?= media(); ?>/js/DataTable/dataTables.responsive.js"></script>
<script type="text/javascript" src="<?= media(); ?>/js/DataTable/responsive.bootstrap5.js"></script>

<!--Botones de exportacion-->
<script type="text/javascript" src="<?= media(); ?>/js/DataTable/buttons/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?= media(); ?>/js/DataTable/buttons/jszip.min.js"></script>
<script type="text/javascript" src="<?= media(); ?>/js/DataTable/buttons/pdfmake.min.js"></script>
<script type="text/javascript" src="<?= media(); ?>/js/DataTable/buttons/vfs_fonts.js"></script>
<script type="text/javascript" src="<?= media(); ?>/js/DataTable/buttons/buttons.html5.min.js"></script>

<script  src="<?= media(); ?>/js/<?= $data['page_functions_js'] ?>"></script>
<script>
    let Base_URL = "<?php echo Base_URL; ?>"
</script>

</body>
</html>