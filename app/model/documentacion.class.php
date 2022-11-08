<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/principal.class.php");

class documentacion extends AW
{

    var $id;
    var $id_estatus;
    var $id_proceso;
    var $id_tipo_documento;
    var $id_departamento;
    var $id_puesto;
    var $clave_calidad;
    var $nombre;
    var $url_word;
    var $url_pdf;
    var $comentarios;
    var $fecha_creacion;
    var $fecha_actualizacion;
    var $user_id;
    var $form;

    public $id_documento;

    public function __construct($sesion = true, $datos = NULL)
    {
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

    public function Listado()
    {
        $sqlForm = "";
        if (!empty($this->form)) {
            $sqlForm = "and estatus = '1'";
        }

        $fecha_creacion = "";
        if (!empty($this->fecha_creacion)) {
            $fecha_creacion = "and a.fecha_creacion = '{$this->fecha_creacion}'";
        }

        $fecha_actualizacion = "";
        if (!empty($this->fecha_actualizacion)) {
            $fecha_actualizacion = "and a.fecha_actualizacion = '{$this->fecha_actualizacion}'";
        }

        $id_estatus = "";
        if (!empty($this->id_estatus)) {
            $id_estatus = "and a.id_estatus = '{$this->id_estatus}'";
        }

        $id_proceso = "";
        if (!empty($this->id_proceso)) {
            $id_proceso = "and a.id_proceso = '{$this->id_proceso}'";
        }

        $id_tipo_documento = "";
        if (!empty($this->id_tipo_documento)) {
            $id_tipo_documento = "and a.id_tipo_documento = '{$this->id_tipo_documento}'";
        }

        $id_departamento = "";
        if (!empty($this->id_departamento)) {
            $id_departamento = "and a.id_departamento = '{$this->id_departamento}'";
        }

        $clave_calidad = "";
        if (!empty($this->clave_calidad)) {
            $clave_calidad = "and a.clave_calidad = '{$this->clave_calidad}'";
        }

        $nombre = "";
        if (!empty($this->nombre)) {
            $nombre = "and a.nombre = '{$this->nombre}'";
        }

        $sql = "SELECT a.id,a.fecha_creacion, a.fecha_actualizacion, b.nombre as estatus_nombre, c.nombre as proceso, 
        d.nombre as tipo_documento, e.nombre as departamento, a.clave_calidad, a.nombre, a.url_word,a.url_pdf, a.id_puesto FROM documentacion as a
        left join estatus_documento as b on a.id_estatus = b.id
        left join proceso as c on a.id_proceso = c.id
        left join documento as d on a.id_tipo_documento = d.id
        left join departamentos as e on a.id_departamento = e.id
        where 1=1
         {$sqlForm} {$fecha_creacion} {$fecha_actualizacion}
         {$id_estatus} {$id_proceso} {$id_tipo_documento} 
         {$id_departamento} {$clave_calidad} {$nombre}";
        return $this->Query($sql);
    }

    public function Informacion()
    {

        $sql = "select * from documentacion where  id='{$this->id}'";
        $res = parent::Query($sql);

        if (!empty($res) && !($res === NULL)) {
            foreach ($res[0] as $idx => $valor) {
                $this->{$idx} = $valor;
            }
        } else {
            $res = NULL;
        }

        return $res;
    }

    public function Ultimo()
    {
        $sql = "select count(id) as num from documentacion where clave_calidad like '{$this->clave_calidad}%'";
        $res = parent::Query($sql);

        if (!empty($res) && !($res === NULL)) {
            foreach ($res[0] as $idx => $valor) {
                $this->{$idx} = $valor;
            }
        } else {
            $res = NULL;
        }

        return $res;
    }

    public function Existe()
    {
        $sql = "select id from documentacion where id='{$this->id}'";
        $res = $this->Query($sql);

        $bExiste = false;

        if (count($res) > 0) {
            $bExiste = true;
        }
        return $bExiste;
    }

    public function Actualizar()
    {
        $sPuestos = "";
        if (! empty($this->id_puesto)) {
            foreach ($this->id_puesto as $idx => $valor) {
                $sPuestos .= $valor . "@";
            }
        }

        $sql = "UPDATE `mli`.`documentacion`
        SET
        `id` = '{$this->id}',
        `id_estatus` = '{$this->id_estatus}',
        `id_proceso` = '{$this->id_proceso}',
        `id_tipo_documento` = '{$this->id_tipo_documento}',
        `id_departamento` = '{$this->id_departamento}',
        `id_puesto` = '{$sPuestos}',
        `clave_calidad` = '{$this->clave_calidad}',
        `nombre` = '{$this->nombre}',
        `comentarios` = '{$this->comentarios}',
        `fecha_actualizacion` = now(),
        `usr_modificacion` = '{$this->user_id}'
        WHERE `id` = '{$this->id}'";

        $bResultado = $this->NonQuery($sql);

        if ($bResultado) {
            $sqlBitacora = "INSERT INTO `bitacora`
                                    (`id`,`modulo`,`operacion`,`modificacion`,`url_pdf`,`url_word`,`usuario`,`fecha`)
                                    VALUES
                                    ('0','DOCUMENTACION','ACTUALIZACION','(Proceso: {$this->id_proceso}°Tipo documento: {$this->id_tipo_documento}°Departamento: {$this->id_departamento}°Clave calidad: {$this->clave_calidad}°Nombre: {$this->nombre}°Comentarios: {$this->comentarios})',NULL,NULL,'{$this->user_id}',NOW())";

            $this->NonQuery($sqlBitacora);
        }

        return $bResultado;
    }

    public function Agregar()
    {   
        $sPuestos = "";
        if (! empty($this->id_puesto)) {
            foreach ($this->id_puesto as $idx => $valor) {
                $sPuestos .= $valor . "@";
            }
        }

        $sql = "INSERT INTO `documentacion`
        (`id`,`id_estatus`,`id_proceso`,`id_tipo_documento`,`id_departamento`,`id_puesto`,`clave_calidad`,
        `nombre`,`comentarios`,`fecha_creacion`,`usr_creacion`,`estatus`)
        VALUES
        (0,'{$this->id_estatus}','{$this->id_proceso}','{$this->id_tipo_documento}','{$this->id_departamento}','{$sPuestos}',
        '{$this->clave_calidad}','{$this->nombre}','{$this->comentarios}','".$this->fecha_creacion."',
        '{$this->user_id}','1');";

        $bResultado = $this->NonQuery($sql);

        if ($bResultado) {
            $sqlBitacora = "INSERT INTO `bitacora`
                                    (`id`,`modulo`,`operacion`,`modificacion`,`url_pdf`,`url_word`,`usuario`,`fecha`)
                                    VALUES
                                    ('0','DOCUMENTACION','AGREGADO','(Proceso: {$this->id_proceso}°Tipo documento: {$this->id_tipo_documento}° Departamento: {$this->id_departamento}°Puestos: {$sPuestos}°Clave calidad: {$this->clave_calidad}°Nombre: {$this->nombre}°Comentarios: {$this->comentarios}°Fecha creacion: {$this->fecha_creacion})',NULL,NULL,'{$this->user_id}',NOW())";

            $this->NonQuery($sqlBitacora);

            $sql1 = "select id from documentacion order by id desc limit 1";
            $res = $this->Query($sql1);

            $this->id = $res[0]->id;
        }

        return $bResultado;
    }

    public function Guardar()
    {
        $bRes = false;
        if ($this->Existe() === true) {
            $bRes = $this->Actualizar();
        } else {
            $bRes = $this->Agregar();
        }

        return $bRes;
    }

    public function Desactivar()
    {

        $sql = "update
                    documento
                set
                estatus = '{$this->estatus}'
                where
                  id='{$this->id}'";
        return $this->NonQuery($sql);
    }

    public function Quitar()
    {
        $bResultado = false;
        $sql = "select {$this->campo} from documentacion where id='{$this->id}'";
        $res = $this->Query($sql);

        if ($res){
            $sql = "update documentacion set {$this->campo}=null where id='{$this->id}'";
            $bResultado = parent::NonQuery($sql);

            if ($bResultado) {
                $sqlBitacora = "INSERT INTO `bitacora`
                    (`id`,`modulo`,`operacion`,`modificacion`,`url_pdf`,`url_word`,`usuario`,`fecha`)
                    VALUES
                    ('0','DOCUMENTACION','QUITAR','{$this->campo}','{$this->url_pdf}','{$this->url_word}','{$this->user_id}',NOW())";

                $this->NonQuery($sqlBitacora);
            }
        }
        return $bResultado;
    }

    public function SubirArchivoWord($documento,$archivo, $id_departamento, $clave_calidad)
    {
        $sql = "select nombre from departamentos where id='{$id_departamento}'";
        $res = $this->Query($sql);

        if ($res[0]->nombre != "") {
            
            $bResultado = false;
            $dirFotos = $this->RutaAbsoluta . "word/";
            @mkdir($dirFotos);
            $dirFotos .= "{$res[0]->nombre}/";
            @mkdir($dirFotos);

            $archivoDir = "word/{$res[0]->nombre}/";

            if ($archivo['error'] == 0) { // si se subió el archivo

                $nomArchivoTemp = explode(".", $archivo['name']);
                $extArchivo = strtoupper(trim(end($nomArchivoTemp)));

                if (!($extArchivo == "DOC" || $extArchivo == "DOCX" || $extArchivo == "XLSX" || $extArchivo == "VSDX")) { // si no es igual a word
                    return 2;
                }

                $nomArchivo = $clave_calidad.date('Y-m-d');
                $nomArchivo .= ".";
                $nomArchivo .= $extArchivo;
                $archivoDir .= $nomArchivo;
                $uploadfile = $dirFotos . basename($nomArchivo);

                if (move_uploaded_file($archivo['tmp_name'], $uploadfile)) {
                    $sql = "update documentacion set  url_word = '{$archivoDir}' where id = '{$documento}'";
                    $bResultado = parent::NonQuery($sql);
                    if ($bResultado) {
                        $sqlBitacora = "INSERT INTO `bitacora`
                                                (`id`,`modulo`,`operacion`,`modificacion`,`url_pdf`,`url_word`,`usuario`,`fecha`)
                                                VALUES
                                                ('0','DOCUMENTACION','AGREGAR EDITABLE','{$clave_calidad}',NULL,'{$archivoDir}','{$this->user_id}',NOW())";
            
                        $this->NonQuery($sqlBitacora);
                    }
                }
            }
            return $bResultado == 1 ? true : false;
        } else {
            return false;
        }
    }

    public function SubirArchivoPdf($documento,$archivo, $id_departamento, $clave_calidad)
    {   
        $sql = "select nombre from departamentos where id='{$id_departamento}'";
        $res = $this->Query($sql);

        if ($res[0]->nombre != "") {
            
            $bResultado = false;
            $dirFotos = $this->RutaAbsoluta . "pdf/";
            @mkdir($dirFotos);
            $dirFotos .= "{$res[0]->nombre}/";
            @mkdir($dirFotos);

            $archivoDir = "pdf/{$res[0]->nombre}/";

            if ($archivo['error'] == 0) { // si se subió el archivo

                $nomArchivoTemp = explode(".", $archivo['name']);
                $extArchivo = strtoupper(trim(end($nomArchivoTemp)));

                if (!($extArchivo == "PDF" )) { // si no es igual a word
                    return 2;
                }

                $nomArchivo = $clave_calidad.date('Y-m-d');
                $nomArchivo .= ".";
                $nomArchivo .= $extArchivo;
                $archivoDir .= $nomArchivo;
                $uploadfile = $dirFotos . basename($nomArchivo);

                if (move_uploaded_file($archivo['tmp_name'], $uploadfile)) {
                    $sql = "update documentacion set  url_pdf = '{$archivoDir}' where id = '{$documento}'";
                    $bResultado = parent::NonQuery($sql);

                    if ($bResultado) {
                        $sqlBitacora = "INSERT INTO `bitacora`
                                                (`id`,`modulo`,`operacion`,`modificacion`,`url_pdf`,`url_word`,`usuario`,`fecha`)
                                                VALUES
                                                ('0','DOCUMENTACION','AGREGAR LECTURA','{$clave_calidad}','{$archivoDir}',NULL,'{$this->user_id}',NOW())";
            
                        $this->NonQuery($sqlBitacora);
                    }
                }
            }
            return $bResultado == 1 ? true : false;
        } else {
            return false;
        }
    }
}
