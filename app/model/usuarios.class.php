<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/principal.class.php");

class usuarios extends AW {

    var $id;
    var $nombre_usuario;
    var $usuario;
    var $correo;
    var $numero_economico;
    var $nvl_usuario;
    var $clave_usuario;
    var $clave_texto;
    var $puesto;
    var $id_permiso;
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
        $sql = "SELECT a.nombre_usuario, b.nombre as puesto, c.nombre as departamento, a.estado, a.id, a.clave_texto FROM usuarios as a 
        left join puestos as b on  a.puesto = b.id
        left join departamentos as c on b.id_departamento = c.id;  ";
        //echo nl2br($sql);
        return $this->Query($sql);
        
    }

    public function Informacion() {

        $sql = "select * from usuarios where  id='{$this->id}'";
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
        $sql = "select id from usuarios where id='{$this->id}'";
        $res = $this->Query($sql);

        $bExiste = false;

        if (count($res) > 0) {
            $bExiste = true;
        }
        return $bExiste;
    }

    public function Actualizar() {

        $sqlPass = "";
        if (!empty($this->clave_usuario)) {
            $sqlPass = ", clave='{$this->Encripta($this->clave_usuario)}', clave_texto='{$this->clave_usuario}'";
        }

        $sql = "update
                    usuarios
                set
                    nombre_usuario = '{$this->nombre_usuario}',
                    correo = '{$this->correo}',
                    puesto = '{$this->puesto}',
                    id_permiso = '{$this->id_permiso}'
                    {$sqlPass}
                where
                  id='{$this->id}'";

        $bResultado = $this->NonQuery($sql);

        if ($bResultado) {
            $sqlBitacora = "INSERT INTO `mli`.`bitacora`
            (`id`,`modulo`,`operacion`,`modificacion`,`url_pdf`,`url_word`,`usuario`,`fecha`)
            VALUES
            ('0','USUARIOS','ACTUALIZACION','°Nombre: {$this->nombre_usuario}°Correo: {$this->correo}°Puesto: {$this->puesto}°Permiso: {$this->id_permiso}°clave_texto: {$this->clave_usuario})',NULL,NULL,'{$this->user_id}',NOW());";

            $this->NonQuery($sqlBitacora);
        }

        return $bResultado;

    }

    public function Agregar() {

        $sql = "insert into usuarios
                (`id`,`nombre_usuario`,`correo`,`clave`,`clave_texto`,`puesto`,`id_permiso`,`estado`,`usuario_creacion`,`fecha_creacion`)
                values
                ('0','{$this->nombre_usuario}','{$this->correo}','{$this->Encripta($this->clave_usuario)}','{$this->clave_usuario}','{$this->puesto}','{$this->id_permiso}', '1', '{$this->user_id}', now())";
        $bResultado = $this->NonQuery($sql);

        if ($bResultado) {
            $sqlBitacora = "INSERT INTO `mli`.`bitacora`
            (`id`,`modulo`,`operacion`,`modificacion`,`url_pdf`,`url_word`,`usuario`,`fecha`)
            VALUES
            ('0','USUARIOS','AGREGADO','°Nombre: {$this->nombre_usuario}°Correo: {$this->correo}°Puesto: {$this->puesto}°Permiso: {$this->id_permiso}°clave_texto: {$this->clave_usuario})',NULL,NULL,'{$this->user_id}',NOW());";

            $this->NonQuery($sqlBitacora);
            
            $sql1 = "select id from usuarios order by id desc limit 1";
            $res = $this->Query($sql1);
            
            $this->id = $res[0]->id;
        }

        return $bResultado;
    }

    public function Desactivar() {

        $sql = "update
                    usuarios
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