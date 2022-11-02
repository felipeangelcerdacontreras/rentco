<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/principal.class.php");

class pdf_text extends AW {

    var $id_text;
    var $name_text;
    var $estatus_text;
    var $user_id_text;
    var $form;
    var $texto_text;
    var $id_main_pdf;


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
            $sqlForm = "where estatus_text = '1'";
        }

        $sql = "SELECT * FROM pdf_text {$sqlForm} ";
        return $this->Query($sql);
        
    }

    public function Listadopdf_text() {

        $sql = "
        select * from (
        select id_image as id, url_image as content, orden, type_image as type from pdf_text_image where id_main_text = {$this->id_text}
            union all 
        select id_text, texto_text, orden, type_text from pdf_text_text where id_main_text = {$this->id_text}
            union all 
        select id_video, url_video, orden, type_video  from pdf_text_video where id_main_text = {$this->id_text})
         a order by orden asc ";
        return $this->Query($sql);
        
    }

    public function Informacion() {

        $sql = "select * from pdf_text where  id_text='{$this->id_text}'";
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
        $sql = "select id_text from pdf_text where id_text='{$this->id_text}'";
        $res = $this->Query($sql);

        $bExiste = false;

        if (count($res) > 0) {
            $bExiste = true;
        }
        return $bExiste;
    }

    public function Actualizar() {

        $sql = "update
                    pdf_text
                set
                name_text = '{$this->name_text}'
                where
                id_text='{$this->id_text}'";
        return $this->NonQuery($sql);
    }

    public function Desactivar() {

        $sql = "update
                    pdf_text
                set
                estatus = '{$this->estatus}'
                where
                id_text='{$this->id_text}'";
                 // echo nl2br($sql);
        return $this->NonQuery($sql);
    }

    public function Agregar() {

        $sql = "insert into pdf_text
            (`id_text`,`texto_text`, `orden`, `type_text`, `id_main_pdf`)
                values
            ('0','{$this->texto_text}','','TXT','{$this->id_main_pdf}')";
        $bResultado = $this->NonQuery($sql);
        
        $sql1 = "select id_text from pdf_text order by id_text desc limit 1";
        $res = $this->Query($sql1);
        
        $this->id_text = $res[0]->id_text;

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