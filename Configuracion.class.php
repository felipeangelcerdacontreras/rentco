<?php

/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 *  */
class Configuracion {
	protected $mysql_host;
	protected $mysql_user;
	protected $mysql_pass;
	protected $mysql_database;
    public $NombreSesion;
    protected $MasterKey;
    protected $RutaAbsoluta;

	public function __construct() {
        $this->mysql_database = "mli";
        $this->mysql_host = "localhost";
        $this->mysql_user = "root";
        $this->mysql_pass = "";
        $this->NombreSesion = "RENTCO";
        $this->MasterKey = "angel";
        $this->API_KEY = "AIzaSyDNuQjcMaL880tNTT_rY6X3G6DhiMqSDFw";
        $this->RutaAbsoluta = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
	}
}

?>
