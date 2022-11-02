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
        $this->NombreSesion = "RENOVAMX";
        $this->MasterKey = "angel";
        $this->API_KEY = "AIzaSyDNuQjcMaL880tNTT_rY6X3G6DhiMqSDFw";
        $this->RutaAbsoluta = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
	}
}
/**
 *      $this->mysql_database = "epiz_32114917_mli";
 *       $this->mysql_host = "sql110.epizy.com";
 *      $this->mysql_user = "epiz_32114917";
 *       $this->mysql_pass = "tPpNztsBpjnlV5v";
 */
/**
 *      $this->mysql_database = "renovamx_db_2021_10_12";
 *       $this->mysql_host = "renova-mx.com";
 *      $this->mysql_user = "renovamx_db_user";
 *       $this->mysql_pass = "@DXTLS2021*";
 */
?>
