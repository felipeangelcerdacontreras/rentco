<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/permisos.class.php");
require_once($_SITE_PATH . "/app/model/permisos.class.php");

$oPermisos = new permisos();
$sesion = $_SESSION[$oPermisos->NombreSesion];
$lstpermisos = $oPermisos->Listado();

$oPermisos = new permisos();
$oPermisos->puesto = $sesion->puesto;
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
        <h5 class="m-0 font-weight-bold text-primary">permisos</h5>
        <div class="form-group" style="text-align:right">
            <input type="button" id="btnAgregar" class="btn btn-outline-primary" name="btnAgregar" value="Agregar nuevo" />
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="text-align: center;">Puesto</th>
                        <th style="text-align: center;">Departamento</th>
                        <th style="width: 10%;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($lstpermisos) > 0) {
                        foreach ($lstpermisos as $idx => $campo) {
                    ?>
                            <tr>
                                <td style="text-align: center;"><?= $campo->puesto ?></td>
                                <td style="text-align: center;"><?= $campo->departamento ?></td>
                                <td style="text-align: center;">
                                    <a class="btn btn-outline-sm " href="javascript:Editar('<?= $campo->id ?>','Editar')" placeholder="Editar"><img src="app/views/default/img/edit_22x22.png" data-toggle="tooltip" title="" data-original-title="Editar"></a>
                                    <?php if ($campo->estado == 1) { ?>
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