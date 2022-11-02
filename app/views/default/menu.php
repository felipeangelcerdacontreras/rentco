<?php
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/Configuracion.class.php");
require_once($_SITE_PATH . "/app/model/usuarios.class.php");

$oConfig = new Configuracion();

$sesion = $_SESSION[$oConfig->NombreSesion];
//print_r($sesion);
$oUsuario = new usuarios();
$oUsuario->id = $sesion->id;
$oUsuario->Informacion();

$aPermisos = empty($oUsuario->perfiles_id) ? array() : explode("@", $oUsuario->perfiles_id);
?>
<style>
    .bg-gradient-primary {
    background-color: #ffffff !important;
    background-image: -webkit-gradient(linear,left top,left bottom,color-stop(10%,#4e73df),to(#f5f6f9)) !important;
    background-image: linear-gradient(180deg,#002daf 10%,#002daf 100%)!important;
    background-size: cover !important;
}
</style>
<script>
    $(document).ready(function(e) {
        $('#empleados').attr('href', "index.php?action=empleados&token=" + localStorage.getItem("srnPc"));
    });
</script>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <hr class="sidebar-divider">
    <!-- Heading -->

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Catalogós</span>
        </a>

        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <?php if ($oUsuario->ExistePermiso("departamentos", $aPermisos) === true) { ?>
                    <a class='collapse-item' href='index.php?action=departamentos'>Departamentos</a>
                <?php } ?>
                <?php if ($oUsuario->ExistePermiso("puestos", $aPermisos) === true) { ?>
                    <a class='collapse-item' href='index.php?action=puestos'>Puestos</a>
                <?php } ?>
                <?php if ($oUsuario->ExistePermiso("usuarios", $aPermisos) === true) { ?>
                    <a class='collapse-item' href='index.php?action=usuarios'>Usuarios</a>
                <?php } ?>
                <?php if ($oUsuario->ExistePermiso("estatus_documento", $aPermisos) === true) { ?>
                    <a class='collapse-item' href='index.php?action=estatus_documento'>Estatus documento</a>
                <?php } ?>
                <?php if ($oUsuario->ExistePermiso("proceso", $aPermisos) === true) { ?>
                    <a class='collapse-item' href='index.php?action=proceso'>Proceso</a>
                <?php } ?>
                <?php if ($oUsuario->ExistePermiso("documento", $aPermisos) === true) { ?>
                    <a class='collapse-item' href='index.php?action=documento'>Documento</a>
                <?php } ?>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEtapa1" aria-expanded="true" aria-controls="collapseEtapa1">
            <i class="fas fa-fw fa-folder"></i>
            <span>Modulos</span>
        </a>
        <div id="collapseEtapa1" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
            <!--<div class="text-center">
                <span>INTRODUCCION Y SENSIBILIZACION</span>
                <hr class="sidebar-divider" style="border-top: 1px solid rgb(0 0 0) !important;margin: 0 1rem 0rem !important;">
            </div>
                 if ($oUsuario->ExistePermiso("nominas_fiscal", $aPermisos) === true) { ?>-->
                    <!--} ?>-->
                    <a class='collapse-item' href='index.php?action=documentacion'>Documentación</a>
                    <?php if ($oUsuario->ExistePermiso("bitacora", $aPermisos) === true) { ?>
                        <a class='collapse-item' href='index.php?action=bitacora'>Bitacora</a>
                    <?php } ?>
            </div>
        </div>
    </li>
    
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->