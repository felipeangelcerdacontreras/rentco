<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/principal.class.php");

class pdf extends AW {

    var $id_pdf;
    var $name_pdf;
    var $estatus_pdf;
    var $user_id_pdf;
    var $form;
    var $texto_text;


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

        $sql = "SELECT * FROM pdf ";
        return $this->Query($sql);
        
    }

    public function ListadoPdf() {

        $sql = "
        select * from (
        select id_image as id, url_image as content, orden, type_image as type from pdf_image where id_main_pdf = {$this->id_pdf}
            union all 
        select id_text, texto_text, orden, type_text from pdf_text where id_main_pdf = {$this->id_pdf}
            union all 
        select id_video, url_video, orden, type_video  from pdf_video where id_main_pdf = {$this->id_pdf})
         a order by orden asc ";
        return $this->Query($sql);
        
    }

    public function Informacion() {

        $sql = "select * from pdf where  id_pdf='{$this->id_pdf}'";
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
        $sql = "select id_pdf from pdf where id_pdf='{$this->id_pdf}'";
        $res = $this->Query($sql);

        $bExiste = false;

        if (count($res) > 0) {
            $bExiste = true;
        }
        return $bExiste;
    }

    public function Actualizar() {

        $sql = "update
                    pdf
                set
                name_pdf = '{$this->name_pdf}'
                where
                id_pdf='{$this->id_pdf}'";
        return $this->NonQuery($sql);
    }

    public function Desactivar() {

        $sql = "update
                    pdf
                set
                estatus = '{$this->estatus}'
                where
                id_pdf='{$this->id_pdf}'";
                 // echo nl2br($sql);
        return $this->NonQuery($sql);
    }

    public function Agregar() {

        $sql = "insert into pdf
                (`id_pdf`,`name_pdf`,`estatus_pdf`,`usuario_creacion_pdf`)
                values
                ('0','{$this->name_pdf}','1','{$this->user_id_pdf}')";
        $bResultado = $this->NonQuery($sql);
        
        $sql1 = "select id_pdf from pdf order by id_pdf desc limit 1";
        $res = $this->Query($sql1);
        
        $this->id_pdf = $res[0]->id_pdf;

        return $bResultado;
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