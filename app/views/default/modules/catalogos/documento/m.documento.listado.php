<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/documento.class.php");
require_once($_SITE_PATH . "/app/model/permisos.class.php");

$oDocumento = new documento();
$sesion = $_SESSION[$oDocumento->NombreSesion];
$lstdocumento = $oDocumento->Listado();

$oPermisos = new permisos();
$oPermisos->id = $sesion->id_permiso;
$oPermisos->permisos();

$aPermisos = empty($oPermisos->perfiles_id) ? array() : explode("@", $oPermisos->perfiles_id);
?>
<script type="text/javascript">
    $(document).ready(function(e) {
        $("#dataTable").DataTable({
            scrollY: '300px',
            dom: 'Bfrtip',
            buttons: [
                <?php if ($oPermisos->ExistePermiso("excel", $aPermisos) === true) {
                    echo  "{
                        extend: 'excel',
                        title: 'Reporte de documentación',
                        text: 'Exportar a Excel',
                        exportOptions: {
                            columns: [0, 1]
                        }
                    },";
                }
                if ($oPermisos->ExistePermiso("pdf", $aPermisos) === true) {
                    echo "{
                            extend: 'pdfHtml5',
                            title: 'Reporte de documentación',
                            text: 'Exportar a pdf',
                            exportOptions: {
                                columns: [0, 1]
                            }
                        }";
                } ?>
            ],
        });

        $(".buttons-excel").addClass("btn btn-outline-success");
        $(".buttons-pdf").addClass("btn btn-outline-danger");

        $("#btnAgregar").button().click(function(e) {
            Editar("", "Agregar");
        });

        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3" style="text-align:left">
        <h5 class="m-0 font-weight-bold text-primary">Documento</h5>
        <div class="form-group" style="text-align:right">
            <input type="button" id="btnAgregar" class="btn btn-outline-primary" name="btnAgregar" value="Agregar nuevo" />
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="text-align: center;">Nombre</th>
                        <th style="text-align: center;">Estatus</th>
                        <th style="width: 10%;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($lstdocumento) > 0) {
                        foreach ($lstdocumento as $idx => $campo) {
                    ?>
                            <tr>
                                <td style="text-align: center;"><?= $campo->nombre ?></td>
                                <td style="text-align: center;"><?php if ($campo->estatus == 0) {
                                                                    echo "INHABILITADO";
                                                                } else if ($campo->estatus == 1) {
                                                                    echo "DISPONIBLE";
                                                                } ?></td>
                                <td style="text-align: center;">
                                    <a class="btn btn-outline-sm " href="javascript:Editar('<?= $campo->id ?>','Editar')"><img src="app/views/default/img/edit_22x22.png" data-toggle="tooltip" title="" data-original-title="Editar"></a>
                                    <?php if ($campo->estatus == 1) { ?>
                                        <a class="btn btn-outline-sm " href="javascript:Editar('<?= $campo->id ?>','Desactivar')"><img src="app/views/default/img/no.png" data-toggle="tooltip" title="" data-original-title="Desactivar"></a>
                                    <?php } else { ?>
                                        <a class="btn btn-outline-sm " href="javascript:Editar('<?= $campo->id ?>','Activar')"><img src="app/views/default/img/yes.png" data-toggle="tooltip" title="" data-original-title="Activar"></a>
                                    <?php } ?>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>