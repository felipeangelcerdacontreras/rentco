<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
*/
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/controllers/mvc.controller.php");
require_once($_SITE_PATH . "/app/controllers/mvc.controller_default.php");
require_once($_SITE_PATH . "/app/controllers/mvc.controller_administrador.php");


$mvc = new mvc_controller();
$action = addslashes(filter_input(INPUT_GET, "action"));
session_start();
if ($action === "login") {
    $mvc->login();
} else if (strpos($action, "checador") !== false && $action != "ubicacion_checador") {
    $mvc->checador();
} else if (strpos($action, "comedor") !== false && $action != "nomina_comedor") {
    $mvc->comedor();
}  else {
    $mvc->ExisteSesion();

    $mvc_default = new mvc_controller_default();

    if ($action === "bienvenida") {// muestra el modulo de bienvenida
        $mvc_default->bienvenida();
    }else if ($action === "usuarios") {
        $mvc_admin = new mvc_controller_administrador();
        $mvc_admin->usuarios();
    }else if ($action === "permisos") {
        $mvc_admin = new mvc_controller_administrador();
        $mvc_admin->permisos();
    }else if ($action === "pdf") {
        $mvc_default->pdf();
    }else if ($action === "documentacion") {
        $mvc_default->documentacion();
    }else if ($action === "bitacora") {
        $mvc_default->bitacora();
    }else if ($action === "departamentos") {
        $mvc_default->departamentos();
    }else if ($action === "proceso") {
        $mvc_default->proceso();
    }else if ($action === "documento") {
        $mvc_default->documento();
    }else if ($action === "estatus_documento") {
        $mvc_default->estatus_documento();
    }else if ($action === "puestos") {
        $mvc_default->puestos();
    }else if ($action === "cerrar_sesion") {
        $mvc->CerrarSesion();
    }else if ($action === "acceso_denegado") {
        $mvc->acceso_denegado();
    } else {
        $mvc->error_page();
    }
}
