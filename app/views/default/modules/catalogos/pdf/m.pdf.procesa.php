<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
*/
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/pdf.class.php");
require_once($_SITE_PATH . "/app/model/txt.class.php");
require_once($_SITE_PATH . "/app/model/img.class.php");
require_once($_SITE_PATH . "/app/model/vid.class.php");

$accion = addslashes(filter_input(INPUT_POST, "accion"));


if ($accion == "GUARDAR") {
    $oPdf = new pdf(true, $_POST);
    if ($oPdf->Guardar() === true) {
        echo "Sistema@Se ha registrado exitosamente la información. @success";
    } else {
        echo "Sistema@Ha ocurrido un error al guardar la información , vuelva a intentarlo o consulte con el administrador del sistema.@warning";
    }
} else if ($accion == "txt") {
    $oPdf_text = new pdf_text(true, $_POST);
    if ($oPdf_text->Guardar() === true) {
        echo "Sistema@Se ha registrado exitosamente la información. @success";
    } else {
        echo "Sistema@Ha ocurrido un error al guardar la información , vuelva a intentarlo o consulte con el administrador del sistema.@warning";
    }
} else if ($accion == "img") {
    $oPdf_text = new pdf_image(true, $_POST);
    if ($oPdf_text->Guardar() === true) {
        echo "Sistema@Se ha registrado exitosamente la información. @success";
            if (isset($_FILES["foto"])) {
                $Campo = "url_image";
                if ($oPdf_text->SubirArchivo($_FILES["foto"],$Campo)) {
                    $valfro = 1;
                }else{
                    $valfro = 2;
                }
            }else{
                echo "";
            }
    } else {
        echo "Sistema@Ha ocurrido un error al guardar la información , vuelva a intentarlo o consulte con el administrador del sistema.@warning";
    }
} else if ($accion == "Desactivar"){
    $oPdf = new pdf(true, $_POST);

    if ($oPdf->Desactivar() === true) {
        echo "Sistema@Se ha registrado exitosamente la información. @success";
    } else {
        echo "Sistema@Ha ocurrido un error al guardar la información , vuelva a intentarlo o consulte con el administrador del sistema.@warning";
    }
}
?>
