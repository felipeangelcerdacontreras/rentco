<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/pdf.class.php");
require_once($_SITE_PATH . "/app/model/txt.class.php");

$oTxt = new pdf_text();
$oTxt->id_text = addslashes(filter_input(INPUT_POST, "id_text"));
$nombre = addslashes(filter_input(INPUT_POST, "nombre"));
$sesion = $_SESSION[$oTxt->NombreSesion];
$oTxt->Informacion();

$oPdf = new pdf();
$lstPdf = $oPdf->Listado();

?>
<script type="text/javascript">
    $(document).ready(function(e) {
        $("#nameModal_txt").text("<?php echo $nombre ?> a PDF");
        $("#frmFormulario_txt").ajaxForm({
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
                $("#myModal_txt").modal("hide");
            }
        });
        $('#id_main_pdf').select2({ width: '100%' }); 
    });
    
</script>
<form id="frmFormulario_txt" name="frmFormulario_txt" action="app/views/default/modules/catalogos/pdf/m.pdf.procesa.php" enctype="multipart/form-data" method="post" target="_self" class="form-horizontal">
    <div>
    <div class="form-group">
            <strong class="">Departamento:</strong>
            <div class="form-group">
                <select id="id_main_pdf" description="Seleccione el departamneto" class="form-control obligado" name="id_main_pdf">
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
            <strong class="">Texto:</strong>
            <div class="form-group">
                <textarea  description="Ingrese texto" id="texto_text" required name="texto_text"rows="10" cols="50" class="form-control obligado"><?= $oTxt->texto_text ?></textarea >
            </div>
        </div>
        <input type="hidden" id="id_texto" name="id_text" value="<?= $oTxt->id_text ?>" />
        <input type="hidden" id="user_id" name="user_id" value="<?= $sesion->id ?>">
        <input type="hidden" id="accion" name="accion" value="txt" />
    </div>
</form>