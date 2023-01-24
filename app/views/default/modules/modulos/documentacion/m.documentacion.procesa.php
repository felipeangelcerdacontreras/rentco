<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
*/
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/documentacion.class.php");

$accion = addslashes(filter_input(INPUT_POST, "accion"));

if ($accion == "GUARDAR") {
    $oDocumentacion = new documentacion(true, $_POST);
    $ArchivoW = "";
    $ArchivoP = "";
    $IdDocumento;

    $departamento = filter_input(INPUT_POST, "id_departamento");
        if ($departamento == "T") {
            $departamento = "TODOS";
        } else {
            $departamento = filter_input(INPUT_POST, "id_departamento");
        }

    if ($oDocumentacion->Guardar() === true) {
        $IdDocumento = $oDocumentacion->id;
        if (isset($_FILES["archivo_word"])) {
            if ($oDocumentacion->SubirArchivoWord($IdDocumento,$_FILES["archivo_word"], $departamento, filter_input(INPUT_POST, "clave_calidad"))) {
                $ArchivoW = " Archivo word Guardado ";
            }
        } else {
            echo "";
        }
        if (isset($_FILES["archivo_pdf"])) {
            if ($oDocumentacion->SubirArchivoPdf($IdDocumento,$_FILES["archivo_pdf"], $departamento, filter_input(INPUT_POST, "clave_calidad"))) {
                $ArchivoP = " Archivo Pdf Guardado ";
            }
        } else {
            echo "";
        }

        echo "Sistema@Se ha registrado exitosamente la información{$ArchivoW} {$ArchivoP}. @success";
    } else {
        echo "Sistema@Ha ocurrido un error al guardar la información , vuelva a intentarlo o consulte con el administrador del sistema.@warning";
    }
} else if ($accion == "CLAVE") {
    $oDocumentacion = new documentacion(true, $_POST);
    $oDocumentacion->clave_calidad = addslashes(filter_input(INPUT_POST, "clave"));
    $resultado = $oDocumentacion->Ultimo();

    if (count($resultado) > 0) {
        echo $resultado[0]->num;
    }
} else if ($accion == "QUITAR") {
    $oDocumentacion = new documentacion(true, $_POST);
    $oDocumentacion->id = addslashes(filter_input(INPUT_POST, "id"));
    $oDocumentacion->campo = addslashes(filter_input(INPUT_POST, "campo"));
    if ($oDocumentacion->Quitar() === true) {
        echo "Sistema@Se ha quitado el documento@success";
    }else{
        echo "Sistema@Ha ocurrido un error al quitar el documento, vuelva a intentarlo o consulte con su administrador del sistema.@error@";
     }
}
 