<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/pdf.class.php");

$oPdf = new pdf();
$lstpdf = $oPdf->Listado();
?>
<script type="text/javascript">
    $(document).ready(function(e) {
        $("#dataTable").DataTable();

        $("#btnAgregar").button().click(function(e) {
            Editar("", "Agregar");
        });
        $("#btnAgregar-txt").button().click(function(e) {
            Editar("", "Agregar texto", "txt");
        });
        $("#btnAgregar-img").button().click(function(e) {
            Editar("", "Agregar imagen","img");
        });
        $("#btnAgregar-vid").button().click(function(e) {
            Editar("", "Agregar video","vid");
        });

    });
</script>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3" style="text-align:left">
        <h5 class="m-0 font-weight-bold text-primary">pdf</h5>
        <div class="form-group" style="text-align:right">
            <input type="button" id="btnAgregar" class="btn btn-outline-primary" name="btnAgregar" value="Agregar PDF" />
            <input type="button" id="btnAgregar-txt" class="btn btn-outline-primary" name="btnAgregar-txt" value="Agregar Texto" />
            <input type="button" id="btnAgregar-img" class="btn btn-outline-primary" name="btnAgregar-img" value="Agregar Imagen" />
            <input type="button" id="btnAgregar-vid" class="btn btn-outline-primary" name="btnAgregar-vid" value="Agregar Video" />
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <th>Nombre</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tfoot>
                <tbody>
                    <?php
                    if (count($lstpdf) > 0) {
                        foreach ($lstpdf as $idx => $campo) {
                    ?>
                            <tr>
                                <td style="text-align: center;"><?= $campo->name_pdf ?></td>
                                <td style="text-align: center;"><?php if ($campo->estatus_pdf == 0) {
                                                                    echo "INHABILITADO";
                                                                } else if ($campo->estatus_pdf == 1) {
                                                                    echo "DISPONIBLE";
                                                                } ?></td>
                                <td style="text-align: center;">
                                    <a class="btn btn-outline-sm btn-warning" href="javascript:Editar('<?= $campo->id_pdf ?>','Editar')">Editar</a>
                                    <a class="btn btn-outline-sm btn-success" href="javascript:Editar('<?= $campo->id_pdf ?>','Cargar')">Ordenar</a>
                                    <?php if ($campo->estatus_pdf == 1) { ?>
                                        <a class="btn btn-outline-sm btn-secondary" href="javascript:Editar('<?= $campo->id_pdf ?>','Desactivar')">Desactivar</a>
                                    <?php } else { ?>
                                        <a class="btn btn-outline-sm btn-success" href="javascript:Editar('<?= $campo->id_pdf ?>','Activar')">Activar</a>
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