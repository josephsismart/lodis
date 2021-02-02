<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Bootstrap 4 -->

<script src="<?= base_url() ?>assets/plugins/ol3/ol.js"></script>
<script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables/extensions/responsive/js/dataTables.responsive.min.js"></script>
<!-- Select2 -->
<script src="<?= base_url() ?>assets/plugins/select2/js/select2.full.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url() ?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?= base_url() ?>assets/plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>
<script type="text/javascript">
    var validatorC=0;
	$('.select2').select2({
        // allowClear: true
    });

    function clear_form(form_id) {
        $("#"+form_id)[0].reset();
        $("#"+form_id).find("input[type='hidden']").each(function() {
            $(this).val("");
        });
        $("#"+form_id).find("input[type='checkbox']").each(function() {
            $(this).attr("checked", false);
        });
        $(".select2").trigger("change");
    }

    function validate_form(form_id) {
        $("#"+form_id).find("input").each(function() {
            var name = $(this).attr("name");
            if((name!="middleName") && (name!="travelHistory") && (name!="dateArrival") && (name!="remarksCOVID") && (name!="whereaboutsCOVID") && (name!="dateRDT") && (name!="datePCR")){
                if(!$(this).val()){
                    validatorC=0;
                    $(this).focus().addClass("is-invalid");
                } else{
                    validatorC=1;
                    $(this).removeClass("is-invalid");
                }
            }
        });

        if($("#"+form_id+" input[name=travelHistory]").val()!="" && !$("#"+form_id+" input[name=dateArrival]").val()){
            validatorC=0;
            $("#"+form_id+" input[name=dateArrival]").focus().addClass("is-invalid");
        } else{
            validatorC=1;
            $("#"+form_id+" input[name=dateArrival]").removeClass("is-invalid");
        }

        if($("#"+form_id+" select[name=categoryCOVID]").val()==44 && !$("#"+form_id+" select[name=specifyOffice]").val()){
            validatorC=0;
            $("#"+form_id+" select[name=specifyOffice]").focus().next().find('.select2-selection').addClass('has-error');
        } else{
            validatorC=1;
            $("#"+form_id+" select[name=specifyOffice]").next().find('.select2-selection').removeClass('has-error');
        }

        if($("#"+form_id+" select[name=categoryCOVID]").val()==45 && !$("#"+form_id+" input[name=specifyAgency]").val()){
            validatorC=0;
            $("#"+form_id+" input[name=specifyAgency]").focus().addClass("is-invalid");
        } else{
            validatorC=1;
            $("#"+form_id+" input[name=specifyAgency]").removeClass("is-invalid");
        }
        
    }

    var invalidChars = [
          "-",
          "+",
          "e",
        ];

	$('#form_save_local').on('focus', 'input[type=number]', function (e) {
	  $(this).on("keydown", function (e) {
	    if (invalidChars.includes(e.key)) {
	        e.preventDefault();
	      }
	  })
	})

    const Toast = Swal.mixin({
      	toast: true,
      	position: 'center',
      	showConfirmButton: false,
      	timer: 3000
    });

    function successAlert(a){
        Toast.fire({
            type: 'success',
            title: '  '+a
        })
    }

    function failAlert(a){
        Toast.fire({
            type: 'error',
            title: '  '+a
        })
    }

    function existAlert(a){
        Toast.fire({
            type: 'warning',
            title: '  '+a
        })
    }

    function noData(a){
        Toast.fire({
            type: 'warning',
            title: '  '+a,
        })
    }
</script>