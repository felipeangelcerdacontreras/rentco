<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/documentacion.class.php");

$oDocumentacion = new documentacion();
$sesion = $_SESSION[$oDocumentacion->NombreSesion];
//$oDocumentacion->ValidaNivelUsuario("documentacion");

$oDocumentacion->id = addslashes(filter_input(INPUT_POST, "id"));
$nombre = addslashes(filter_input(INPUT_POST, "nombre"));
$oDocumentacion->Informacion();



$aPermisos = empty($oUsuarios->perfiles_id) ? array() : explode("@", $oUsuarios->perfiles_id);
?>
<script type="text/javascript">
    var msg = "¡El botón derecho está desactivado para este sitio !";
        function disableIE() {
            if (document.all) {  return false; }
        }
        function disableNS(e) {
            if (document.layers || (document.getElementById && !document.all)) {
                if (e.which == 2 || e.which == 3) {  return false; }
            }
        }
        if (document.layers) {
            document.captureEvents(Event.MOUSEDOWN); document.onmousedown = disableNS;
        } else {
            document.onmouseup = disableNS; document.oncontextmenu = disableIE;
        }
        document.oncontextmenu = ev =>{
          ev.preventDefault();
          console.log("Prevented to open menu!");
        }
</script>
<?php if ($oDocumentacion->id != "") {?>
<embed src="<?= $oDocumentacion->id ?>" type="application/pdf" width="100%" height="600px" />
<?php } ?>