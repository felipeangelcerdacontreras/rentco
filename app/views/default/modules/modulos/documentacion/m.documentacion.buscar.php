<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/documentacion.class.php");
require_once($_SITE_PATH . "app/model/estatus_documento.class.php");
require_once($_SITE_PATH . "app/model/documento.class.php");
require_once($_SITE_PATH . "app/model/proceso.class.php");
require_once($_SITE_PATH . "app/model/departamentos.class.php");
require_once($_SITE_PATH . "app/model/puestos.class.php");

$oDocumentacion = new documentacion();
$sesion = $_SESSION[$oDocumentacion->NombreSesion];
$oDocumentacion->ValidaNivelUsuario("documentacion");

$oEstatus_documento = new estatus_documento();
$oEstatus_documento->form = '1';
$lstEstatus_documento = $oEstatus_documento->Listado();

$oDocumento = new documento();
$oDocumento->form = '1';
$lstDocumento = $oDocumento->Listado();

$oProceso = new proceso();
$oProceso->form = '1';
$lstProceso = $oProceso->Listado();

$oDepartamentos = new departamentos();
$oDepartamentos->form = '1';
$lstDepartamentos = $oDepartamentos->Listado();

$oPuestos = new puestos();
$oPuestos->id_puesto = $sesion->puesto;
$lstPuestos = $oPuestos->Listado();

$fecha_actual = date("d-m-Y");
?>
<?php require_once('app/views/default/script_h.html'); ?>
<script type="text/javascript">
    $(document).ready(function(e) {
        Listado();
        $('#fecha_inicial').change(Listado);
        $('#fecha_final').change(Listado);

        $("#btnGuardar").button().click(function(e) {

            $(".form-control").css('border', '1px solid #d1d3e2');
            var frmTrue = true;

            $("#frmFormulario_").find('select, input').each(function() {
                var elemento = this;
                if ($(elemento).hasClass("obligado")) {
                    if (elemento.value == "" || elemento.value == 0) {
                        Alert("", $(elemento).attr("description"), "warning", 900, false);
                        Empty(elemento.id);
                        frmTrue = false;
                    }
                }
            });

            if (frmTrue == true) {
                $.ajax({
                    data: $('#frmFormulario_').submit(),
                    type: "POST",
                    url: "app/views/default/modules/modulos/documentacion/m.documentacion.procesa.php",
                    beforeSend: function() {
                        $("#btnGuardar").hide();
                        $("#divFormulario_").html(
                            '<div class="container"><center><img src="app/views/default/img/loading.gif" border="0"/><br />Insertando informacion en la BD, espere un momento por favor...</center></div>'
                        );
                    },
                    success: function(datos) {
                        $("#btnGuardar").show();
                        Listado();
                    }
                });
            }
        });
        $("#btnBuscar").button().click(function(e) {
            $(".form-control").css('border', '1px solid #d1d3e2');
            var frmTrue = true;

            $("#busqueda").find('select, input').each(function() {
                var elemento = this;
                if ($(elemento).hasClass("busqueda")) {
                    if (elemento.value == "" || elemento.value == 0) {
                        Alert("", $(elemento).attr("description"), "warning", 900, false);
                        Empty(elemento.id);
                        frmTrue = false;
                    }
                }
            });

            if (frmTrue == true) {
                Listado();
            }
        });

    });

    function Listado() {
        var jsonDatos = {
            "fecha_creacion": $("#fecha_creacion_").val(),
            "fecha_actualizacion": $("#fecha_actualizacion_").val(),
            "id_estatus": $("#id_estatus_").val(),
            "id_proceso": $("#id_proceso_").val(),
            "id_tipo_documento": $("#id_tipo_documento_").val(),
            "id_departamento": $("#id_departamento_").val(),
            "clave_calidad": $("#clave_calidad_").val(),
            "nombre": $("#nombre_").val()
        };
        $.ajax({
            data: jsonDatos,
            type: "POST",
            url: "app/views/default/modules/modulos/documentacion/m.documentacion.listado.php",
            beforeSend: function() {
                $("#divListado").html(
                    '<div class="container"><center><img src="app/views/default/img/loading.gif" border="0"/><br />Leyendo información de la Base de Datos, espere un momento por favor...</center></div>'
                );
            },
            success: function(datos) {
                $(".tooltip-inner").remove();
                $("#divListado").html(datos);
            }
        });
    }

    function Editar(id, nombre, id_empleado, empleado) {
        $("#btnGuardar").show();
        switch (nombre) {
            case 'Agregar':
                $.ajax({
                    data: "nombre=" + nombre + "&id=" + id,
                    type: "POST",
                    url: "app/views/default/modules/modulos/documentacion/m.documentacion.formulario.php",
                    beforeSend: function() {
                        $("#divFormulario").html(
                            '<div class="container"><center><img src="app/views/default/img/loading.gif" border="0"/><br />Cargando formulario, espere un momento por favor...</center></div>'
                        );
                    },
                    success: function(datos) {
                        $("#divFormulario").html(datos);
                    }
                });
                $("#myModal").modal({
                    backdrop: "true"
                });
                break;
                
            case 'Actualizar':
                $.ajax({
                    data: "nombre=" + nombre + "&id=" + id,
                    type: "POST",
                    url: "app/views/default/modules/modulos/documentacion/m.documentacion.formulario.php",
                    beforeSend: function() {
                        $("#divFormulario").html(
                            '<div class="container"><center><img src="app/views/default/img/loading.gif" border="0"/><br />Cargando formulario, espere un momento por favor...</center></div>'
                        );
                    },
                    success: function(datos) {
                        $("#divFormulario").html(datos);
                    }
                });
                $("#myModal").modal({
                    backdrop: "true"
                });
                break;

            case 'Ver':
                $("#btnGuardar").hide();
                $.ajax({
                    data: "nombre=" + nombre + "&id=" + id+"#toolbar=0",
                    type: "POST",
                    url: "app/views/default/modules/modulos/documentacion/m.documentacion.ver.php",
                    beforeSend: function() {
                        $("#divFormulario").html(
                            '<div class="container"><center><img src="app/views/default/img/loading.gif" border="0"/><br />Cargando formulario, espere un momento por favor...</center></div>'
                        );
                    },
                    success: function(datos) {
                        $("#divFormulario").html(datos);
                    }
                });
                $("#myModal").modal({
                    backdrop: "true"
                });
                break;
            case 'Imprimir':
                $("#btnGuardar").hide();
                $.ajax({
                    data: "nombre=" + nombre + "&id=" + id+"#downloads=0",
                    type: "POST",
                    url: "app/views/default/modules/modulos/documentacion/m.documentacion.ver.php",
                    beforeSend: function() {
                        $("#divFormulario").html(
                            '<div class="container"><center><img src="app/views/default/img/loading.gif" border="0"/><br />Cargando formulario, espere un momento por favor...</center></div>'
                        );
                    },
                    success: function(datos) {
                        $("#divFormulario").html(datos);
                    }
                });
                $("#myModal").modal({
                    backdrop: "true"
                });
                break;
        }
    }
</script>

<?php require_once('app/views/default/link.html'); ?>
<script src="app/views/default/js/jsPDF/jspdf.js"></script>

<head>
    <?php require_once('app/views/default/head.html'); ?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <title>Documentacion</title>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- archivo menu-->
        <?php require_once('app/views/default/menu.php'); ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!--archivo header-->
                <?php require_once('app/views/default/header.php'); ?>
                <div class="container-fluid">
                    <!-- contenido de la pagina -->
                    <div class="card shadow mb-4">
                        <center>
                            <div class="card-header py-3" id="busqueda" style="text-align:left">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <strong class="">Fecha de Creación:</strong>
                                            <div class="form-group">
                                                <input type="date" aria-describedby="" description="Seleccione fecha de creación" id="fecha_creacion_" value="" required name="fecha_creacion_" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <strong class="">Fecha de Revision o Actualización:</strong>
                                            <div class="form-group">
                                                <input type="date" aria-describedby="" description="Seleccione fecha de revisión o actualización" id="fecha_actualizacion_" value="" required name="fecha_actualizacion_" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <strong class="">Estatus del Documento:</strong>
                                            <div class="form-group">
                                                <select id="id_estatus_" description="Seleccione el puesto" class="form-control " name="id_estatus_">
                                                    <?php
                                                    if (count($lstEstatus_documento) > 0) {
                                                        echo "<option value='0' >-- SELECCIONE --</option>\n";
                                                        foreach ($lstEstatus_documento as $idx => $campo) {
                                                            echo "<option value='{$campo->id}' >{$campo->nombre}</option>\n";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <strong class="">Proceso:</strong>
                                            <div class="form-group">
                                                <select id="id_proceso_" description="Seleccione el puesto" class="form-control " name="id_proceso_">
                                                    <?php
                                                    if (count($lstProceso) > 0) {
                                                        echo "<option value='0' >-- SELECCIONE --</option>\n";
                                                        foreach ($lstProceso as $idx => $campo) {
                                                            echo "<option value='{$campo->id}' >{$campo->nombre}</option>\n";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <strong class="">Tipo de documento:</strong>
                                            <div class="form-group">
                                                <select id="id_tipo_documento_" description="Seleccione el puesto" class="form-control" name="id_tipo_documento_">
                                                    <?php
                                                    if (count($lstDocumento) > 0) {
                                                        echo "<option value='0' >-- SELECCIONE --</option>\n";
                                                        foreach ($lstDocumento as $idx => $campo) {
                                                            echo "<option value='{$campo->id}' >{$campo->nombre}</option>\n";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <strong class="">Area/departamento:</strong>
                                            <div class="form-group">
                                                <select id="id_departamento_" description="Seleccione el puesto" class="form-control" name="id_departamento_">
                                                    <?php
                                                    if (count($lstDepartamentos) > 0) {
                                                        if ($sesion->nvl_usuario <= 1) {
                                                            echo "<option value='0' >-- SELECCIONE --</option>\n";
                                                        }
                                                        foreach ($lstDepartamentos as $idx => $campo) {
                                                            if ($sesion->nvl_usuario > 1) {
                                                                if ($campo->id == $lstPuestos[0]->id_departamento) {
                                                                    echo "<option value='{$campo->id}' selected>{$campo->nombre}</option>\n";
                                                                }
                                                            } else {
                                                                echo "<option value='{$campo->id}' >{$campo->nombre}</option>\n";
                                                            }
                                                        }
                                                    
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <strong class="">Clave de Calidad:</strong>
                                            <div class="form-group">
                                                <input type="text" description="" aria-describedby="" id="clave_calidad_" required name="clave_calidad_" value="" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <strong class="">Nombre:</strong>
                                            <div class="form-group">
                                                <input type="text" description="" aria-describedby="" id="nombre_" required name="nombre_" value="" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="justify-content: flex-end;">
                                    <button class="btn btn-outline-primary" type="button" id="btnBuscar" data-dismiss="modal">Buscar </button>
                                </div>
                            </div>
                        </center>
                    </div>
                    <!-- cerrar contenido pagina-->
                    <div id="divListado"></div>
                </div>
            </div>
            <!-- Logout Modal-->
            <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><strong id="nameModal"></strong>
                            </h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- contenido del modal-->
                            <div style="width:100%;" class="modal-body" id="divFormulario">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-outline-primary" id="btnGuardar" value="Guardar">
                            <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->

            <!-- archivo Footer -->
            <?php require_once('app/views/default/footer.php'); ?>
            <!-- End of Footer -->
        </div>
    </div>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <?php require_once('app/views/default/script_f.html'); ?>
</body>

</html>