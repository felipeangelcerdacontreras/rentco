<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/bitacora.class.php");
require_once($_SITE_PATH . "/app/model/usuarios.class.php");

$obitacora = new bitacora(true, $_POST);
$sesion = $_SESSION[$obitacora->NombreSesion];
$lstbitacora = $obitacora->Listado();

$oUsuarios = new Usuarios();
$oUsuarios->id = $sesion->id;
$oUsuarios->Informacion();

$aPermisos = empty($oUsuarios->perfiles_id) ? array() : explode("@", $oUsuarios->perfiles_id);
?>
<script type="text/javascript">
    $(document).ready(function(e) {
        $("#dataTable").DataTable({
            scrollY: '300px'
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
        <h5 class="m-0 font-weight-bold text-primary">bitacora</h5>
        <div class="form-group" style="text-align:right">
            <input type="button" id="btnAgregar" class="btn btn-outline-primary" name="btnAgregar" value="Agregar Nuevo" />
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Modulo</th>
                        <th>Operacion</th>
                        <th>Modificacion</th>
                        <th>PDF</th>
                        <th>WORD</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tfoot>
                    <th>Modulo</th>
                    <th>Operacion</th>
                    <th style="width: 30%;">Modificacion</th>
                    <th>PDF</th>
                    <th>WORD</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                </tfoot>
                <tbody>
                    <?php
                    if (count($lstbitacora) > 0) {
                        foreach ($lstbitacora as $idx => $campo) {
                    ?>
                            <tr>
                                <td style="text-align: center;"><?= $campo->modulo; ?></td>
                                <td style="text-align: center;"><?= $campo->operacion ?></td>
                                <td style="text-align: center;"><?php
                                                                $parentecis = array("(", ")");
                                                                $remove = str_replace($parentecis, "", $campo->modificacion);
                                                                $cambios = explode("°", $remove);
                                                                //print_r($cambios);
                                                                for ($i = 0; $i < count($cambios); $i++) {
                                                                    if (strpos($cambios[$i], '@') !== false && substr_count($cambios[$i], '@') > 1) { ?>
                                            <div style="float: left;">
                                                <label name="" style="border: 1px solid #0e0e0e;">
                                                    <?php echo "Permisos:" . "<br />";
                                                                        $permisos = explode("@", $cambios[$i]);
                                                                        for ($x = 0; $x < count($permisos); $x++) { ?>
                                                        <strong><?php
                                                                            echo " ".nl2br($permisos[$x] . "<br />");
                                                                ?>
                                                        </strong>
                                                    <?php
                                                                        }
                                                    ?>
                                                </label>
                                            </div>
                                        <?php
                                                                    } else { ?>
                                            <div style="float: right;">
                                                <label name="" style="border: 1px solid #0e0e0e; float: right;"><?php
                                                                                                                echo " ".$cambios[$i] . '<br />';
                                                                                                                ?>
                                                </label>
                                            </div>
                                    <?php
                                                                    }
                                                                }
                                    ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php if ($campo->url_pdf != "") {
                                        if ($oUsuarios->ExistePermiso("ver", $aPermisos) === true) { ?>
                                            <a class="btn btn-outline-sm" style="width:33%" href="javascript:Editar('<?= $campo->url_pdf ?>','Ver')"><img src="app/views/default/img/view.png" data-toggle="tooltip" title="" data-original-title="Ver"> </a>
                                    <?php }
                                    } ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php if ($campo->url_word != "") {
                                        if ($oUsuarios->ExistePermiso("ver", $aPermisos) === true) { ?>
                                            <a class="btn btn-outline-sm" style="width:33%" href="javascript:Editar('<?= $campo->url_word ?>','Ver')"><img src="app/views/default/img/word.png" data-toggle="tooltip" title="" data-original-title="Descargar"> </a>
                                    <?php }
                                    } ?>
                                </td>
                                <td style="text-align: center;"><?= $campo->usuario ?></td>
                                <td style="text-align: center;text-transform:uppercase;"><?= $campo->fecha ?></td>
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