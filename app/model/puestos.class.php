<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/principal.class.php");

class puestos extends AW
{

    var $id;
    var $nombre;
    var $estatus;
    var $id_departamento;
    var $user_id;
    var $id_puesto;


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
            $sqlForm = " and a.estatus = '1'";
        }

        $sqlPuesto = "";
        if (!empty($this->id_puesto)) {
            $sqlPuesto = " and a.id = '{$this->id_puesto}'";
        }

        $sql = "select a.*, b.nombre as departamento FROM puestos as a join  departamentos as b on a.id_departamento = b.id where 1=1 {$sqlForm} {$sqlPuesto}";
        
        return $this->Query($sql);
    }

    public function Informacion()
    {

        $sql = "select * from puestos where  id='{$this->id}'";
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
        $sql = "select id from puestos where id='{$this->id}'";
        $res = $this->Query($sql);

        $bExiste = false;

        if (count($res) > 0) {
            $bExiste = true;
        }
        return $bExiste;
    }

    public function Actualizar()
    {
        $sql = "update
                    puestos
                set
                nombre = '{$this->nombre}',
                id_departamento = '{$this->id_departamento}',
                usuario_edicion = '{$this->user_id}', 
                fecha_modificacion = now()
                where
                  id='{$this->id}'";
        $bResultado = $this->NonQuery($sql);

        if ($bResultado) {
            $sqlBitacora = "INSERT INTO `bitacora`
            (`id`,`modulo`,`operacion`,`modificacion`,`url_pdf`,`url_word`,`usuario`,`fecha`)
            VALUES
            ('0','PUESTOS','ACTUALIZACIONS','(Nombre: {$this->nombre}°Departamento: {$this->id_departamento})',NULL,NULL,'{$this->user_id}',NOW())";

            $this->NonQuery($sqlBitacora);
        }

        return $bResultado;
    }

    public function Agregar()
    {


        $sql = "insert into puestos
                (`id`,`nombre`,`estatus`,`id_departamento`,`usuario_creacion` )
                values
                ('0','{$this->nombre}','1','{$this->id_departamento}','{$this->user_id}')";
        $bResultado = $this->NonQuery($sql);

        if ($bResultado) {
            $sqlBitacora = "INSERT INTO `bitacora`
            (`id`,`modulo`,`operacion`,`modificacion`,`url_pdf`,`url_word`,`usuario`,`fecha`)
            VALUES
            ('0','PUESTOS','AGREGADO','(Nombre: {$this->nombre}°Departamento: {$this->id_departamento})',NULL,NULL,'{$this->user_id}',NOW())";

            $this->NonQuery($sqlBitacora);

            $sql1 = "select id from puestos order by id desc limit 1";
            $res = $this->Query($sql1);

            $this->id = $res[0]->id;
        }

        return $bResultado;
    }

    public function Desactivar()
    {

        $sql = "update
                    puestos
                set
                estatus = '{$this->estatus}'
                where
                  id='{$this->id}'";
        return $this->NonQuery($sql);
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
}
