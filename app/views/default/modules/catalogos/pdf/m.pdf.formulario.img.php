<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/pdf.class.php");
require_once($_SITE_PATH . "/app/model/img.class.php");

$oImg = new pdf_image();
$oImg->id_image = addslashes(filter_input(INPUT_POST, "id_image"));
$nombre = addslashes(filter_input(INPUT_POST, "nombre"));
$sesion = $_SESSION[$oImg->NombreSesion];

$oPdf = new pdf();
$oPdf->Informacion();
$lstPdf = $oPdf->listado();

?>
<script type="text/javascript">
    $(document).ready(function(e) {
        $("#nameModal_img").text("<?php echo $nombre ?> a PDF");
        $("#frmFormulario_img").ajaxForm({
            beforeSubmit: function(formData, jqForm, options) {},
            success: function(data) {
                var str = data;
                var datos0 = str.split("@")[0];
                var datos1 = str.split("@")[1];
                var datos2 = str.split("@")[2];
                if ((datos3 = str.split("@")[3]) === undefined) {
                    datos3 = "";
                } else {
                    datos3 = str.split("@")[3];
                }
                Alert(datos0, datos1 + "" + datos3, datos2);
                Listado();
                $("#myModal_img").modal("hide");
            }
        });
        $('#id_main_pdf_').select2({ width: '100%' });


        $("#btnQuitarFoto").button().click(function(e) {
        if (confirm("Esta seguro de quitar la foto?") === false)
            return;

        var jsonDatos = {
            "id_index": 1,
            "val1": "logo",
            "accion": "QUITAR"
        };
        $.ajax({
            data: jsonDatos,
            type: "post",
            url: "app/views/default/modules/formato/cabecera/m.cabecera.procesa.php",
            beforeSend: function() {},
            success: function(data) {
                var str = data;
                var datos0 = str.split("@")[0];
                var datos1 = str.split("@")[1];
                var datos2 = str.split("@")[2];
                if ((datos3 = str.split("@")[3]) === undefined) {
                    datos3 = "";
                } else {
                    datos3 = str.split("@")[3];
                }
                Alert(datos0, datos1 + "  " + datos3, datos2);
                setTimeout(function() {
                    location.reload(); //actualizas el div
                }, 1000);
            }
        });
    });
    if ($("#url_image").val() == "") {
        $("#btnQuitarFoto").hide();
        $("#imgFoto").css("display", "none");
        $("#foto").css("display", "inline");
    } else {
        $("#btnQuitarFoto").show();
        $("#imgFoto").css("display", "inline");
        $("#foto").css("display", "none");
    }
    });
</script>
<form id="frmFormulario_img" name="frmFormulario_img" action="app/views/default/modules/catalogos/pdf/m.pdf.procesa.php" enctype="multipart/form-data" method="post" target="_self" class="form-horizontal">
    <div>
        <div class="form-group">
            <strong class="">Departamento:</strong>
            <div class="form-group">
                <select id="id_main_pdf_" description="Seleccione el departamneto" class="form-control obligado" name="id_main_pdf">
                    <?php
                    if (count($lstPdf) > 0) {
                        echo "<option value='0' >-- SELECCIONE --</option>\n";
                        foreach ($lstPdf as $idx => $campo) {
                            echo "<option value='{$campo->id_pdf}' >{$campo->name_pdf}</option>\n";
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Imagen:</label>
            <div class="col-sm-2">
                <input type="file" id="foto" name="foto" value="" />
                <img id="imgFoto" name="imgFoto" src="<?= $oImg->url_image ?>"
                    class="img-fluid px-3 px-sm-4 mt-3 mb-4" /><br />
                <input type="button" id="btnQuitarFoto" name="btnQuitarFoto"
                    value="Quitar" class="form-control" />
            </div>
        </div>
        <input type="hidden" id="id_image" name="id_image" value="<?= $oPdf->id_image ?>" />
        <input type="hidden" id="user_id" name="user_id" value="<?= $sesion->id ?>">
        <input type="hidden" id="accion" name="accion" value="img" />
        <input type="hidden" id="url_image" name="url_image" value="<?= $oImg->url_image ?>" />
    </div>
</form>