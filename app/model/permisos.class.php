<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/principal.class.php");

class permisos extends AW {

    var $id;
    var $nvl_usuario;
    var $puesto;
    var $user_id;
    var $estado;

    var $perfiles_id;

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
        $sql = "SELECT b.nombre as puesto, c.nombre as departamento, a.estado, a.id  FROM permisos as a
        left join puestos as b on  a.puesto = b.id
        left join departamentos as c on b.id_departamento = c.id;  ";
        //echo nl2br($sql);
        return $this->Query($sql);
    }

    public function Informacion() {

        $sql = "select * from permisos where  id='{$this->id}'";
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

    public function permisos() {

        $sql = "select * from permisos where  puesto='{$this->puesto}'";
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
        $sql = "select id from permisos where id='{$this->id}'";
        $res = $this->Query($sql);

        $bExiste = false;

        if (count($res) > 0) {
            $bExiste = true;
        }
        return $bExiste;
    }

    public function Actualizar() {

        $sPermisos = "";
        if (! empty($this->perfiles_id)) {
            foreach ($this->perfiles_id as $idx => $valor) {
                $sPermisos .= $valor . "@";
            }
        }

        $sql = "update
                    permisos
                set
                    perfiles_id = '{$sPermisos}',
                    puesto = '{$this->puesto}',
                    nvl_usuario = '{$this->nvl_usuario}'
                where
                  id='{$this->id}'";

        $bResultado = $this->NonQuery($sql);

        if ($bResultado) {
            $sqlBitacora = "INSERT INTO `mli`.`bitacora`
            (`id`,`modulo`,`operacion`,`modificacion`,`url_pdf`,`url_word`,`usuario`,`fecha`)
            VALUES
            ('0','permisos','ACTUALIZACION','{$sPermisos}°Puesto :{$this->puesto}° Nivel: {$this->nvl_usuario})',NULL,NULL,'{$this->user_id}',NOW());";

            $this->NonQuery($sqlBitacora);
        }

        return $bResultado;

    }

    public function Agregar() {
        $sPermisos = "";
        if (!empty($this->perfiles_id)) {
            foreach ($this->perfiles_id as $idx => $valor) {
                $sPermisos .= $valor . "@";
            }
        }

        $sql = "insert into permisos
                (`id`,`perfiles_id`,`nvl_usuario`,`puesto`,`estado`,`usuario_creacion`,`fecha_creacion`)
                values
                ('0','{$sPermisos}','{$this->nvl_usuario}','{$this->puesto}', '1', '{$this->user_id}', now())";
        $bResultado = $this->NonQuery($sql);

        if ($bResultado) {
            $sqlBitacora = "INSERT INTO `mli`.`bitacora`
            (`id`,`modulo`,`operacion`,`modificacion`,`url_pdf`,`url_word`,`usuario`,`fecha`)
            VALUES
            ('0','permisos','AGREGADO','{$sPermisos}°Puesto :{$this->puesto}° Nivel: {$this->nvl_usuario})',NULL,NULL,'{$this->user_id}',NOW());";

            $this->NonQuery($sqlBitacora);
            
            $sql1 = "select id from permisos order by id desc limit 1";
            $res = $this->Query($sql1);
            
            $this->id = $res[0]->id;
        }

        return $bResultado;
    }

    public function Desactivar() {

        $sql = "update
                    permisos
                set
                    estado = '{$this->estado}'
                where
                  id='{$this->id}'";
                 // echo nl2br($sql);
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