<?php
/*
 * Copyright 2022 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/pdf.class.php");

$oPdf = new pdf();
$oPdf->id_pdf = addslashes(filter_input(INPUT_POST, "id_pdf"));
$nombre = addslashes(filter_input(INPUT_POST, "nombre"));
$lstpdf = $oPdf->ListadoPdf();
?>
<style>
td:hover {
    cursor: move;
}
</style>
<script>
$(document).ready(function(e) {
    $("#btnOrden").button().click(function(e) {
        $("#frmFormulario1").submit();
    });

    $("#frmFormulario1").ajaxForm({
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
            Alert(datos0, datos1 + "  " + datos3, datos2);
            Listado();
        }
    });

    $("#dataTable_").DataTable({
        pageLength : 100,
        lengthMenu: [[100, -1], [100, 'Todos']]
    });

    $('.dataTables_length').addClass('bs-select');

    var fixHelperModified = function(e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function(index) {
                $(this).width($originals.eq(index).width())
            });
            return $helper;
        },
        updateIndex = function(e, ui) {
            $('td.index', ui.item.parent()).each(function(i) {
                $(this).html(i + 1);
            });
            $('input[type=text]', ui.item.parent()).each(function(i) {
                $(this).val(i + 1);
            });
        };
    $("#dataTable_ tbody").sortable({
        helper: fixHelperModified,
        stop: updateIndex
    }).disableSelection();

    $("tbody").sortable({
        distance: 5,
        delay: 100,
        opacity: 0.6,
        cursor: 'move',
        update: function() {}
    });

    $("#btnAgregar").button().click(function(e) {
        Editar("");
    });
});
</script>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3" style="text-align:left">
        <h5 class="m-0 font-weight-bold text-primary">pdf</h5>
        <div class="form-group" style="text-align:right">
        </div>
    </div>
    <div class="card-body">
    <div class="table-responsive">
            <form id="frmFormulario1" name="frmFormulario1"
                action="app/views/default/modules/catalogos/pdf/m.pdf.procesa.php" method="post"
                class="form-horizontal">
            <table class="table table-bordered" id="dataTable_" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nombre</th>
                        <th>Estatus</th>
                        <th hidden>orden</th>
                    </tr>
                </thead>
                <tfoot>
                    <th></th>
                    <th>Nombre</th>
                    <th>Estatus</th>
                    <th hidden>orden</th>
                </tfoot>
                <tbody>
                    <?php
                    if (count($lstpdf) > 0) {
                        $cont = 1;
                        print_r($lstpdf);
                        foreach ($lstpdf as $idx => $campo) {
                    ?>
                        <tr id="<?=$cont?>">
                            <td style="text-align: center;">
                                <div>
                                    <input type="number" hidden name="id_pdf_<?=$cont?>"
                                        id="id_pdf_<?=$cont?>" value="<?=  $campo->id  ?>">
                                    <a href="javascript:Editar('<?= $campo->id ?>');" ;><?= $cont ?></a>
                                </div> 
                            </td>
                            <td style="text-align: center;"><?php 
                                if ($campo->type == "TXT") {
                                    echo $campo->content;
                                } else if ($campo->type == "IMG") {
                                    ?><img src='<?php echo $campo->content; ?>'
                                    border="0" width="15%" /></a>
                                    <?php 
                                }  ?></td>
                            <td style="text-align: center;">
                            <a class="btn btn-outline-sm btn-warning" href="javascript:Editar('<?= $campo->id ?>','<?= $campo->type ?>')">Editar</a>
                            </td>
                            <td class="indexInput" >
                                <input type="text" name="ord_pdf_<?=$cont?>" id="ord_pdf_<?=$cont?>"
                                    value="<?= $cont ?>">
                            </td>
                        </tr>
                    <?php
                    $cont++;
                        }
                    }
                    ?>
                 </tbody>
                </table>
                <div class="modal-footer">
                    <input type="hidden" id="id_pdf" name="id_pdf" value="<?$oPdf->id?>" />
                    <input type="hidden" id="accion" name="accion" value="LISTA" />
                    <input type="button" class="btn btn-success" id="btnOrden" value="Guardar Orden">
                </div>
        </div>
        </form>
    </div>
</div>