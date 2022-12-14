<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/documento.class.php");

$oDocumento = new documento();
$oDocumento->id = addslashes(filter_input(INPUT_POST, "id"));
$nombre = addslashes(filter_input(INPUT_POST, "nombre"));
$sesion = $_SESSION[$oDocumento->NombreSesion];
$oDocumento->Informacion();

?>
<script type="text/javascript">
    $(document).ready(function(e) {
        $("#nameModal").text("<?php echo $nombre ?> Tipo de Documento");
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
<form id="frmFormulario" name="frmFormulario" action="app/views/default/modules/catalogos/documento/m.documento.procesa.php" enctype="multipart/form-data" method="post" target="_self" class="form-horizontal">
    <div>
        <div class="form-group">
            <strong class="">Nombre:</strong>
            <div class="form-group">
                <input type="text" description="Ingrese el nombre" aria-describedby="" id="nombre" required name="nombre" value="<?= $oDocumento->nombre ?>" class="form-control obligado" />
            </div>
        </div>
        <div class="form-group">
            <strong class="">Clave:</strong>
            <div class="form-group">
                <input type="text" description="Ingrese el clave" style="text-transform:uppercase;" aria-describedby="" id="clave" required name="clave" value="<?= $oDocumento->clave ?>" class="form-control obligado" onkeypress="return soloLetras(event)"/>
            </div>
        </div>
        <input type="hidden" id="id" name="id" value="<?= $oDocumento->id ?>" />
        <input type="hidden" id="user_id" name="user_id" value="<?= $sesion->id ?>">
        <input type="hidden" id="accion" name="accion" value="GUARDAR" />
    </div>
</form>