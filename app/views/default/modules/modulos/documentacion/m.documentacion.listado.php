<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/documentacion.class.php");
require_once($_SITE_PATH . "/app/model/usuarios.class.php");

$oDocumentacion = new documentacion(true, $_POST);
$sesion = $_SESSION[$oDocumentacion->NombreSesion];
$lstDocumentacion = $oDocumentacion->Listado();

$oUsuarios = new Usuarios();
$oUsuarios->id = $sesion->id;
$oUsuarios->Informacion();

$aPermisos = empty($oUsuarios->perfiles_id) ? array() : explode("@", $oUsuarios->perfiles_id);
?>
<script type="text/javascript">
    $(document).ready(function(e) {
        $("#dataTable").DataTable();

        $("#btnAgregar").button().click(function(e) {
            Editar("", "Agregar");
        });

        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3" style="text-align:left">
        <h5 class="m-0 font-weight-bold text-primary">Documentacion</h5>
        <div class="form-group" style="text-align:right">
            <input type="button" id="btnAgregar" class="btn btn-outline-primary" name="btnAgregar" value="Agregar Nuevo" />
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Fecha de Creación</th>
                        <th>Fecha de revisión o Actualización</th>
                        <th>Estatus del Documento</th>
                        <th>Proceso</th>
                        <th>Tipo de Documento</th>
                        <th>Area/ Departamento</th>
                        <th>Clave de Calidad</th>
                        <th>Nombre</th>
                        <th style="width:20%">Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <th>Fecha de Creación</th>
                    <th>Fecha de revisión o Actualización</th>
                    <th>Estatus del Documento</th>
                    <th>Proceso</th>
                    <th>Tipo de Documento</th>
                    <th>Area/ Departamento</th>
                    <th>Clave de Calidad</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tfoot>
                <tbody>
                <?php
                    if (count($lstDocumentacion) > 0) {
                        foreach ($lstDocumentacion as $idx => $campo) {
                    ?>
                            <tr>
                                <td style="text-align: center;"><?= $campo->fecha_creacion; ?></td>
                                <td style="text-align: center;"><?= $campo->fecha_actualizacion?></td>
                                <td style="text-align: center;"><?= $campo->estatus_nombre?></td>
                                <td style="text-align: center;"><?= $campo->proceso?></td>
                                <td style="text-align: center;"><?= $campo->tipo_documento ?></td>
                                <td style="text-align: center;"><?= $campo->departamento?></td>
                                <td style="text-align: center;text-transform:uppercase;"><?= $campo->clave_calidad ?></td>
                                <td style="text-align: center;"><?= $campo->nombre ?></td>
                                <td style="text-align: center;">
                                <?php if ($oUsuarios->ExistePermiso("ver", $aPermisos) === true){ ?>
                                    <a class="btn btn-outline-sm" style="width:33%" href="javascript:Editar('<?=$campo->url_pdf ?>','Ver')"><img src="app/views/default/img/view.png" data-toggle="tooltip" title="" data-original-title="Ver"> </a>
                                <?php } ?>
                                <?php if ($oUsuarios->ExistePermiso("imprimir", $aPermisos) === true){ ?>
                                    <a class="btn btn-outline-sm" style="width:25%" href="javascript:Editar('<?=$campo->url_pdf ?>','Imprimir')"><img src="app/views/default/img/printer.png" data-toggle="tooltip" title="" data-original-title="Imprimir" style="width: 80%;height: 80%;"> </a>
                                <?php } ?>
                                <?php if ($oUsuarios->ExistePermiso("editar", $aPermisos) === true){ ?>
                                    <a class="btn btn-outline-sm" style="width:33%" href="javascript:Editar('<?= $campo->id ?>','Agregar')"><img src="app/views/default/img/edit_22x22.png" data-toggle="tooltip" title="" data-original-title="Editar"></a>
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