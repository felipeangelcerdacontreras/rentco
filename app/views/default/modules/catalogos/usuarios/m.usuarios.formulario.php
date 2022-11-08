<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/usuarios.class.php");
require_once($_SITE_PATH . "/app/model/puestos.class.php");

$oUsuarios = new Usuarios();
$oUsuarios->id = addslashes(filter_input(INPUT_POST, "id"));
$nombre = addslashes(filter_input(INPUT_POST, "nombre"));
$sesion = $_SESSION[$oUsuarios->NombreSesion];
$oUsuarios->Informacion();

$oPuestos = new puestos();
$oPuestos->form = '1';
$lstpuestos = $oPuestos->Listado();

$aPermisos = empty($oUsuarios->perfiles_id) ? array() : explode("@", $oUsuarios->perfiles_id);
?>
<script type="text/javascript">
    $(document).ready(function(e) {
        $("#nameModal").text("<?php echo $nombre ?> Usuario");
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
<form id="frmFormulario" name="frmFormulario" action="app/views/default/modules/catalogos/usuarios/m.usuarios.procesa.php" enctype="multipart/form-data" method="post" target="_self" class="form-horizontal">
    <div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <strong class="">Nombre:</strong>
                    <div class="form-group">
                        <input type="text" description="Ingrese el nombre" aria-describedby="" id="nombre_usuario" required name="nombre_usuario" value="<?= $oUsuarios->nombre_usuario ?>" class="form-control obligado" />
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <strong class="">Usuario:</strong>
                    <div class="form-group">
                        <input type="text" description="Ingrese el usuario" aria-describedby="" id="usuario" required name="usuario" value="<?= $oUsuarios->usuario ?>" class="form-control obligado" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <strong class="">Correo:</strong>
                    <div class="form-group">
                        <input type="text" description="Ingrese el correo" aria-describedby="" id="correo" required name="correo" value="<?= $oUsuarios->correo ?>" class="form-control obligado" />
                    </div>
                </div>
            </div>
            <div class="col">
            <div class="form-group">
            <strong class="">Puesto:</strong>
            <div class="form-group">
                <select id="puesto" description="Seleccione el puesto" class="form-control obligado" name="puesto">
                    <?php
                    if (count($lstpuestos) > 0) {
                        echo "<option value='0' >-- SELECCIONE --</option>\n";
                        foreach ($lstpuestos as $idx => $campo) {
                            if ($campo->id == $oUsuarios->puesto) {
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
            <strong class="">Permisos </strong>
            <div class="row">
                <div class="col">
                    <strong class="">Modulos: </strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="documentacion" <?php if ($oUsuarios->ExistePermiso("documentacion", $aPermisos) === true) echo "checked" ?>><strong> Documentación</strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="bitacora" <?php if ($oUsuarios->ExistePermiso("bitacora", $aPermisos) === true) echo "checked" ?>><strong> Bitacora</strong><br>
                    
                    <strong class="">Catalogos: </strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="departamentos" <?php if ($oUsuarios->ExistePermiso("departamentos", $aPermisos) === true) echo "checked" ?>><strong> Departamentos</strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="puestos" <?php if ($oUsuarios->ExistePermiso("puestos", $aPermisos) === true) echo "checked" ?>><strong> Puestos</strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="usuarios" <?php if ($oUsuarios->ExistePermiso("usuarios", $aPermisos) === true) echo "checked" ?>><strong> Usuarios</strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="estatus_documento" <?php if ($oUsuarios->ExistePermiso("estatus_documento", $aPermisos) === true) echo "checked" ?>><strong> Estatus Documento</strong><br>        
                    <input type="checkbox" name="perfiles_id[]" value="proceso" <?php if ($oUsuarios->ExistePermiso("proceso", $aPermisos) === true) echo "checked" ?>><strong> Proceso</strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="documento" <?php if ($oUsuarios->ExistePermiso("documento", $aPermisos) === true) echo "checked" ?>><strong> Tipo Documento</strong><br>        
                </div>
                <div class="col">
                    <strong class="">Documentación: </strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="ver" <?php if ($oUsuarios->ExistePermiso("ver", $aPermisos) === true) echo "checked" ?>><strong> Ver</strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="editar" <?php if ($oUsuarios->ExistePermiso("editar", $aPermisos) === true) echo "checked" ?>><strong> Editar</strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="imprimir" <?php if ($oUsuarios->ExistePermiso("imprimir", $aPermisos) === true) echo "checked" ?>><strong> Imprimir</strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="agregar" <?php if ($oUsuarios->ExistePermiso("agregar", $aPermisos) === true) echo "checked" ?>><strong> Agregar</strong><br>
                    
                </div>
            </div>
        </div>
        <div class="form-group">
            <strong>Nivel del usuario</strong>
            <div class="form-group">
                <select id="nvl_usuario" description="Seleccione el nivel del usuario" class="form-control obligado" name="nvl_usuario" >
                    <option value="">--SELECCIONE--</option>
                    <option value="1" 
                        <?php if ($oUsuarios->nvl_usuario == "1") echo "selected";?>>Administrador</option>
                    <option value="2" 
                       <?php if ($oUsuarios->nvl_usuario == "2") echo "selected";?>>Usuario</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <strong class="">Contraseña:</strong>
            <div class="form-group">
                <input type="text" description="Ingrese la contraseña" aria-describedby="" id="clave_usuario" required name="clave_usuario" value="" class="form-control" />
            </div>
        </div>
        <input type="hidden" id="id" name="id" value="<?= $oUsuarios->id ?>" />
        <input type="hidden" id="user_id" name="user_id" value="<?= $sesion->id ?>">
        <input type="hidden" id="accion" name="accion" value="GUARDAR" />
    </div>
</form>