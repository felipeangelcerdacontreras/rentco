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
                    <strong class="">Nombre de usuario:</strong>
                    <div class="form-group">
                        <input type="text" description="Ingrese el nombre" aria-describedby="" id="nombre_usuario" required name="nombre_usuario" value="<?= $oUsuarios->nombre_usuario ?>" class="form-control obligado" />
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <strong class="">Contraseña:</strong>
                    <div class="form-group">
                        <input type="text" description="Ingrese la contraseña" aria-describedby="" id="clave_usuario" required name="clave_usuario" value="<?= $oUsuarios->clave_texto ?>" class="form-control" />
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

        <input type="hidden" id="id" name="id" value="<?= $oUsuarios->id ?>" />
        <input type="hidden" id="user_id" name="user_id" value="<?= $sesion->id ?>">
        <input type="hidden" id="accion" name="accion" value="GUARDAR" />
    </div>
</form>