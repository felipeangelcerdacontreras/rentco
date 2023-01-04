<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
*/
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/permisos.class.php");

$accion = addslashes(filter_input(INPUT_POST, "accion"));


if ($accion == "GUARDAR") {
    $oPermisos = new permisos(true, $_POST);
    if ($oPermisos->Guardar() === true) {
        echo "Sistema@Se ha registrado exitosamente la información del usuario. @success";
    } else {
        echo "Sistema@Ha ocurrido un error al guardar la información del usuario, vuelva a intentarlo o consulte con el administrador del sistema.@warning";
    }
} else if ($accion == "Desactivar"){
    $oPermisos = new permisos(true, $_POST);
    //print_r($oPermisos);
    if ($oPermisos->Desactivar() === true) {
        echo "Sistema@Se ha registrado exitosamente la información del usuario. @success";
    } else {
        echo "Sistema@Ha ocurrido un error al guardar la información del usuario, vuelva a intentarlo o consulte con el administrador del sistema.@warning";
    }
}
?>
