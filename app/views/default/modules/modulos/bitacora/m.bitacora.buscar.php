<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/bitacora.class.php");
require_once($_SITE_PATH . "app/model/estatus_documento.class.php");
require_once($_SITE_PATH . "app/model/documento.class.php");
require_once($_SITE_PATH . "app/model/proceso.class.php");
require_once($_SITE_PATH . "app/model/departamentos.class.php");
require_once($_SITE_PATH . "app/model/puestos.class.php");

$obitacora = new bitacora();
$sesion = $_SESSION[$obitacora->NombreSesion];
$obitacora->ValidaNivelUsuario("bitacora");

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
        /*$('#fecha_inicial').change(Listado);
        $('#fecha_final').change(Listado);*/

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
                    url: "app/views/default/modules/modulos/bitacora/m.bitacora.procesa.php",
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
            "fecha_inicial": $("#fecha_inicial").val(),
            "fecha_final": $("#fecha_final").val(),
            "modulo": $("#modulo").val(),
            "operacion": $("#operacion").val(),
            "id_tipo_documento": $("#id_tipo_documento_").val(),
            "id_departamento": $("#id_departamento_").val(),
            "clave_calidad": $("#clave_calidad_").val(),
            "nombre": $("#nombre_").val()
        };
        $.ajax({
            data: jsonDatos,
            type: "POST",
            url: "app/views/default/modules/modulos/bitacora/m.bitacora.listado.php",
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
        switch (nombre) {
            case 'Agregar':
                $.ajax({
                    data: "nombre=" + nombre + "&id=" + id,
                    type: "POST",
                    url: "app/views/default/modules/modulos/bitacora/m.bitacora.formulario.php",
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
                $.ajax({
                    data: "nombre=" + nombre + "&id=" + id+"#toolbar=0",
                    type: "POST",
                    url: "app/views/default/modules/modulos/bitacora/m.bitacora.ver.php",
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
                $.ajax({
                    data: "nombre=" + nombre + "&id=" + id+"#downloads=0",
                    type: "POST",
                    url: "app/views/default/modules/modulos/bitacora/m.bitacora.ver.php",
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

                //$('#iframepdf').get(0).contentWindow.focus();
                //$("#iframepdf").get(0).contentWindow.print();
                //window.parent.iframepdf.focus();  // main es el nombre del iframe (o el nombre del iframe o frame que asignes.
		        //window.print();
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
    <title>bitacora</title>
</head>

<body id="page-top" >

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
                                            <strong class="">Fecha inicial:</strong>
                                            <div class="form-group">
                                                <input type="date" aria-describedby="" description="Seleccione fecha de creación" id="fecha_inicial" value="<?php echo date("Y-m-d", strtotime($fecha_actual . "- 1 week"));  ?>" required name="fecha_inicial" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <strong class="">Fecha final:</strong>
                                            <div class="form-group">
                                                <input type="date" aria-describedby="" description="Seleccione fecha de revisión o actualización" id="fecha_final" value="<?php echo date('Y-m-d'); ?>" required name="fecha_final" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <strong class="">Modulo:</strong>
                                            <div class="form-group">
                                                <select id="modulo" description="Seleccione el modulo" class="form-control " name="modulo">
                                                    <option value='0' >-- SELECCIONE --</option>\n";
                                                    <option value='DEPARTAMENTOS'>DEPARTAMENTOS</option>
                                                    <option value='PUESTOS'>PUESTOS</option>
                                                    <option value='USUARIOS'>USUARIOS</option>
                                                    <option value='ESTATUS DOCUMENTO'>ESTATUS DOCUMENTO</option>
                                                    <option value='PROCESO'>PROCESO</option>
                                                    <option value='DOCUMENTO'>DOCUMENTO</option>
                                                    <option value='DOCUMENTACION'>DOCUMENTACION</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <strong class="">Operacion:</strong>
                                            <div class="form-group">
                                                <select id="operacion" description="Seleccione el puesto" class="form-control " name="operacion">
                                                    <option value='0' >-- SELECCIONE --</option>\n";
                                                    <option value='AGREGADO'>AGREGADO</option>
                                                    <option value='AGREGAR EDITABLE'>AGREGAR EDITABLE</option>
                                                    <option value='AGREGAR LECTURA'>AGREGAR LECTURA</option>
                                                    <option value='ACTUALIZACION'>ACTUALIZACION</option>
                                                    <option value='QUITAR'>QUITAR</option>
                                                </select>
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

            <div>
                <iframe id="iframepdf" src=""></iframe>
            </div>


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