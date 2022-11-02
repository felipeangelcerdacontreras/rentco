<?php
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/usuarios.class.php");
require_once($_SITE_PATH . "/app/model/principal.class.php");


$oConfig = new Configuracion();

$sesion = $_SESSION[$oConfig->NombreSesion];
//echo($_SERVER['HTTP_USER_AGENT']);
$oUsuario = new usuarios();
$oUsuario->usr_id = $sesion->id;
$oUsuario->Informacion();

?>
<script>
    $(document).ready(function(e) {

    });

    
</script>
<style>
    .topbar .dropdown-list .dropdown-header {
        background-color: #e7002f !important;
        border: 1px solid #dd0d0d !important;
    }
</style>
<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-outline-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Nav Item - Alerts 
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -
                <span class="badge badge-success badge-counter"></span>
            </a>
            <!-- Dropdown - Alerts 
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Solicitudes de modificacion de nomina.
                </h6>
                
        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information--> 
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> <?= $sesion->nombre_usuario ?></span>
                <img class="img-profile rounded-circle" src="app/views/default/img/profile.jpg">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Cerrar sesión
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- End of Topbar -->
<!-- Logout Modal-->
<div class="modal fade" id="myModal_" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- contenido del modal-->

            </div>
            <div class="modal-footer">

                <input type="submit" class="btn btn-outline-success" id="btnGuardar_" value="Guardar">
                <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<!--MODAL DE SALIDA-->
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">¿Listo para salir?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Seleccione "Cerrar sesión" a continuación si está listo para finalizar su sesión
                actual.</div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-outline-primary" href="index.php?action=cerrar_sesion">Cerrar sesión</a>
            </div>
        </div>

    </div>
</div>

<!-- Logout Modal-->
<div class="modal fade bd-example-modal-lg" id="nominasModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Aprobar solicitud</h5>
            </div>
            <div class="modal-body" id="modal-body-nomina">

            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>

    </div>
</div>

<!-- Logout Modal-->
<div class="modal fade bd-example-modal-lg" id="nominasModalF" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Aprobar solicitud</h5>
            </div>
            <div class="modal-body" id="modal-body-nominaF">

            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>

    </div>
</div>