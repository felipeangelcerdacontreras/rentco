<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/principal.class.php");

class pdf_video extends AW {

    var $id_video;
    var $url_video;
    var $estatus_video;
    var $user_id_video;
    var $form;
    var $texto_video;
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
            $sqlForm = "where estatus_video = '1'";
        }

        $sql = "SELECT * FROM pdf_video {$sqlForm} ";
        return $this->Query($sql);
        
    }

    public function Listadopdf_video() {

        $sql = "
        select * from (
        select id_image as id, url_image as content, orden, type_image as type from pdf_video_image where id_main_video = {$this->id_video}
            union all 
        select id_video, texto_video, orden, type_video from pdf_video_video where id_main_video = {$this->id_video}
            union all 
        select id_video, url_video, orden, type_video  from pdf_video_video where id_main_video = {$this->id_video})
         a order by orden asc ";
        return $this->Query($sql);
        
    }

    public function Informacion() {

        $sql = "select * from pdf_video where  id_video='{$this->id_video}'";
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
        $sql = "select id_video from pdf_video where id_video='{$this->id_video}'";
        $res = $this->Query($sql);

        $bExiste = false;

        if (count($res) > 0) {
            $bExiste = true;
        }
        return $bExiste;
    }

    public function Actualizar() {

        $sql = "update
                    pdf_video
                set
                name_video = '{$this->name_video}'
                where
                id_video='{$this->id_video}'";
        return $this->NonQuery($sql);
    }

    public function Desactivar() {

        $sql = "update
                    pdf_video
                set
                estatus = '{$this->estatus}'
                where
                id_video='{$this->id_video}'";
                 // echo nl2br($sql);
        return $this->NonQuery($sql);
    }

    public function Agregar() {

        $sql = "insert into pdf_video
                (`id_video`,`url_video`,`estatus_video`,`id_main_pdf`)
                values
                ('0','{$this->url_video}','1','{$this->id_main_pdf}')";
        $bResultado = $this->NonQuery($sql);
        
        $sql1 = "select id_video from pdf_video order by id_video desc limit 1";
        $res = $this->Query($sql1);
        
        $this->id_video = $res[0]->id_video;

        return $bResultado;
    }

    public function SubirArchivo($archivo,$campo) {

        $bResultado = false;
        $dirFotos = $this->RutaAbsoluta . "PDF/";
        @mkdir($dirFotos);
        $dirFotos .= "VID/";
        @mkdir($dirFotos);

        $archivoDir = "PDF/VID/";

        if ($archivo['error'] == 0) {// si se subió el archivo
            $nomArchivoTemp = explode(".", $archivo['name']);
            $extArchivo = strtoupper(trim(end($nomArchivoTemp)));

            if (!($extArchivo == "MP4" )) {// si no es igual a jpg
                return 2;
            }

            $nomArchivo = $archivo['name'];
            $archivoDir .= $nomArchivo;
            $uploadfile = $dirFotos . basename($nomArchivo);

            if (move_uploaded_file($archivo['tmp_name'],$uploadfile)) {
                
                $sql = "update pdf_video set $campo = '{$archivoDir}' where id_video = '{$this->id_videos}'";
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