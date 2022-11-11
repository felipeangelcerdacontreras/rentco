<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/documentacion.class.php");
require_once($_SITE_PATH . "app/model/documentacion_permisos.class.php");
require_once($_SITE_PATH . "/app/model/usuarios.class.php");

$oDocumentacion = new documentacion(true, $_POST);
$sesion = $_SESSION[$oDocumentacion->NombreSesion];
//print_r($sesion);
$lstDocumentacion = $oDocumentacion->Listado();

//print_r($lstDocumentacion);

$oUsuarios = new Usuarios();
$oUsuarios->id = $sesion->id;
$oUsuarios->Informacion();

$oDocPermiso = new documentacion_permisos();
$oDocPermiso->id_documento = addslashes(filter_input(INPUT_POST, "id"));
$lstPermisos = $oDocPermiso->Listado();

$aPermisos = empty($oUsuarios->perfiles_id) ? array() : explode("@", $oUsuarios->perfiles_id);
?>
<script type="text/javascript">
    $(document).ready(function(e) {
        $("#dataTable").DataTable({
            scrollY: '350px'
        });

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
            <?php if ($oUsuarios->ExistePermiso("agregar", $aPermisos) === true) {  ?>
                <input type="button" id="btnAgregar" class="btn btn-outline-primary" name="btnAgregar" value="Agregar Nuevo" />
            <?php } ?>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="text-align: center;">Fecha de Creación</th>
                        <th style="text-align: center;">Fecha de revisión o Actualización</th>
                        <th style="text-align: center;">Estatus del Documento</th>
                        <th style="text-align: center;">Proceso</th>
                        <th style="text-align: center;">Tipo de Documento</th>
                        <th style="text-align: center;">Area/ Departamento</th>
                        <th style="text-align: center;">Clave de Calidad</th>
                        <th style="text-align: center;">Nombre</th>
                        <th style="width:20%">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($lstDocumentacion) > 0) {
                        foreach ($lstDocumentacion as $idx => $campo) {
                            if ($sesion->nvl_usuario > 1) {
                                foreach ($lstPermisos as $idx => $permiso) {
                                    if ($permiso->id_puesto == $sesion->puesto && $permiso->id_documento == $campo->id) {

                    ?>
                                        <tr>
                                            <td style="text-align: center;"><?= $campo->fecha_creacion; ?></td>
                                            <td style="text-align: center;"><?= $campo->fecha_actualizacion ?></td>
                                            <td style="text-align: center;"><?= $campo->estatus_nombre ?></td>
                                            <td style="text-align: center;"><?= $campo->proceso ?></td>
                                            <td style="text-align: center;"><?= $campo->tipo_documento ?></td>
                                            <td style="text-align: center;"><?= $campo->departamento ?></td>
                                            <td style="text-align: center;text-transform:uppercase;"><?= $campo->clave_calidad ?></td>
                                            <td style="text-align: center;"><?= $campo->nombre ?></td>
                                            <td style="text-align: center;">
                                                <?php if ($permiso->ver == "ver") { ?>
                                                    <a class="btn btn-outline-sm" style="width:33%" href="javascript:Editar('<?= $campo->url_pdf ?>','Ver')"><img src="app/views/default/img/view.png" data-toggle="tooltip" title="" data-original-title="Ver"> </a>
                                                <?php } ?>
                                                <?php if ($permiso->editar == "editar") { ?>
                                                    <a class="btn btn-outline-sm" style="width:25%" href="javascript:Editar('<?= $campo->url_pdf ?>','Imprimir')"><img src="app/views/default/img/printer.png" data-toggle="tooltip" title="" data-original-title="Imprimir" style="width: 80%;height: 80%;"> </a>
                                                <?php } ?>
                                                <?php if ($permiso->imprimir == "imprimir") { ?>
                                                    <a class="btn btn-outline-sm" style="width:33%" href="javascript:Editar('<?= $campo->id ?>','Agregar')"><img src="app/views/default/img/edit_22x22.png" data-toggle="tooltip" title="" data-original-title="Editar"></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                            } else {
                                ?>
                                <tr>
                                    <td style="text-align: center;"><?= $campo->fecha_creacion; ?></td>
                                    <td style="text-align: center;"><?= $campo->fecha_actualizacion ?></td>
                                    <td style="text-align: center;"><?= $campo->estatus_nombre ?></td>
                                    <td style="text-align: center;"><?= $campo->proceso ?></td>
                                    <td style="text-align: center;"><?= $campo->tipo_documento ?></td>
                                    <td style="text-align: center;"><?= $campo->departamento ?></td>
                                    <td style="text-align: center;text-transform:uppercase;"><?= $campo->clave_calidad ?></td>
                                    <td style="text-align: center;"><?= $campo->nombre ?></td>
                                    <td style="text-align: center;">
                                        <?php if ($oUsuarios->ExistePermiso("ver", $aPermisos) === true) { ?>
                                            <a class="btn btn-outline-sm" style="width:33%" href="javascript:Editar('<?= $campo->url_pdf ?>','Ver')"><img src="app/views/default/img/view.png" data-toggle="tooltip" title="" data-original-title="Ver"> </a>
                                        <?php } ?>
                                        <?php if ($oUsuarios->ExistePermiso("imprimir", $aPermisos) === true) { ?>
                                            <a class="btn btn-outline-sm" style="width:25%" href="javascript:Editar('<?= $campo->url_pdf ?>','Imprimir')"><img src="app/views/default/img/printer.png" data-toggle="tooltip" title="" data-original-title="Imprimir" style="width: 80%;height: 80%;"> </a>
                                        <?php } ?>
                                        <?php if ($oUsuarios->ExistePermiso("editar", $aPermisos) === true) { ?>
                                            <a class="btn btn-outline-sm" style="width:33%" href="javascript:Editar('<?= $campo->id ?>','Agregar')"><img src="app/views/default/img/edit_22x22.png" data-toggle="tooltip" title="" data-original-title="Editar"></a>
                                        <?php } ?>

                                        <?php if ($oUsuarios->ExistePermiso("actualizar", $aPermisos) === true) { ?>
                                            <a class="btn btn-outline-sm" style="width:33%" href="javascript:Editar('<?= $campo->id ?>','Actualizar')"><img src="app/views/default/img/actualizar.png" data-toggle="tooltip" title="" data-original-title="Actualizar"></a>
                                        <?php } ?>
                                    </td>
                                </tr>
                    <?php
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>