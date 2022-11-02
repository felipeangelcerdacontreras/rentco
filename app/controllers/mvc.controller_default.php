<?php

/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * cerda@redzpot.com
 *  */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/controllers/mvc.controller.php");
require_once($_SITE_PATH . "/app/model/principal.class.php");

class mvc_controller_default extends mvc_controller {

    public function __construct() {
        parent::__construct();
        /*
         * Constructor de la clase
         */
    }
    public function bienvenida() {
        include_once("app/views/default/modules/m.bienvenida.php");
    }
    //catalogos

    public function departamentos () {
        include_once("app/views/default/modules/catalogos/departamentos/m.departamentos.buscar.php");
    }
    public function proceso () {
        include_once("app/views/default/modules/catalogos/proceso/m.proceso.buscar.php");
    }
    public function documento () {
        include_once("app/views/default/modules/catalogos/documento/m.documento.buscar.php");
    }
    public function estatus_documento () {
        include_once("app/views/default/modules/catalogos/estatus_documento/m.estatus_documento.buscar.php");
    }
    public function puestos () {
        include_once("app/views/default/modules/catalogos/puestos/m.puestos.buscar.php");
    }
    public function pdf () {
        include_once("app/views/default/modules/catalogos/pdf/m.pdf.buscar.php");
    }
    //modulos 
    public function documentacion () {
        include_once("app/views/default/modules/modulos/documentacion/m.documentacion.buscar.php");
    }
    public function bitacora () {
        include_once("app/views/default/modules/modulos/bitacora/m.bitacora.buscar.php");
    }
}
?>
