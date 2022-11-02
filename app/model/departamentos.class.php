<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/principal.class.php");

class departamentos extends AW {

    var $id;
    var $nombre;
    var $clave;
    var $estatus;
    var $user_id;
    var $form;


    public function __construct($sesion = true, $datos = NULL) {
        parent::__construct($sesion);

        if (!($datos == NULL)) {
            if (count($datos) > 0) {
                foreach ($datos as $idx => $valor) {
                    if (gettype($valor) === "array") {
                        $this->{$idx} = $valor;
                    } else {
                        $this->{$idx} = addslashes($valor);
                    }
                }
            }
        }
    }

    public function Listado() {
        $sqlForm="";
        if (! empty($this->form)) {
            $sqlForm = "where estatus = '1'";
        }

        $sql = "SELECT * FROM departamentos {$sqlForm} ";
        return $this->Query($sql);
        
    }

    public function Informacion() {

        $sql = "select * from departamentos where  id='{$this->id}'";
        $res = parent::Query($sql);

        if (!empty($res) && !($res === NULL)) {
            foreach ($res [0] as $idx => $valor) {
                $this->{$idx} = $valor;
            }
        } else {
            $res = NULL;
        }

        return $res;
    }

    public function Existe() {
        $sql = "select id from departamentos where id='{$this->id}'";
        $res = $this->Query($sql);

        $bExiste = false;

        if (count($res) > 0) {
            $bExiste = true;
        }
        return $bExiste;
    }

    public function Actualizar() {

        $sql = "update
                    departamentos
                set
                nombre = '{$this->nombre}',
                clave = '{$this->clave}'
                where
                  id='{$this->id}'";

        $bResultado = $this->NonQuery($sql);

        if ($bResultado) {
            $sqlBitacora = "INSERT INTO `bitacora`
            (`id`,`modulo`,`operacion`,`modificacion`,`url_pdf`,`url_word`,`usuario`,`fecha`)
            VALUES
            ('0','DEPARTAMENTOS','ACTUALIZACION','(Nombre: {$this->nombre}°Clave: {$this->clave})',NULL,NULL,'{$this->user_id}',NOW())";

            $this->NonQuery($sqlBitacora);
        }
        return $bResultado; 
    }

    public function Agregar() {

        $sql = "insert into departamentos
                (`id`,`nombre`,`clave`,`estatus`,`usuario_creacion`)
                values
                ('0','{$this->nombre}','{$this->clave}','1','{$this->user_id}')";
        $bResultado = $this->NonQuery($sql);
        
        if ($bResultado) {
            $sqlBitacora = "INSERT INTO `bitacora`
            (`id`,`modulo`,`operacion`,`modificacion`,`url_pdf`,`url_word`,`usuario`,`fecha`)
            VALUES
            ('0','DEPARTAMENTOS','AGREGADO','(Nombre: {$this->nombre}°Clave: {$this->clave})',NULL,NULL,'{$this->user_id}',NOW())";

            $this->NonQuery($sqlBitacora);
            
            $sql1 = "select id from departamentos order by id desc limit 1";
            $res = $this->Query($sql1);
            
            $this->id = $res[0]->id;
        }

        return $bResultado;
    }

    public function Desactivar() {

        $sql = "update
                    departamentos
                set
                estatus = '{$this->estatus}'
                where
                  id='{$this->id}'";
        return $this->NonQuery($sql);
    }

    public function Guardar() {
        $bRes = false;
        if ($this->Existe() === true) {
            $bRes = $this->Actualizar();
        } else {
            $bRes = $this->Agregar();
        }

        return $bRes;
    }
}