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
    var confirmP="";
    var rmvP="";
    var refrmvP="";
    var stq="";
    var pwd = "";
    var entryId=0;

    var validatorC=0;
	$('.select2').select2({
        // allowClear: true
    });

    function confirm(){
        if(confirmP=="status"){
            batch_status();
        }
        if(confirmP=="test"){
            batch_test();
        }
        if(confirmP=="qstatus"){
            batch_qstatus();
        }
        if(confirmP=="merge"){
            batch_merge();
        }
        if(confirmP=="stq"){
            batch_rmv();
        }
    }

    function showMdl(a){
        var c = $("#modal_selected_person_merge input:radio:checked").length;
        if(a=="merge" && c<1){
            existAlert("Please Select Person!");
        }else{
            $('#confirmUser').modal('show');
            confirmP=a;
            setTimeout(function(){
                $("#confirmPassword").focus();
            },500);
        }
    }

    function rmvHistory(a,b,c){
        rmvP=a;
        stq=b;
        refrmvP=c;
        confirmP="stq";
        $('#confirmUser').modal('show');
        setTimeout(function(){
            $("#confirmPassword").focus();
        },500);
    }

    function hideConf(){
        $("#confirmPassword").val("");
        $('#confirmUser').modal('hide');
    }

    function clear_form(form_id) {
        $("#"+form_id)[0].reset();
        $("#"+form_id).find("input[type='hidden']").each(function() {
            $(this).val("");
        });
        $("#"+form_id).find("input[type='checkbox']").each(function() {
            $(this).attr("checked", false);
        });
        $(".select2,.select3,.select4,.select5,.select6,.select7,.select8").trigger("change");
    }

    $(".checkbox-toggle").click(function () {
        var prop = $(this).prop("checked");
        if (prop==true) {
          $(".table-data-checkbox input[type='checkbox']").prop("checked", true);
        } else {
          $(".table-data-checkbox input[type='checkbox']").prop("checked", false);
        }
    });

    $("#form_person .checkbox-toggle1").click(function () {
        var prop = $(this).prop("checked");
        if (prop==true) {
          $("#form_person .table-data-checkbox input[type='checkbox']").prop("checked", true);
        } else {
          $("#form_person .table-data-checkbox input[type='checkbox']").prop("checked", false);
        }
    });

    $("#form_person_exist .checkbox-toggle2").click(function () {
        var prop = $(this).prop("checked");
        if (prop==true) {
          $("#form_person_exist .table-data-checkbox input[type='checkbox']").prop("checked", true);
        } else {
          $("#form_person_exist .table-data-checkbox input[type='checkbox']").prop("checked", false);
        }
    });

    $('#confirmPassword').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            // $(".confirmPassword_btn").attr("disabled", true);
            // $(".confirmPassword_btn").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
            confirm();
        }
    });

    function getDetails(a,b){
        hideUpdate();
        $("."+a+"_cncl").show();
        $(".submitBtnPrimary").html("<span class=\"fa fa-check\"></span> Update Data");
        $.each(b, function(k, v) {
            $("#"+a).each(function() {
                $("[name='"+k+"']").val(v);
                $(".select2").trigger("change");
                // $("[name='"+k+"']").val(v);
                if(k=="categoryCOVID"){
                    specify(v);
                }
                // if(k=="BRSections"){
                //   var items = v.split(',');
                //   $("#BRSections").select2().val(items);
                //   $("#BRSections").select2().trigger('change');
                // }
                // if(k=="ACCPersonnel"){
                //   // var items = v.split(',');
                //   $("#ACCPersonnel").select2().val(v);
                //   $("#ACCPersonnel").select2().trigger('change');
                // }
            });
        });
    }

    function cancelBtn(a){
        $("."+a+"_cncl").hide();
        clear_form(a);
        showUpdate();
        $(".submitBtnPrimary").html("<span class=\"fa fa-check\"></span> Save Data");
    }

    function hideUpdate(){
        $(".update_test,.update_contact,.update_status,.update_qstatus").slideUp();
    }

    function showUpdate(){
        $(".update_test,.update_contact,.update_status,.update_qstatus").slideDown();
    }

    function uncheckMother(){
        $(".checkbox-toggle,.checkbox-toggle1,.checkbox-toggle2").prop("checked",false);
    }

    function validate_form(form_id) {
        $("#"+form_id).find("input").each(function() {
            var name = $(this).attr("name");
            if((name!="contactCodePerson") && (name!="personCode") && (name!="middleName") && (name!="travelHistory") && (name!="dateArrival") && (name!="remarksCOVID") && (name!="whereaboutsCOVID") && (name!="dateRDT") && (name!="datePCR")){
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

        if($("#"+form_id+" select[name=contactCode]").val()!="" && !$("#"+form_id+" select[name=relation]").val()){
            validatorC=0;
            $("#"+form_id+" select[name=relation]").focus().next().find('.select2-selection').addClass('has-error');
        } else{
            validatorC=1;
            $("#"+form_id+" select[name=relation]").next().find('.select2-selection').removeClass('has-error');
        }

        if($("#"+form_id+" select[name=resultRDT]").val()!="" && !$("#"+form_id+" input[name=dateRDT]").val()){
            validatorC=0;
            $("#"+form_id+" input[name=dateRDT]").focus().addClass("is-invalid");
        } else{
            validatorC=1;
            $("#"+form_id+" input[name=dateRDT]").removeClass("is-invalid");
        }

        if($("#"+form_id+" select[name=resultPCR]").val()!="" && !$("#"+form_id+" input[name=datePCR]").val()){
            validatorC=0;
            $("#"+form_id+" input[name=datePCR]").focus().addClass("is-invalid");
        } else{
            validatorC=1;
            $("#"+form_id+" input[name=datePCR]").removeClass("is-invalid");
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

    function validate_form2(table_id,modal_id) {
        $("#"+modal_id+" #modal_selected_person").empty();
        var c = $("#"+table_id+' input:checkbox:checked').length;
        if(c<1){
            existAlert("Please Select Person!");
        }else if(modal_id!="batch_merge"){
            if(!$("#"+table_id).find('input[type="checkbox"]:checked').each(function () {
                $("#"+modal_id).modal("show");
                $("#"+modal_id+" #modal_selected_person").append("<span class='badge bg-navy m-1' style='font-size:10px;'>"+$(this).next('label').text()+"</span>");
            }));
        }else if(modal_id=="batch_merge"){
            $("#"+modal_id+" #modal_selected_person_merge tbody").empty();
            if(c<2){
                existAlert("Please Select atleast 2 Person!");
            }else if(c>1){
                if(!$("#"+table_id).find('input[type="checkbox"]:checked').each(function () {
                    if(!$(this).next('label').text()){}else{
                        $("#"+modal_id).modal("show");
                        $("#"+modal_id+" #modal_selected_person_merge tbody").append("<tr><td>"+
                                            "<div class='custom-control custom-radio ml-1'>"+
                                                "<input class='custom-control-input radio-toggle' type='radio' id='SelectMerge"+$(this).val()+"' name='SelectMerge' value='"+$(this).val()+"'>"+
                                                "<label for='SelectMerge"+$(this).val()+"' class='custom-control-label' style='cursor:pointer;'></label>"+
                                            "</div></td>"+
                                "<td class=''>"+$(this).next('label').text()+"</td></tr>");
                    }
                }));
            }
        }
        checkChcked(modal_id);
    }

    $(".clickMeToHideContact").trigger("click");

    $(".clickMeToHideContact").click(function(){
        if($(".clickMeToHideContact .fas").hasClass("fa-minus")==true){
            $("#myContact").slideDown();
        }else{
            $("#myContact").slideUp();
        }
    });

    function checkChcked(modal){
        setTimeout(function(){
            if($('#'+modal).is(':visible')==false){
                checkAlert();
            }    
        },500);
    }

    $('#graphPresentation').on('hidden.bs.modal', function (e) {
        if($(".clickMeToHideContact .fas").hasClass("fa-minus")==true){
            $(".clickMeToHideContact").trigger("click");
        }
    })

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

    function printForm(a,b,c){
        var orientation = (b=='p'?'portrait':'landscape');
        var margin = (c=='Legal'?'margin:5mm 5mm 5mm 5mm;':'margin:5mm 5mm 5mm 5mm;');
        var windowUrl = 'Print Form';
        var uniqueName = new Date();
        var windowName = 'emailSection' + uniqueName.getTime();
        var accompWindow = window.open('height=1500,width=2000');
        accompWindow.document.write('<html>');
        accompWindow.document.write('<head>');
        accompWindow.document.write('<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">'+
                                    '<link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/adminlte.min.css">');
        accompWindow.document.write('</head>');
        accompWindow.document.write('<style> @page { size: '+c+' '+orientation+';'+margin+'} .square {height: 100px;width: 100px;border:1px solid black; } </style>');
        accompWindow.document.write('<body>'+$("#"+a).html()+'</body>');
        accompWindow.document.write('</html>');
        setTimeout(function(){
            accompWindow.print();
            accompWindow.close();
        },1000);
    }
</script>