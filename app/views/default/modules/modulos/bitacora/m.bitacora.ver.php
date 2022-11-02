<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/bitacora.class.php");

$obitacora = new bitacora();
$sesion = $_SESSION[$obitacora->NombreSesion];
$obitacora->ValidaNivelUsuario("bitacora");

$obitacora->id = addslashes(filter_input(INPUT_POST, "id"));
$nombre = addslashes(filter_input(INPUT_POST, "nombre"));
$obitacora->Informacion();



$aPermisos = empty($oUsuarios->perfiles_id) ? array() : explode("@", $oUsuarios->perfiles_id);
?>
<script type="text/javascript">

</script>
<?php if ($obitacora->id != "") {?>
<embed src="<?= $obitacora->id ?>" type="application/pdf" width="100%" height="600px" />
<?php } ?>