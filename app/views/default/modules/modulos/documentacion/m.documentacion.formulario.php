<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/documentacion.class.php");
require_once($_SITE_PATH . "/app/model/usuarios.class.php");
require_once($_SITE_PATH . "app/model/estatus_documento.class.php");
require_once($_SITE_PATH . "app/model/documento.class.php");
require_once($_SITE_PATH . "app/model/proceso.class.php");
require_once($_SITE_PATH . "app/model/departamentos.class.php");
require_once($_SITE_PATH . "app/model/puestos.class.php");

$oDocumentacion = new documentacion();
$sesion = $_SESSION[$oDocumentacion->NombreSesion];
$oDocumentacion->ValidaNivelUsuario("documentacion");

$oDocumentacion->id = addslashes(filter_input(INPUT_POST, "id"));
$nombre = addslashes(filter_input(INPUT_POST, "nombre"));
$oDocumentacion->Informacion();

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
if ($sesion->nvl_usuario > 1) {
    $oPuestos2 = new puestos();
    $oPuestos2->form = '1';
    $oPuestos2->id_puesto = $sesion->puesto;
    $lstpuestos2 = $oPuestos2->Listado();
    $oDepartamentos->id = $lstpuestos2[0]->id_departamento;
}
$lstDepartamentos = $oDepartamentos->Listado();

$oUsuarios = new Usuarios();
$oUsuarios->id = $sesion->id;
$oUsuarios->Informacion();

$oPuestos = new puestos();
$oPuestos->form = '1';
if ($sesion->nvl_usuario > 1) {
    $oPuestos->id_puesto = $sesion->puesto;
}
$lstpuestos = $oPuestos->Listado();

$aPuestos = empty($oDocumentacion->id_puesto) ? array() : explode("@", $oDocumentacion->id_puesto);
?>
<script type="text/javascript">
    $(document).ready(function(e) {
        $('#id_tipo_documento').change(changeTipoDocumento);
        $('#id_departamento').change(changeDepartamento);
        $("#nameModal_").text("<?php echo $nombre ?> Documentación");
        $("#frmFormulario_").ajaxForm({
            beforeSubmit: function(formData, jqForm, options) {},
            success: function(data) {
                var str = data;
                var datos0 = str.split("@")[0];
                var datos1 = str.split("@")[1];
                var datos2 = str.split("@")[2];
                if (datos0.includes('Base de Datos')) {
                    datos0 = "Sistema";
                }
                if ((datos3 = str.split("@")[3]) === undefined) {
                    datos3 = "";
                } else {
                    datos3 = str.split("@")[3];
                }
                Alert(datos0, datos1 + "" + datos3, datos2);
                Listado();
                $("#myModal").modal("hide");
            }
        });

        $("#btnQuitarWord").button().click(function(e) {
            if (confirm("Esta seguro de quitar la foto?") === false)
                return;

            var jsonDatos = {
                "id": $("#id").val(),
                "campo": "url_word",
                "accion": "QUITAR"
            };
            $.ajax({
                data: jsonDatos,
                type: "post",
                url: "app/views/default/modules/modulos/documentacion/m.documentacion.procesa.php",
                beforeSend: function() {},
                success: function(data) {
                    var str = data;
                    var datos0 = str.split("@")[0];
                    var datos1 = str.split("@")[1];
                    var datos2 = str.split("@")[2];
                    if (datos0.includes('Base de Datos')) {
                        datos0 = "Sistema";
                    }
                    if ((datos3 = str.split("@")[3]) === undefined) {
                        datos3 = "";
                    } else {
                        datos3 = str.split("@")[3];
                    }
                    Alert(datos0, datos1 + "" + datos3, datos2);
                    Listado();
                    $("#myModal_nominas").modal("hide");
                }
            });
        });

        $("#btnQuitarPdf").button().click(function(e) {
            if (confirm("Esta seguro de quitar la foto?") === false)
                return;

            var jsonDatos = {
                "id": $("#id").val(),
                "campo": "url_pdf",
                "accion": "QUITAR"
            };
            $.ajax({
                data: jsonDatos,
                type: "post",
                url: "app/views/default/modules/modulos/documentacion/m.documentacion.procesa.php",
                beforeSend: function() {},
                success: function(data) {
                    var str = data;
                    var datos0 = str.split("@")[0];
                    var datos1 = str.split("@")[1];
                    var datos2 = str.split("@")[2];
                    if (datos0.includes('Base de Datos')) {
                        datos0 = "Sistema";
                    }
                    if ((datos3 = str.split("@")[3]) === undefined) {
                        datos3 = "";
                    } else {
                        datos3 = str.split("@")[3];
                    }
                    Alert(datos0, datos1 + "" + datos3, datos2);
                    Listado();
                    $("#myModal_nominas").modal("hide");
                }
            });
        });
        $('.js-example-basic-multiple').select2();
    });

    function changeTipoDocumento(datos) {
        if ($("#id_tipo_documento").val() > 0) {
            verInfoDoc(<?php echo json_encode($lstDocumento); ?>);
        }
    }

    function changeDepartamento(datos) {
        if ($("#id_departamento").val() > 0) {
            verInfoDep(<?php echo json_encode($lstDepartamentos); ?>);
        }
    }

    function verInfoDoc(datos) {
        let n = 0;
        let x = datos.length;
        while (n < datos.length) {
            if ($("#id_tipo_documento").val() == datos[n].id) {
                $("#clave-doc").val(datos[n].clave);
            }
            n++;
        }
    }

    function verInfoDep(datos) {
        let n = 0;
        let x = datos.length;
        while (n < datos.length) {
            if ($("#id_departamento").val() == datos[n].id) {
                $("#clave-dep").val(datos[n].clave);
            }
            n++;
        }
    }

    $(".change").change(function() {
        if ($("#clave-doc").val() != "" && $("#clave-dep").val() != "") {

            let val = $("#clave-doc").val() + "-" + $("#clave-dep").val();
            var jsonDatos = {
                "clave": val,
                "accion": "CLAVE"
            };

            $.ajax({
                data: jsonDatos,
                type: "post",
                url: "app/views/default/modules/modulos/documentacion/m.documentacion.procesa.php",
                beforeSend: function() {},
                success: function(data) {
                    console.log(data.length);
                    if (data.length == 1) {
                        data = "-00" + (parseFloat(data) + 1);
                    } else if (data.length == 2) {
                        data = "-0" + (parseFloat(data) + 1);
                    } else if (data.length == 3) {
                        data = "-" + (parseFloat(data) + 1);
                    }

                    $("#clave_calidad").val(val + data);
                }
            });
        }
    });


    if ($("#url_word").val() == "") {
        $("#btnQuitarWord").hide();
        $("#imgWord").css("display", "none");
        $("#archivo_word").css("display", "inline");
    } else {
        $("#btnQuitarWord").show();
        $("#imgWord").css("display", "inline");
        $("#archivo_word").css("display", "none");
    }

    if ($("#url_pdf").val() == "") {
        $("#btnQuitarPdf").hide();
        $("#imgPdf").css("display", "none");
        $("#archivo_pdf").css("display", "inline");
    } else {
        $("#btnQuitarPdf").show();
        $("#imgPdf").css("display", "inline");
        $("#archivo_pdf").css("display", "none");
    }
</script>
<form id="frmFormulario_" name="frmFormulario_" action="app/views/default/modules/modulos/documentacion/m.documentacion.procesa.php" enctype="multipart/form-data" method="post" target="_self" class="form-horizontal">
    <div>
        <div class="card-header py-3" style="text-align:left">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <strong class="">Fecha de Creación:</strong>
                        <div class="form-group">
                            <input type="date" aria-describedby="" description="Seleccione fecha de creación" id="fecha_creacion" value="<?= $oDocumentacion->fecha_creacion; ?>" required="" name="fecha_creacion" class="form-control ">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <strong class="">Estatus del Documento:</strong>
                        <div class="form-group">
                            <select id="id_estatus" description="Seleccione el estatus del documento" class="form-control obligado" name="id_estatus">
                                <?php
                                if (count($lstEstatus_documento) > 0) {
                                    echo "<option value='0' >-- SELECCIONE --</option>\n";
                                    foreach ($lstEstatus_documento as $idx => $campo) {
                                        if ($campo->id == $oDocumentacion->id_estatus) {
                                            echo "<option value='{$campo->id}' selected>{$campo->nombre}</option>\n";
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
                        <strong class="">Proceso:</strong>
                        <div class="form-group">
                            <select id="id_proceso" description="Seleccione el proceso" class="form-control obligado" name="id_proceso">
                                <?php
                                if (count($lstProceso) > 0) {
                                    echo "<option value='0' >-- SELECCIONE --</option>\n";
                                    foreach ($lstProceso as $idx => $campo) {
                                        if ($campo->id == $oDocumentacion->id_proceso) {
                                            echo "<option value='{$campo->id}' selected>{$campo->nombre}</option>\n";
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

            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <strong class="">Tipo de documento:</strong>
                        <div class="form-group">
                            <select id="id_tipo_documento" description="Seleccione el tipo de documento" class="form-control obligado change" onChange="changeTipoDocumento" name="id_tipo_documento">
                                <?php
                                if (count($lstDocumento) > 0) {
                                    echo "<option value='0' >-- SELECCIONE --</option>\n";
                                    foreach ($lstDocumento as $idx => $campo) {
                                        if ($campo->id == $oDocumentacion->id_tipo_documento) {
                                            echo "<option value='{$campo->id}' selected>{$campo->nombre}</option>\n";
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
                        <strong class="">Area/departamento:</strong>
                        <div class="form-group">
                            <select id="id_departamento" description="Seleccione el departamento" class="form-control obligado change" onChange="changeDepartamento" name="id_departamento">
                                <?php
                                if (count($lstDepartamentos) > 0) {
                                    echo "<option value='0' >-- SELECCIONE --</option>\n";
                                    foreach ($lstDepartamentos as $idx => $campo) {
                                        if ($campo->id == $oDocumentacion->id_departamento) {
                                            echo "<option value='{$campo->id}' selected>{$campo->nombre}</option>\n";
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
                        <strong class="">Puesto:</strong>
                        <div class="form-group">
                            <select id="id_puesto" description="Seleccione el puesto" class="form-control obligado js-example-basic-multiple" name="id_puesto[]" multiple="multiple">
                                <?php
                                if (count($lstpuestos) > 0) {
                                    echo "<option value='0' >-- TODOS --</option>\n";
                                    foreach ($lstpuestos as $idx => $campo) {
                                        if ($oDocumentacion->ExistePermiso($campo->id, $aPuestos) === true) {
                                            echo "<option value='{$campo->id}' selected>{$campo->nombre}</option>\n";
                                        } else {
                                            echo "<option value='{$campo->id}'>{$campo->nombre}</option>\n";
                                        }
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
                        <strong class="">Clave de Calidad:</strong>
                        <div class="form-group">
                            <input type="text" readonly description="" style="text-transform:uppercase;" aria-describedby="" id="clave_calidad" name="clave_calidad" value="<?= $oDocumentacion->clave_calidad ?>" class="form-control ">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <strong class="">Nombre:</strong>
                        <div class="form-group">
                            <input type="text" description="Ingrese el nombre" aria-describedby="" id="nombre" name="nombre" value="<?= $oDocumentacion->nombre ?>" class="form-control obligado">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Documento para edicion (word)</label>
                        <div class="col-sm-2">
                            <input type="file" id="archivo_word" name="archivo_word" value="<?= $oDocumentacion->url_word ?>" /><br />
                            <a class="btn btn-outline-sm" style="width:33%" id="imgWord" href="<?= $oDocumentacion->url_word ?>"><img src="app/views/default/img/word.png" data-toggle="tooltip" title="" data-original-title="Word"> </a>
                            <input type="button" id="btnQuitarWord" name="btnQuitarWord" value="Quitar" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Documento de lectura (PDF)</label>
                        <div class="col-sm-2">
                            <input type="file" id="archivo_pdf" name="archivo_pdf" value="" /><br />
                            <a class="btn btn-outline-sm" style="width:33%" id="imgPdf" href="<?= $oDocumentacion->url_pdf ?>"><img src="app/views/default/img/file_pdf.png" data-toggle="tooltip" title="" data-original-title="PDF"> </a>
                            <input type="button" id="btnQuitarPdf" name="btnQuitarPdf" value="Quitar" class="form-control" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <strong class="">Comentarios:</strong>
                        <div class="form-group">
                            <textarea id="comentarios" name="comentarios" class="form-control" rows="5" cols="20"><?= $oDocumentacion->comentarios ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="id" name="id" value="<?= $oDocumentacion->id ?>" />
        <input type="hidden" id="user_id" name="user_id" value="<?= $sesion->id ?>">
        <input type="hidden" id="url_word" name="url_word" value="<?= $oDocumentacion->url_word ?>" />
        <input type="hidden" id="url_pdf" name="url_pdf" value="<?= $oDocumentacion->url_pdf ?>" />
        <input type="hidden" id="clave-doc" name="clave-doc" value="" />
        <input type="hidden" id="clave-dep" name="clave-dep" value="" />
        <input type="hidden" id="accion" name="accion" value="GUARDAR" />
    </div>
</form>