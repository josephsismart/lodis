<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php

    require_once APPPATH."../assets/plugins/pusher/vendor/autoload.php";

    $options = array(
        'cluster' => 'ap1',
        'useTLS' => true
    );
    $pusher = new Pusher\Pusher(
        '0d0d42f80316138d0590',
        'afba59a43d0acbe26a7c',
        '787487',
        $options
    );

    $data['message'] = "ffff";
    $pusher->trigger('my-channel', 'my-event', $data);
?>

<!-- jQuery -->
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>
<!-- <script src="<?= base_url() ?>assets/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/PACE/pace.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/select2/dist/js/select2.full.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/DataTables/DataTables-1.10.18/js/dataTables.bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/DataTables/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/DataTables/extensions/responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/fastclick/lib/fastclick.js"></script>
<script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>
<script src="<?= base_url() ?>assets/dist/js/notify.js"></script>
<script src="<?= base_url() ?>assets/plugins/iCheck/icheck.min.js"></script>
<script src="<?= base_url() ?>assets/jquery/dist/jquery.form.min.js"></script>
<script src="<?= base_url() ?>assets/dist/js/demo.js"></script>
<script src="<?= base_url() ?>assets/plugins/pusher/vendor/pusher.min.js"></script> -->

<script type="text/javascript">
    $.notify.defaults({className:"success",position:"top center"});
    $(document).ajaxStart(function() { Pace.restart(); });
    $('.select2').select2({
        placeholder: "SELECT",
        allowClear: true
    });
    badge_realtime();
    Pusher.logToConsole = true;
    

    function badge_realtime(){
        <?php
        foreach ($this->db->query("SELECT COUNT(1) pending FROM requestdetail WHERE statusId='REQ_STAT_PENDING'")->result() as $key => $value) {
            ?>$("#badge_pending").text("<?= number_format($value->pending);?>");<?php
        } ?>
    }

    var del_id,del_url,del_tblid,del_codeid;

    function delete_this(url_delete, id, tbl_id, codeId){
        $("#modal-delete-code").text(codeId);
        del_id=id;
        del_url=url_delete;
        del_tblid=tbl_id;
        del_codeid=codeId;
    }

    $("#confirm_delete").click(function(){
        $.post("<?= base_url() ?>" + del_url, 
            { del_id }, 
            function(data) {
                var d = JSON.parse(data);
                if (d.success == true) {
                    // for(var x=0; x < del_tbl_id.length; x++) {
                    //     del_tbl_id[x].ajax.reload();
                    // }
                    $('#'+del_tblid).DataTable().ajax.reload();
                    $.notify("Code #: "+del_codeid+" Successfully Deleted");
                }
                // new PNotify({
                //     title: 'Delete',
                //     text: d.msg,
                //     addclass: 'stack-top-right bg-slate',
                //     buttons: {
                //         closer_hover: false,
                //         sticker_hover: false
                //     }
                // });
        });
    });

    function clear_form(form_id) {
        $("#"+form_id)[0].reset();
        $("#"+form_id).find("input[type='hidden']").each(function() {
            $(this).val("");
        });
        $("#"+form_id).find("input[type='checkbox']").each(function() {
            $(this).attr("checked", false);
        });
        $(".select2").val("").trigger("change");
    }
    

</script>