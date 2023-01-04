<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/permisos.class.php");
require_once($_SITE_PATH . "/app/model/puestos.class.php");

$oPermisos = new permisos();
$oPermisos->id = addslashes(filter_input(INPUT_POST, "id"));
$nombre = addslashes(filter_input(INPUT_POST, "nombre"));
$sesion = $_SESSION[$oPermisos->NombreSesion];
$oPermisos->Informacion();

$oPuestos = new puestos();
$oPuestos->form = '1';
$lstpuestos = $oPuestos->Listado();

$aPermisos = empty($oPermisos->perfiles_id) ? array() : explode("@", $oPermisos->perfiles_id);
?>
<script type="text/javascript">
    $(document).ready(function(e) {
        $("#nameModal").text("<?php echo $nombre ?> Permisos");
        $("#frmFormulario").ajaxForm({
            beforeSubmit: function(formData, jqForm, options) {},
            success: function(data) {
                var str = data;
                var datos0 = str.split("@")[0];
                var datos1 = str.split("@")[1];
                var datos2 = str.split("@")[2];
                if ((datos3 = str.split("@")[3]) === undefined) {
                    datos3 = "";
                } else {
                    datos3 = str.split("@")[3];
                }
                Alert(datos0, datos1 + "" + datos3, datos2);
                Listado();
                $("#myModal_1").modal("hide");
            }
        });
    });
</script>
<form id="frmFormulario" name="frmFormulario" action="app/views/default/modules/catalogos/permisos/m.permisos.procesa.php" enctype="multipart/form-data" method="post" target="_self" class="form-horizontal">
    <div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <strong class="">Puesto:</strong>
                    <div class="form-group">
                        <select id="puesto" description="Seleccione el puesto" class="form-control obligado" name="puesto">
                            <?php
                            if (count($lstpuestos) > 0) {
                                echo "<option value='0' >-- SELECCIONE --</option>\n";
                                foreach ($lstpuestos as $idx => $campo) {
                                    if ($campo->id == $oPermisos->puesto) {
                                        echo "<option value='{$campo->id}' selected>{$campo->nombre}</option>\n";
                                    } else {
                                        echo "<option value='{$campo->id}' >{$campo->nombre}</option>\n";
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <h5><strong class="">Permisos: </strong></h5>
            <div class="row">
                <div class="col">
                    <strong class="">Modulos: </strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="documentacion" <?php if ($oPermisos->ExistePermiso("documentacion", $aPermisos) === true) echo "checked" ?>><strong> Documentación</strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="bitacora" <?php if ($oPermisos->ExistePermiso("bitacora", $aPermisos) === true) echo "checked" ?>><strong> Bitacora</strong><br>

                    <strong class="">Catalogos: </strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="departamentos" <?php if ($oPermisos->ExistePermiso("departamentos", $aPermisos) === true) echo "checked" ?>><strong> Departamentos</strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="puestos" <?php if ($oPermisos->ExistePermiso("puestos", $aPermisos) === true) echo "checked" ?>><strong> Puestos</strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="usuarios" <?php if ($oPermisos->ExistePermiso("usuarios", $aPermisos) === true) echo "checked" ?>><strong> Usuarios</strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="permisos" <?php if ($oPermisos->ExistePermiso("permisos", $aPermisos) === true) echo "checked" ?>><strong> Permisos</strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="estatus_documento" <?php if ($oPermisos->ExistePermiso("estatus_documento", $aPermisos) === true) echo "checked" ?>><strong> Estatus Documento</strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="proceso" <?php if ($oPermisos->ExistePermiso("proceso", $aPermisos) === true) echo "checked" ?>><strong> Proceso</strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="documento" <?php if ($oPermisos->ExistePermiso("documento", $aPermisos) === true) echo "checked" ?>><strong> Tipo Documento</strong><br>
                </div>
                <div class="col">
                    <strong class="">Permisos Para Documentación: </strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="ver" <?php if ($oPermisos->ExistePermiso("ver", $aPermisos) === true) echo "checked" ?>><strong> Ver</strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="editar" <?php if ($oPermisos->ExistePermiso("editar", $aPermisos) === true) echo "checked" ?>><strong> Editar</strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="imprimir" <?php if ($oPermisos->ExistePermiso("imprimir", $aPermisos) === true) echo "checked" ?>><strong> Imprimir</strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="agregar" <?php if ($oPermisos->ExistePermiso("agregar", $aPermisos) === true) echo "checked" ?>><strong> Agregar</strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="actualizar" <?php if ($oPermisos->ExistePermiso("actualizar", $aPermisos) === true) echo "checked" ?>><strong> Actualizar</strong><br>
                    <div class="col">
                        <strong class="">Permisos para reportes: </strong><br>
                        <input type="checkbox" name="perfiles_id[]" value="excel" <?php if ($oPermisos->ExistePermiso("excel", $aPermisos) === true) echo "checked" ?>><strong> Excel</strong><br>
                        <input type="checkbox" name="perfiles_id[]" value="pdf" <?php if ($oPermisos->ExistePermiso("pdf", $aPermisos) === true) echo "checked" ?>><strong> Pdf</strong><br>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <strong>Nivel del usuario</strong>
            <div class="form-group">
                <select id="nvl_usuario" description="Seleccione el nivel del usuario" class="form-control obligado" name="nvl_usuario">
                    <option value="">--SELECCIONE--</option>
                    <option value="1" <?php if ($oPermisos->nvl_usuario == "1") echo "selected"; ?>>Administrador</option>
                    <option value="2" <?php if ($oPermisos->nvl_usuario == "2") echo "selected"; ?>>Usuario</option>
                </select>
            </div>
        </div>

        <input type="hidden" id="id" name="id" value="<?= $oPermisos->id ?>" />
        <input type="hidden" id="user_id" name="user_id" value="<?= $sesion->id ?>">
        <input type="hidden" id="accion" name="accion" value="GUARDAR" />
    </div>
</form>