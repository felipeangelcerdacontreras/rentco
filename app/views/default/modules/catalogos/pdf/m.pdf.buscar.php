<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/pdf.class.php");

$oPdf = new pdf();
$sesion = $_SESSION[$oPdf->NombreSesion];
$oPdf->ValidaNivelUsuario("pdf");

?>
<?php require_once('app/views/default/script_h.html'); ?>
<script type="text/javascript">
    $(document).ready(function(e) {
        Listado();
        $("#btnGuardar").button().click(function(e) {
            $(".form-control").css('border', '1px solid #d1d3e2');
            var frmTrue = true;

            $("#frmFormulario").find('select, input').each(function() {
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
                $("#frmFormulario").submit();
            }
        });
        $("#btnGuardar_txt").button().click(function(e) {
            $(".form-control").css('border', '1px solid #d1d3e2');
            var frmTrue = true;

            $("#frmFormulario_txt").find('select, input, textarea').each(function() {
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
                $("#frmFormulario_txt").submit();
            }
        });

        $("#btnGuardar_img").button().click(function(e) {
            $(".form-control").css('border', '1px solid #d1d3e2');
            var frmTrue = true;

            $("#frmFormulario_img").find('select, input').each(function() {
                var elemento = this;
                
                if ($(elemento).hasClass("obligado")) {
                    console.log(elemento);
                    if (elemento.value == "" || elemento.value == 0) {
                        Alert("", $(elemento).attr("description"), "warning", 900, false);
                        Empty(elemento.id);
                        frmTrue = false;
                    }
                }
            });
            if (frmTrue == true) {
                $("#frmFormulario_img").submit();
            }
        });

        $("#btnGuardar_vid").button().click(function(e) {
            $(".form-control").css('border', '1px solid #d1d3e2');
            var frmTrue = true;

            $("#frmFormulario_vid").find('select, input, textarea').each(function() {
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
                $("#frmFormulario_vid").submit();
            }
        });

        $("#btnBuscar").button().click(function(e) {
            Listado();
        });

    });

    function Listado() {
        var jsonDatos = {
            "accion": "BUSCAR"
        };
        $.ajax({
            data: jsonDatos,
            type: "POST",
            url: "app/views/default/modules/catalogos/pdf/m.pdf.listado.php",
            beforeSend: function() {
                $("#divListado").html(
                    '<div class="container"><center><img src="app/views/default/img/loading.gif" border="0"/><br />Leyendo información de la Base de Datos, espere un momento por favor...</center></div>'
                );
            },
            success: function(datos) {
                $("#divListado").html(datos);
            }
        });
    }

    function Editar(id_pdf, nombre, type) {
        if (nombre == "Desactivar") {
            $.ajax({
                data: "accion=Desactivar&id_pdf=" + id_pdf + "&estatus= 0",
                type: "POST",
                url: "app/views/default/modules/catalogos/pdf/m.pdf.procesa.php",
                beforeSend: function() {

                },
                success: function(datos) {
                    console.log(datos);
                    Listado();
                }
            });
        } else if (nombre == "Activar") {
            $.ajax({
                data: "accion=Desactivar&id_pdf=" + id_pdf + "&estatus= 1",
                type: "POST",
                url: "app/views/default/modules/catalogos/pdf/m.pdf.procesa.php",
                beforeSend: function() {

                },
                success: function(datos) {
                    console.log(datos);
                    Listado();
                }
            });
        } else if (nombre == "Cargar") {
            $.ajax({
                    data: "id_pdf=" + id_pdf + "&nombre=" +nombre,
                    type: "POST",
                    url: "app/views/default/modules/catalogos/pdf/m.pdf.carga.formulario.php",
                    beforeSend: function() {
                        $("#divFormulario_").html(
                            '<div class="container"><center><img src="app/views/default/img/loading.gif" border="0"/><br />Cargando formulario, espere un momento por favor...</center></div>'
                        );
                    },
                    success: function(datos) {
                        $("#divFormulario_").html(datos);
                    }
                });
                $("#myModal_1_").modal({
                    backdrop: "true"
                });
        } else if (nombre == "Agregar texto" && type == "txt") {
            $.ajax({
                    data: "id_text=" + id_pdf + "&nombre=" +nombre,
                    type: "POST",
                    url: "app/views/default/modules/catalogos/pdf/m.pdf.formulario.txt.php",
                    beforeSend: function() {
                        $("#divFormulario_txt").html(
                            '<div class="container"><center><img src="app/views/default/img/loading.gif" border="0"/><br />Cargando formulario, espere un momento por favor...</center></div>'
                        );
                    },
                    success: function(datos) {
                        $("#divFormulario_txt").html(datos);
                    }
                });
                $("#myModal_txt").modal({
                    backdrop: "true"
                });
        } else if (nombre == "Agregar imagen" && type == "img") {
            $.ajax({
                    data: "id_image=" + id_pdf + "&nombre=" +nombre,
                    type: "POST",
                    url: "app/views/default/modules/catalogos/pdf/m.pdf.formulario.img.php",
                    beforeSend: function() {
                        $("#divFormulario_img").html(
                            '<div class="container"><center><img src="app/views/default/img/loading.gif" border="0"/><br />Cargando formulario, espere un momento por favor...</center></div>'
                        );
                    },
                    success: function(datos) {
                        $("#divFormulario_img").html(datos);
                    }
                });
                $("#myModal_img").modal({
                    backdrop: "true"
                });
        } else if (nombre == "Agregar video" && type == "vid") {
            $.ajax({
                    data: "id_video=" + id_pdf + "&nombre=" +nombre,
                    type: "POST",
                    url: "app/views/default/modules/catalogos/pdf/m.pdf.formulario.vid.php",
                    beforeSend: function() {
                        $("#divFormulario_vid").html(
                            '<div class="container"><center><img src="app/views/default/img/loading.gif" border="0"/><br />Cargando formulario, espere un momento por favor...</center></div>'
                        );
                    },
                    success: function(datos) {
                        $("#divFormulario_vid").html(datos);
                    }
                });
                $("#myModal_vid").modal({
                    backdrop: "true"
                });
        } else {
            $.ajax({
                data: "id_pdf=" + id_pdf + "&nombre=" + nombre,
                type: "POST",
                url: "app/views/default/modules/catalogos/pdf/m.pdf.formulario.php",
                beforeSend: function() {
                    $("#divFormulario").html(
                        '<div class="container"><center><img src="app/views/default/img/loading.gif" border="0"/><br />Cargando formulario, espere un momento por favor...</center></div>'
                    );
                },
                success: function(datos) {
                    $("#divFormulario").html(datos);
                }
            });
            $("#myModal_1").modal({
                backdrop: "true"
            });
        }
    }
</script>

<?php require_once('app/views/default/link.html'); ?>

<head>
    <?php require_once('app/views/default/head.html'); ?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <title>pdf</title>
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

                    <!-- cerrar contenido pagina-->
                    <div id="divListado"></div>
                </div>
            </div>
            <!-- Logout Modal-->
            <div class="modal fade" id="myModal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
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

            <!-- Logout Modal-->
            <div class="modal fade bd-example-modal-xl" id="myModal_1_" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <div style="width:100%;" class="modal-body" id="divFormulario_">
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

            <!-- Logout Modal-->
            <div class="modal fade bd-example-modal-xl" id="myModal_txt" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><strong id="nameModal_txt"></strong>
                            </h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- contenido del modal-->
                            <div style="width:100%;" class="modal-body" id="divFormulario_txt">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-outline-primary" id="btnGuardar_txt" value="Guardar">
                            <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->

            <!-- Logout Modal-->
            <div class="modal fade bd-example-modal-xl" id="myModal_img" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><strong id="nameModal_img"></strong>
                            </h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- contenido del modal-->
                            <div style="width:100%;" class="modal-body" id="divFormulario_img">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-outline-primary" id="btnGuardar_img" value="Guardar">
                            <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->

            <!-- Logout Modal-->
            <div class="modal fade bd-example-modal-xl" id="myModal_vid" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><strong id="nameModal_vid"></strong>
                            </h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- contenido del modal-->
                            <div style="width:100%;" class="modal-body" id="divFormulario_vid">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-outline-primary" id="btnGuardar_vid" value="Guardar">
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