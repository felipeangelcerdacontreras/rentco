<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/principal.class.php");

class pdf_image extends AW {

    var $id_image;
    var $url_image;
    var $estatus_image;
    var $user_id_image;
    var $form;
    var $texto_image;
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
            $sqlForm = "where estatus_image = '1'";
        }

        $sql = "SELECT * FROM pdf_image {$sqlForm} ";
        return $this->Query($sql);
        
    }

    public function Listadopdf_image() {

        $sql = "
        select * from (
        select id_image as id, url_image as content, orden, type_image as type from pdf_image_image where id_main_image = {$this->id_image}
            union all 
        select id_image, texto_image, orden, type_image from pdf_image_image where id_main_image = {$this->id_image}
            union all 
        select id_video, url_video, orden, type_video  from pdf_image_video where id_main_image = {$this->id_image})
         a order by orden asc ";
        return $this->Query($sql);
        
    }

    public function Informacion() {

        $sql = "select * from pdf_image where  id_image='{$this->id_image}'";
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
        $sql = "select id_image from pdf_image where id_image='{$this->id_image}'";
        $res = $this->Query($sql);

        $bExiste = false;

        if (count($res) > 0) {
            $bExiste = true;
        }
        return $bExiste;
    }

    public function Actualizar() {

        $sql = "update
                    pdf_image
                set
                name_image = '{$this->name_image}'
                where
                id_image='{$this->id_image}'";
        return $this->NonQuery($sql);
    }

    public function Desactivar() {

        $sql = "update
                    pdf_image
                set
                estatus = '{$this->estatus}'
                where
                id_image='{$this->id_image}'";
                 // echo nl2br($sql);
        return $this->NonQuery($sql);
    }

    public function Agregar() {

        $sql = "insert into pdf_image
            (`id_image`, `url_image`, `orden`, `type_image`,`id_main_pdf`)
                values
            ('0','{$this->url_image}','0','IMG','{$this->id_main_pdf}')";
        $bResultado = $this->NonQuery($sql);
        
        $sql1 = "select id_image from pdf_image order by id_image desc limit 1";
        $res = $this->Query($sql1);
        
        $this->id_image = $res[0]->id_image;

        return $bResultado;
    }

    public function SubirArchivo($archivo,$campo) {

        $bResultado = false;
        $dirFotos = $this->RutaAbsoluta . "PDF/";
        @mkdir($dirFotos);
        $dirFotos .= "IMG/";
        @mkdir($dirFotos);

        $archivoDir = "PDF/IMG/";

        if ($archivo['error'] == 0) {// si se subió el archivo
            $nomArchivoTemp = explode(".", $archivo['name']);
            $extArchivo = strtoupper(trim(end($nomArchivoTemp)));

            if (!($extArchivo == "JPG" || $extArchivo == "PNG" || $extArchivo == "JPGE")) {// si no es igual a jpg
                return 2;
            }

            $nomArchivo = $archivo['name'];
            $archivoDir .= $nomArchivo;
            $uploadfile = $dirFotos . basename($nomArchivo);

            if (move_uploaded_file($archivo['tmp_name'],$uploadfile)) {
                
                $sql = "update pdf_image set $campo = '{$archivoDir}' where id_image = '{$this->id_image}'";
                $bResultado = parent::NonQuery($sql);
                //echo nl2br(" consulta ".$sql);
            }
        }
        return $bResultado == 1 ? true : false;
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