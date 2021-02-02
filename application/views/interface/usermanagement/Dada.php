<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="<?= base_url() ?>assets/plugins/Highcharts-8.0.4/code/highcharts.js"></script>
<script src="<?= base_url() ?>assets/plugins/Highcharts-8.0.4/code/modules/sankey.js"></script>
<script src="<?= base_url() ?>assets/plugins/Highcharts-8.0.4/code/modules/organization.js"></script>
<script src="<?= base_url() ?>assets/plugins/Highcharts-8.0.4/code/modules/exporting.js"></script>
<script src="<?= base_url() ?>assets/plugins/Highcharts-8.0.4/code/modules/accessibility.js"></script>
<script src="<?= base_url() ?>assets/plugins/Highcharts-8.0.4/code/modules/export-data.js"></script>
<script src="<?= base_url() ?>assets/plugins/Highcharts-8.0.4/code/modules/drilldown.js"></script>
<script src="<?= base_url() ?>assets/plugins/Highcharts-8.0.4/code/themes/dark-unica.js"></script>
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.form.min.js"></script>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Entry</h1>
      </div>
      <!-- <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Advanced Form</li>
        </ol>
      </div> -->
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- SELECT2 EXAMPLE -->
          
        <div class="col-md-12">
            <div class="card card-lightblue">
              <div class="card-header">
                <h3 class="card-title">Person List
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button> -->
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-body p-2" style="margin-right: 20px;white-space:nowrap; margin-right:0px;">

                <div class="card card-lightblue">
                    <div class="card-header p-2">
                      <h3 class="card-title"><i class="fa fa-search"></i> Data Search and Filter
                      </h3>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-body p-2">
                        <form id="filterData">
                            <div class="row">
                                  <div class="col-md-4 filterDate">
                                        <label>FROM DATE</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <input type="date" value="<?= Date('Y-m-d') ?>" class="form-control" name="fromDate" maxlength="255" aria-required="true">
                                        </div>
                                  </div>
                                  <div class="col-md-4 filterDate">
                                        <label>TO DATE</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <input type="date" value="<?= Date('Y-m-d') ?>" class="form-control" name="toDate" maxlength="255" aria-required="true">
                                        </div>
                                  </div>
                                  <div class="col-md-3 filterTest hidden2">
                                        <label>COVID 19 TEST</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text"><i class="fas fa-virus"></i></span>
                                            </div>
                                            <select class="form-control" name="testCOVIDFilter">
                                              <option value=''>NOT TESTED</option>
                                              <?php foreach ($getStatus['data4'] as $key => $value): ?>
                                                  <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                                              <?php endforeach ?>
                                            </select>
                                        </div>
                                  </div>
                                  <div class="col-md-2 filterTest hidden2">
                                        <label>RESULT</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text"><i class="fas fa-vial"></i></span>
                                            </div>
                                            <select class="form-control" name="resultCOVIDFilter">
                                                <?php foreach ($getStatus['data6'] as $key => $value): ?>
                                                    <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                  </div>
                                  <div class="col-md-5 filterStatus hidden2">
                                        <label>COVID 19 STATUS</label>
                                        <div class="input-group mb-2">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-virus"></i></span>
                                              </div>
                                              <select class="form-control" name="statusCOVIDFilter">
                                                <?php foreach ($getStatus['data1'] as $key => $value): ?>
                                                    <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                                                <?php endforeach ?>
                                              </select>
                                        </div>
                                  </div>
                                  <div class="col-md-5 filterCategory hidden2">
                                        <label>CATEGORY</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                                            </div>
                                            <select class="form-control" name="categoryCOVIDFilter">
                                              <?php foreach ($getStatus['data8'] as $key => $value): ?>
                                                  <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                                              <?php endforeach ?>
                                            </select>
                                        </div>
                                  </div>
                                  <div class="col-md-5 filterQuarantine hidden2">
                                        <label>QUARANTINE STATUS</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text"><i class="fas fa-bed"></i></span>
                                            </div>
                                            <select class="form-control" name="qstatusCOVIDFilter">
                                              <?php foreach ($getStatus['data9'] as $key => $value): ?>
                                                  <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                                              <?php endforeach ?>
                                            </select>
                                        </div>
                                  </div>
                                  <div class="col-md-5 filterCode hidden2">
                                        <label>CODE <small>[JUST LEAVE BLANK TO SEARCH THE "NO CODE" PERSON]</small></label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text"><i class="fas fa-qrcode"></i></span>
                                            </div>
                                            <input type="text" class="form-control text-uppercase" name="personCodeFilter"  placeholder="CODE" autocomplete="off">
                                        </div>
                                  </div>
                                  <div class="col-md-5 filterName hidden2">
                                        <label>NAME</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" class="form-control text-uppercase" name="personNameFilter"  placeholder="LAST NAME / FIRST NAME" autocomplete="off">
                                        </div>
                                  </div>
                                  <div class="col-md-3 filterBarangay hidden2">
                                        <label>BARANGAY</label>
                                        <div class="input-group mb-2" style="width:100%;">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text"><i class="fas fa-home"></i></span>
                                            </div>
                                            <select class="form-control" name="barangayNameFilter">
                                                <option value=''>ALL BARANGAY</option>
                                              <?php foreach ($getBarangay['data1'] as $key => $value): ?>
                                                  <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                                              <?php endforeach ?>
                                            </select>
                                        </div>
                                  </div>

                                  <div class="col-md-4">
                                        <label>FILTER BY:</label>
                                        <div class="input-group mb-2">
                                            <select class="form-control" name="filterSelect" onchange="filter($(this).val());">
                                                <option value='1'>DATE</option>
                                                <!-- <option value='2'>TEST</option> -->
                                                <option value='3'>STATUS</option>
                                                <option value='4'>CATEGORY</option>
                                                <option value='5'>QUARANTINE</option>
                                                <option value='6'>CODE</option>
                                                <option value='7'>NAME</option>
                                            </select>
                                            <div class="input-group-append">
                                              <!-- <span class="input-group-text"><i class="fas fa-bed"></i></span> -->
                                              <button type="button" class="btn btn-warning btn-sm text-white searchBtn" onclick="$('#tbl_person_covid19 tobdy').empty();$('#tbl_person_covid19').DataTable().ajax.reload();$(this).html('<span class=\'fa fa-spinner fa-spin\'></span>');$(this).attr('disabled',true);"><i class="fas fa-search"></i></span></button>
                                            </div>
                                        </div>
                                  </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="table-responsive mailbox-messages">
                  <!-- <form id='form_person'> -->
                    <table id="tbl_person_covid19" style="width:100%;" class="table table-bordered table-hover table-data-checkbox">
                      <thead>
                      <tr>
                        <!-- <th width="1"><div class="custom-control custom-checkbox ml-1">
                                            <input class="custom-control-input checkbox-toggle" type="checkbox" id="CheckAll">
                                            <label for="CheckAll" class="custom-control-label" style="cursor:pointer;"></label>
                                        </div>
                        </th> -->
                        <!-- <th width="1"></th> -->
                        <th width="1">#</th>
                        <th width="1"><i class='fa fa-sitemap'></i></th>
                        <th><i class='fa fa-qrcode'></i> Code</th>
                        <th><i class='fa fa-user'></i> Name</th>
                        <th width="1"><i class='fa fa-virus'></i> Status</th>
                        <th width="1"><i class='fa fa-vial'></i> Test</th>
                        <th width="1"><i class='fa fa-bed'></i> Quarantine</th>
                        <th width="1"><i class='fas fa-list-alt'></i> Category</th>
                        <th width="1"><i class='fa fa-phone'></i></th>
                        <th><i class='fa fa-plane'></i> Travel History</th>
                        <th width="1">Office/Agency</th>
                        <th width="1"><i class='fas fa-sticky-note'></i></th>
                        <th width="1"><i class='fas fa-map-pin'></i></th>
                        <th width="1">Encoded By</th>
                      </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  <!-- </form> -->
                </div>

              </div>
                <!-- /.card-body -->
              <!-- <div class="card-footer">
                <button type="submit" class="btn btn-info submitBtnLocal"><i class="fa fa-check"></i> Save Data</button>
              </div> -->
            </div>
        </div>

    </div>

  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->


<script type="text/javascript">
  var entryId=0;
  var thisData=0;
 

  $(function(){
    //addEntry();
    var tbl_person_covid19, tbl_personCovid19_data;
            tbl_person_covid19 = $("#tbl_person_covid19").DataTable({
                                "order": [[0, "asc" ]],
                                "columnDefs": [ {
                                  "targets"  : [0],
                                  "orderable": false,
                                }],
                                // dom: 'Bfrtip',
                                // buttons: [
                                //     'pageLength', 
                                //     {
                                //         text: "<i class='fa fa-virus'></i> Status",
                                //         action: function(e, dt, node, config) {
                                //             //clear_form("form_assign_personnel");
                                //             validate_form2("tbl_person_covid19","batch_status");
                                //         }
                                //     },{
                                //         text: "<i class='fa fa-vial'></i> Test",
                                //         action: function(e, dt, node, config) {
                                //             //clear_form("form_assign_personnel");
                                //             validate_form2("tbl_person_covid19","batch_test");
                                //         }
                                //     },{
                                //         text: "<i class='fa fa-bed'></i> Quarantine",
                                //         action: function(e, dt, node, config) {
                                //             //clear_form("form_assign_personnel");
                                //             validate_form2("tbl_person_covid19","batch_qstatus");
                                //         }
                                //     },{
                                //         text: "<i class='fa fa-redo-alt'></i>",
                                //         action: function(e, dt, node, config) {
                                //             $('#tbl_person_covid19').DataTable().ajax.reload();
                                //         }
                                //     }
                                // ],
                                "oLanguage": { "sSearch": "" },
                                language: {
                                    searchPlaceholder: "Search...",
                                },
                                "paging": true,
                                "pageLength": 10,
                                "lengthChange": false,
                                "searching": true,
                                "ordering": true,
                                "info": true,
                                "autoWidth": false,
                                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                                ajax: {
                                    url: "<?= base_url('usermanagement/Dataentry/getPersonCovid') ?>",
                                    type: "POST",
                                    data:
                                    function(d) {
                                      d.a=$("#filterData").serialize();
                                      return tbl_personCovid19_data;
                                    }
                                }
                            });

                            $('#tbl_person_covid19').on('draw.dt', function () {
                                $(".searchBtn").attr("disabled", false);
                                $(".searchBtn").html("<span class=\"fa fa-search\"></span>");
                            });
        $("#tbl_person_covid19_filter").addClass("row");
        $("#tbl_person_covid19_filter label").css("width","100%");
        $("#tbl_person_covid19_filter .form-control-sm").css("width","100%");
    
    var save_primary = {
        clearForm: false,
        resetForm: false,
        beforeSubmit: function(e) {
            validate_form("form_save_dataPrimary");
            validatorC==0?e.preventDefault():"";
            $(".submitBtnPrimary").attr("disabled", true);
            $(".submitBtnPrimary").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
        },
        success: function(data) {
            var d = JSON.parse(data);
            if(d.success == true) {
                successAlert();
                clear_form("form_save_dataPrimary");
            } else {
                failAlert();
            }
            $(".submitBtnPrimary").attr("disabled", false);
            $(".submitBtnPrimary").html("Save");
            $(".submitBtnPrimary").html("<span class=\"fa fa-check\"></span> Save Data");
            $('#tbl_person_covid19').DataTable().ajax.reload();
        }
    };
    $("#form_save_dataPrimary").ajaxForm(save_primary);

    var save_contact = {
        clearForm: false,
        resetForm: false,
        beforeSubmit: function(e) {
            validate_form("form_save_dataContact");
            validatorC==0?e.preventDefault():"";
            $(".submitBtnContact").attr("disabled", true);
            $(".submitBtnContact").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
        },
        success: function(data) {
            var d = JSON.parse(data);
            if(d.success == true) {
                successAlert();
                clear_form("form_save_dataContact");

                $('.form_save_dataContact').slideUp();
                $('.form_save_dataPrimary').slideDown();
            } else {
                failAlert();
            }
            $(".submitBtnContact").attr("disabled", false);
            $(".submitBtnContact").html("Save");
            $(".submitBtnContact").html("<span class=\"fa fa-check\"></span> Save Data");
            $('#tbl_person_covid19').DataTable().ajax.reload();
        }
    };
    $("#form_save_dataContact").ajaxForm(save_contact);

    var save_status = {
        clearForm: false,
        resetForm: false,
        beforeSubmit: function(e) {
            validate_form("form_save_dataStatusHistory");
            validatorC==0?e.preventDefault():"";
            $(".submitBtnStatusHistory").attr("disabled", true);
            $(".submitBtnStatusHistory").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
        },
        success: function(data) {
            var d = JSON.parse(data);
            if(d.success == true) {
                successAlert("Successfully Saved!");
                clear_form("form_save_dataStatusHistory");
                $("#statusHistory").modal("hide");

                // $('.form_save_dataStatusHistory').slideUp();
                // $('.form_save_dataPrimary').slideDown();
            } else if(d.exist == true) {
                $("#statusHistoryDateDuplicate").modal("show");
            } else {
                failAlert("Something went wrong!");
            }
            $(".submitBtnStatusHistory").attr("disabled", false);
            $(".submitBtnStatusHistory").html("Save");
            $(".submitBtnStatusHistory").html("<span class=\"fa fa-check\"></span> Save Data");
            $('#tbl_person_covid19').DataTable().ajax.reload();
        }
    };
    $("#form_save_dataStatusHistory").ajaxForm(save_status);

    var save_test = {
        clearForm: false,
        resetForm: false,
        beforeSubmit: function(e) {
            validate_form("form_save_dataTestHistory");
            validatorC==0?e.preventDefault():"";
            $(".submitBtnTestHistory").attr("disabled", true);
            $(".submitBtnTestHistory").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
        },
        success: function(data) {
            var d = JSON.parse(data);
            if(d.success == true) {
                successAlert("Successfully Saved!");
                clear_form("form_save_dataTestHistory");
                $("#testHistory").modal("hide");

                // $('.form_save_dataTestHistory').slideUp();
                // $('.form_save_dataPrimary').slideDown();
            } else if(d.exist == true) {
                $("#testHistoryDateDuplicate").modal("show");
            } else {
                failAlert("Something went wrong!");
            }
            $(".submitBtnTestHistory").attr("disabled", false);
            $(".submitBtnTestHistory").html("Save");
            $(".submitBtnTestHistory").html("<span class=\"fa fa-check\"></span> Save Data");
            $('#tbl_person_covid19').DataTable().ajax.reload();
        }
    };
    $("#form_save_dataTestHistory").ajaxForm(save_test);

    var save_qstatus = {
        clearForm: false,
        resetForm: false,
        beforeSubmit: function(e) {
            validate_form("form_save_dataQStatusHistory");
            $(".submitBtnQStatusHistory").attr("disabled", true);
            $(".submitBtnQStatusHistory").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
        },
        success: function(data) {
            var d = JSON.parse(data);
            if(d.success == true) {
                successAlert("Successfully Saved!");
                clear_form("form_save_dataQStatusHistory");
                $("#qstatusHistory").modal("hide");

                // $('.form_save_dataQStatusHistory').slideUp();
                // $('.form_save_dataPrimary').slideDown();
            } else if(d.exist == true) {
                $("#qstatusHistoryDateDuplicate").modal("show");
            } else {
                failAlert("Something went wrong!");
            }
            $(".submitBtnQStatusHistory").attr("disabled", false);
            $(".submitBtnQStatusHistory").html("Save");
            $(".submitBtnQStatusHistory").html("<span class=\"fa fa-check\"></span> Save Data");
            $('#tbl_person_covid19').DataTable().ajax.reload();
        }
    };
    $("#form_save_dataQStatusHistory").ajaxForm(save_qstatus);

    var save_personCode = {
        clearForm: false,
        resetForm: false,
        beforeSubmit: function(e) {
            validate_form("form_save_dataCodeHistory");
            $(".submitBtnPersonCode").attr("disabled", true);
            $(".submitBtnPersonCode").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
        },
        success: function(data) {
            var d = JSON.parse(data);
            if(d.success == true) {
                successAlert("Successfully Saved!");
                clear_form("form_save_dataCodeHistory");
                $("#codeHistory").modal("hide");
                $('#tbl_person_covid19').DataTable().ajax.reload();
            }else if(d.exist == true){
                existAlert("Test Code already exist!<br/>by: "+d.existPerson);
            } else {
                failAlert("Something went wrong!");
            }
            $(".submitBtnPersonCode").attr("disabled", false);
            $(".submitBtnPersonCode").html("Save");
            $(".submitBtnPersonCode").html("<span class=\"fa fa-check\"></span> Save Data");
        }
    };
    $("#form_save_dataCodeHistory").ajaxForm(save_personCode);

    var save_personContactTrace = {
        clearForm: false,
        resetForm: false,
        beforeSubmit: function(e) {
            validate_form("form_contact_tracing");
            $(".submitBtnContactPerson").attr("disabled", true);
            $(".submitBtnContactPerson").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
        },
        success: function(data) {
            var d = JSON.parse(data);
            if(d.exist == true){
                existAlert(d.person);
            }else if(d.success == true) {
                successAlert("Successfully Saved!");
                clear_form("form_contact_tracing");
                $("#graphPresentation2").modal("hide");
                $('#tbl_person_covid19').DataTable().ajax.reload();
            }else {
                failAlert("Something went wrong!");
            }
            $(".submitBtnContactPerson").attr("disabled", false);
            $(".submitBtnContactPerson").html("<span class=\"fa fa-check\"></span> Save Data");
        }
    };
    $("#form_contact_tracing").ajaxForm(save_personContactTrace);

    var save_personContactTrace2 = {
        clearForm: false,
        resetForm: false,
        beforeSubmit: function(e) {
            validate_form("form_contact_tracing2");
            $(".submitBtnContactPerson2").attr("disabled", true);
            $(".submitBtnContactPerson2").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
        },
        success: function(data) {
            var d = JSON.parse(data);
            if(d.exist == true){
                existAlert(d.person);
            }else if(d.success == true) {
                successAlert("Successfully Saved!");
                clear_form("form_contact_tracing2");
                $("#graphPresentation").modal("hide");
                $('#tbl_person_covid19').DataTable().ajax.reload();
            }else {
                failAlert("Something went wrong!");
            }
            $(".submitBtnContactPerson2").attr("disabled", false);
            $(".submitBtnContactPerson2").html("<span class=\"fa fa-check\"></span> Save Data");
        }
    };
    $("#form_contact_tracing2").ajaxForm(save_personContactTrace2);

    $("#testHistoryDateDuplicate .submitBtnTestHistoryProceed").click(function(){
        $('#form_save_dataTestHistory .proceedTest').val(1);
        $(".submitBtnTestHistory").attr("disabled", false);
        $(".submitBtnTestHistory").trigger("click");
        $("#testHistoryDateDuplicate").modal("hide");
    });

    $("#statusHistoryDateDuplicate .submitBtnStatusHistoryProceed").click(function(){
        $('#form_save_dataStatusHistory .proceedStatus').val(1);
        $(".submitBtnStatusHistory").attr("disabled", false);
        $(".submitBtnStatusHistory").trigger("click");
        $("#statusHistoryDateDuplicate").modal("hide");
    });

    $("#qstatusHistoryDateDuplicate .submitBtnQStatusHistoryProceed").click(function(){
        $('#form_save_dataQStatusHistory .proceedQStatus').val(1);
        $(".submitBtnQStatusHistory").attr("disabled", false);
        $(".submitBtnQStatusHistory").trigger("click");
        $("#qstatusHistoryDateDuplicate").modal("hide");
    });

    //covid19_status();
});

function filter(a){
    hideall();
    if(a==1){
        $(".filterDate").show();
    }else if(a==2){
        $(".filterTest").show();
    }else if(a==3){
        $(".filterStatus").show();
    }else if(a==4){
        $(".filterCategory").show();
    }else if(a==5){
        $(".filterQuarantine").show();
    }else if(a==6){
        $(".filterCode").show();
    }else if(a==7){
        $(".filterName").show();
    }
    if(a==1){
        $(".filterBarangay").hide();
    }else{
        $(".filterBarangay").show();
    }
}

function hideall(){
    $(".filterDate,.filterTest,.filterStatus,.filterCategory,.filterQuarantine,.filterCode,.filterName").hide();
}


function covid19_status(){
    $("#tbl_person_covid19_status tbody").empty();
    var tbl_person_covid19_status, tbl_personCovid19Status_data;
        tbl_person_covid19_status = $("#tbl_person_covid19_status").DataTable({
                            "columnDefs": [ {
                              "orderable": false,
                            }],
                            "paging": false,
                            "pageLength": 10,
                            "lengthChange": false,
                            "searching": false,
                            "ordering": true,
                            "info": false,
                            "autoWidth": true,
                            ajax: {
                                url: "<?= base_url('usermanagement/Dataentry/getPersonCovidStatus') ?>",
                                type: "POST",
                                data:
                                function(d) {
                                  d.personId=$(".personStatusId").val();
                                  return tbl_personCovid19Status_data;
                                }
                            }
                        }).destroy();
                        $('#tbl_person_covid19_status').on('draw.dt', function () {
                            $("#statusHistory").modal("show");
                        });
}

function covid19_test(){
    $("#tbl_person_covid19_test tbody").empty();
    var tbl_person_covid19_test, tbl_personCovid19test_data;
        tbl_person_covid19_test = $("#tbl_person_covid19_test").DataTable({
                            "columnDefs": [ {
                              "orderable": false,
                            }],
                            "paging": false,
                            "pageLength": 10,
                            "lengthChange": false,
                            "searching": false,
                            "ordering": true,
                            "info": false,
                            "autoWidth": true,
                            ajax: {
                                url: "<?= base_url('usermanagement/Dataentry/getPersonCovidTest') ?>",
                                type: "POST",
                                data:
                                function(d) {
                                  d.personId=$(".personTestId").val();
                                  return tbl_personCovid19test_data;
                                }
                            }
                        }).destroy();
                        $('#tbl_person_covid19_test').on('draw.dt', function () {
                            $("#testHistory").modal("show");
                        });
}

function covid19_qstatus(){
    $("#tbl_person_covid19_qstatus tbody").empty();
    var tbl_person_covid19_qstatus, tbl_personCovid19qstatus_data;
        tbl_person_covid19_qstatus = $("#tbl_person_covid19_qstatus").DataTable({
                            "columnDefs": [ {
                              "orderable": false,
                            }],
                            "paging": false,
                            "pageLength": 10,
                            "lengthChange": false,
                            "searching": false,
                            "ordering": true,
                            "info": false,
                            "autoWidth": true,
                            ajax: {
                                url: "<?= base_url('usermanagement/Dataentry/getPersonCovidQStatus') ?>",
                                type: "POST",
                                data:
                                function(d) {
                                  d.personId=$(".personQStatusId").val();
                                  return tbl_personCovid19qstatus_data;
                                }
                            }
                        }).destroy();
                        $('#tbl_person_covid19_qstatus').on('draw.dt', function () {
                            $("#qstatusHistory").modal("show");
                        });
}


    function tfoot(){
      if($('#tbl_entry tr').length>6){
        $('#tbl_entry_foot').show();
      }else{
        $('#tbl_entry_foot').hide();
      }
    }



    function addEntry(){
        entryId=entryId+1;
        $('#tbl_contact_trace tbody').append("<tr id='entry"+entryId+"'>"+
            "<td align='center'><a style='margin-top:5px;cursor:pointer;' class='btn btn-xs btn-danger text-white' onclick='removeEntry(\""+entryId+"\")'><span class='fa fa-times'></span></a></td>"+
            "<td><select type='text' class='form-control select3' name='contactTracePerson[]' id='contactTracePerson"+entryId+"' style='width:100%;'>"+
                    "<option value=''>SELECT CONTACT</option>"+
                    "<?php foreach ($getStatus['data11'] as $key => $value): ?>"+
                        "<option value='<?= $value['id'] ?>' ><?= $value['text'] ?></option>"+
                    "<?php endforeach ?>"+
                "</select></td>"+
            "<td><select type='text' class='form-control select3' name='contactTraceRelation[]' id='contactTraceRelation"+entryId+"' style='width:100%;'>"+
                    "<option value=''>SELECT RELATION</option>"+
                    "<?php foreach ($getStatus['data2'] as $key => $value): ?>"+
                        "<option value='<?= $value['id'] ?>' ><?= $value['text'] ?></option>"+
                    "<?php endforeach ?>"+
                "</select></td>"+
        "</tr>");
        $('.select3').select2();
    }

    function addEntry2(){
        entryId=entryId+1;
        $('#tbl_contact_trace2 tbody').append("<tr id='entry"+entryId+"'>"+
            "<td align='center'><a style='margin-top:5px;cursor:pointer;' class='btn btn-xs btn-danger text-white' onclick='removeEntry2(\""+entryId+"\")'><span class='fa fa-times'></span></a></td>"+
            "<td><select type='text' class='form-control select4' name='contactTracePerson[]' id='contactTracePerson"+entryId+"' style='width:100%;'>"+
                    "<option value=''>SELECT CONTACT</option>"+
                    "<?php foreach ($getStatus['data11'] as $key => $value): ?>"+
                        "<option value='<?= $value['id'] ?>' ><?= $value['text'] ?></option>"+
                    "<?php endforeach ?>"+
                "</select></td>"+
            "<td><select type='text' class='form-control select4' name='contactTraceRelation[]' id='contactTraceRelation"+entryId+"' style='width:100%;'>"+
                    "<option value=''>SELECT RELATION</option>"+
                    "<?php foreach ($getStatus['data2'] as $key => $value): ?>"+
                        "<option value='<?= $value['id'] ?>' ><?= $value['text'] ?></option>"+
                    "<?php endforeach ?>"+
                "</select></td>"+
        "</tr>");
        $('.select4').select2();
    }

    function removeEntry(b){
        if($('#tbl_contact_trace tbody tr').length==1){
        }else{
            $('#tbl_contact_trace tbody tr').each(function() {
            var id = this.id;
                if(id=="entry"+b){
                    "entry"+this.remove();
                }
            });
        }
    }

    function removeEntry2(b){
        if($('#tbl_contact_trace2 tbody tr').length==1){
        }else{
            $('#tbl_contact_trace2 tbody tr').each(function() {
            var id = this.id;
                if(id=="entry"+b){
                    "entry"+this.remove();
                }
            });
        }
    }

    function removeAllEntry(){
        entryId=0;
        $('#tbl_contact_trace tbody').empty();
        addEntry();
    }

    function removeAllEntry2(){
        entryId=0;
        $('#tbl_contact_trace2 tbody').empty();
        addEntry2();
    }

    function myContact(a,b){
        $("#form_contact_tracing2 .personContactId").val(a);
        $("#form_contact_tracing2 .personContactName").text(b);
        
        // $('#toTopContact').click(function() {
            //$("#toTopContact").animate({scrollTop: 0}, 500);
        // });
        $.post("<?= base_url() ?>" + "usermanagement/Dataentry/getMyContact",{value:a},
            function(a){
              var result = JSON.parse(a);
              var len = result.length;
              thisData = len>0?1:0;

              Highcharts.chart('myContact', {
                  chart: {
                      height: len<2?120:len*95,//len<2?100:(len<3?200:(len<6?500:(len<11?650:1000))),
                      inverted: false//len>2?false:true
                  },

                  title: {
                      text: 'CLOSE CONTACT GRAPH'
                  },

                  // accessibility: {
                  //     point: {
                  //         descriptionFormatter: function (point) {
                  //             var nodeName = point.toNode.name,
                  //                 nodeId = point.toNode.id,
                  //                 nodeDesc = nodeName === nodeId ? nodeName : nodeName + ', ' + nodeId,
                  //                 parentDesc = point.fromNode.id;
                  //             return point.index + '. ' + nodeDesc + ', reports to ' + parentDesc + '.';
                  //         }
                  //     }
                  // },
                  plotOptions: {
                      series: {
                          enableMouseTracking: false
                      }
                      //series: {
                        //nodeWidth: '22%',
                        // nodeHeight: '30',
                      //}
                  },

                  series: [{
                      type: 'organization',
                      name: 'COVID19',
                      keys: ['from', 'to'],
                      // color: "#41c0a4",
                      data: result,
                      // levels: [{
                      //     level: 0,
                      //     color: 'silver',
                      //     dataLabels: {
                      //         color: 'black'
                      //     },
                      //     height: 20
                      // }
                      // , {
                      //     level: 1,
                      //     color: 'silver',
                      //     dataLabels: {
                      //         color: 'black'
                      //     },
                      //     height: 25
                      // }
                      // , {
                      //     level: 2,
                      //     color: '#980104'
                      // }, {
                      //     level: 4,
                      //     color: '#359154'
                      // }
                      // ],
                      // nodes: [{
                      //     id: '1'
                      // }, {
                      //     id: '2'
                      // }, {
                      //     id: '3'
                      // }],

                  // series: [{
                  //     type: 'organization',
                  //     name: 'Highsoft',
                  //     keys: ['from', 'to'],
                  //     data: [
                  //         ['Shareholders', 'Board'],
                  //         ['Board', 'CEO'],
                  //         ['CEO', 'CTO'],
                  //         ['CEO', 'CPO'],
                  //         ['CEO', 'CSO'],
                  //         ['CEO', 'CMO'],
                  //         ['CEO', 'HR'],
                  //         ['CTO', 'Product'],
                  //         ['CTO', 'Web'],
                  //         ['CSO', 'Sales'],
                  //         ['CMO', 'Market']
                  //     ],
                  //     levels: [{
                  //         level: 0,
                  //         color: 'silver',
                  //         dataLabels: {
                  //             color: 'black'
                  //         },
                  //         height: 25
                  //     }, {
                  //         level: 1,
                  //         color: 'silver',
                  //         dataLabels: {
                  //             color: 'black'
                  //         },
                  //         height: 25
                  //     }, {
                  //         level: 2,
                  //         color: '#980104'
                  //     }, {
                  //         level: 4,
                  //         color: '#359154'
                  //     }],
                  //     nodes: [{
                  //         id: 'Shareholders'
                  //     }, {
                  //         id: 'Board'
                  //     }, {
                  //         id: 'CEO',
                  //         title: 'CEO',
                  //         name: 'Grethe Hjetland',
                  //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12132317/Grethe.jpg'
                  //     }, {
                  //         id: 'HR',
                  //         title: 'HR/CFO',
                  //         name: 'Anne Jorunn Fjærestad',
                  //         color: '#007ad0',
                  //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12132314/AnneJorunn.jpg',
                  //         column: 3,
                  //         offset: '75%'
                  //     }, {
                  //         id: 'CTO',
                  //         title: 'CTO',
                  //         name: 'Christer Vasseng',
                  //         column: 4,
                  //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12140620/Christer.jpg',
                  //         layout: 'hanging'
                  //     }, {
                  //         id: 'CPO',
                  //         title: 'CPO',
                  //         name: 'Torstein Hønsi',
                  //         column: 4,
                  //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12131849/Torstein1.jpg'
                  //     }, {
                  //         id: 'CSO',
                  //         title: 'CSO',
                  //         name: 'Anita Nesse',
                  //         column: 4,
                  //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12132313/Anita.jpg',
                  //         layout: 'hanging'
                  //     }, {
                  //         id: 'CMO',
                  //         title: 'CMO',
                  //         name: 'Vidar Brekke',
                  //         column: 4,
                  //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/13105551/Vidar.jpg',
                  //         layout: 'hanging'
                  //     }, {
                  //         id: 'Product',
                  //         name: 'Product developers'
                  //     }, {
                  //         id: 'Web',
                  //         name: 'Web devs, sys admin'
                  //     }, {
                  //         id: 'Sales',
                  //         name: 'Salessss team'
                  //     }, {
                  //         id: 'Market',
                  //         name: 'Marketing team'
                  //     }],
                      colorByPoint: false,
                      //color: '#007ad0',
                      // dataLabels: {
                      //     color: 'white'
                      // },
                      borderColor: 'white',
                      nodeWidth: '370',
                      // nodeHeight: '1%',
                  }],
                  // tooltip: {
                  //     outside: true
                  // },

                  tooltip: {
                    outside: true,
                    formatter: function() {
                      return this.point.info;
                    }
                  },
                  exporting: {
                      allowHTML: true,
                      sourceWidth: 1000,
                      sourceHeight: 600
                  }
              });
        }).done(function(){
          if(thisData==1){
            $("#graphPresentation").modal("show");
          }else{
            noData("No Data found!");
          }
        });
    }

  
    function myContact2(a){
      $.post("<?= base_url() ?>" + "usermanagement/Dataentry/getContact",{value:a},
        function(a){
          var result = JSON.parse(a);
          var tmp = "";
          var tmp2 = "";
          var lvl = 0;
          var idArr = [];
          var maxArr = [];
          var cc = 0;
          var max = 0;

          for(var j=0;j<result["data2"].length;j++){
            if(tmp!=result["data2"][j][0]){
              lvl++;
              tmp2=result["data2"][j][0];
            }

            tmp = result["data2"][j][0];
            if(tmp2==tmp){
              idArr.push(result["data2"][j][0]);
              tmp2="";
            }
          }

          for(var j1=0;j1<idArr.length;j1++){
            var aa = idArr[j1];
            for(var j2=0;j2<result["data2"].length;j2++){
              if(Number(result["data2"][j2][0])==aa){
                cc++
              }
            }
            maxArr.push(cc);
            cc=0;
          }

          for(var j3=0;j3<maxArr.length;j3++){
            if(max>maxArr[j3]){
            }else{
              max=maxArr[j3];
            }
          }

          // console.log(maxArr)
          // console.log(max)
          // console.log(lvl)

          // var len = result["data1"].length;
          //console.log(lvl)
          var myWidth = lvl * 50;
          $("#myContact").css("width",myWidth+"%");
          thisData = max>0?1:0;


          Highcharts.chart('myContact', {
              chart: {
                  height: max<2?120:max*85,//max<2?100:(max<3?200:(max<6?500:(max<11?650:1000))),
                  inverted: false//len>2?false:true
              },

              title: {
                  text: 'CLOSE CONTACT GRAPH'
              },

              // accessibility: {
              //     point: {
              //         descriptionFormatter: function (point) {
              //             var nodeName = point.toNode.name,
              //                 nodeId = point.toNode.id,
              //                 nodeDesc = nodeName === nodeId ? nodeName : nodeName + ', ' + nodeId,
              //                 parentDesc = point.fromNode.id;
              //             return point.index + '. ' + nodeDesc + ', reports to ' + parentDesc + '.';
              //         }
              //     }
              // },
              plotOptions: {
                  series: {
                      enableMouseTracking: false
                  }
                  //series: {
                    //nodeWidth: '22%',
                    // nodeHeight: '30',
                  //}
              },

              series: [{
                  type: 'organization',
                  name: 'COVID19',
                  keys: ['from', 'to'],
                  // color: "#41c0a4",
                  data: result["data1"],
                  // levels: [{
                  //     level: 0,
                  //     color: 'silver',
                  //     dataLabels: {
                  //         color: 'black'
                  //     },
                  //     height: 20
                  // }
                  // , {
                  //     level: 1,
                  //     color: 'silver',
                  //     dataLabels: {
                  //         color: 'black'
                  //     },
                  //     height: 25
                  // }
                  // , {
                  //     level: 2,
                  //     color: '#980104'
                  // }, {
                  //     level: 4,
                  //     color: '#359154'
                  // }
                  // ],
                  // nodes: [{
                  //     id: '1'
                  // }, {
                  //     id: '2'
                  // }, {
                  //     id: '3'
                  // }],

              // series: [{
              //     type: 'organization',
              //     name: 'Highsoft',
              //     keys: ['from', 'to'],
              //     data: [
              //         ['Shareholders', 'Board'],
              //         ['Board', 'CEO'],
              //         ['CEO', 'CTO'],
              //         ['CEO', 'CPO'],
              //         ['CEO', 'CSO'],
              //         ['CEO', 'CMO'],
              //         ['CEO', 'HR'],
              //         ['CTO', 'Product'],
              //         ['CTO', 'Web'],
              //         ['CSO', 'Sales'],
              //         ['CMO', 'Market']
              //     ],
              //     levels: [{
              //         level: 0,
              //         color: 'silver',
              //         dataLabels: {
              //             color: 'black'
              //         },
              //         height: 25
              //     }, {
              //         level: 1,
              //         color: 'silver',
              //         dataLabels: {
              //             color: 'black'
              //         },
              //         height: 25
              //     }, {
              //         level: 2,
              //         color: '#980104'
              //     }, {
              //         level: 4,
              //         color: '#359154'
              //     }],
              //     nodes: [{
              //         id: 'Shareholders'
              //     }, {
              //         id: 'Board'
              //     }, {
              //         id: 'CEO',
              //         title: 'CEO',
              //         name: 'Grethe Hjetland',
              //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12132317/Grethe.jpg'
              //     }, {
              //         id: 'HR',
              //         title: 'HR/CFO',
              //         name: 'Anne Jorunn Fjærestad',
              //         color: '#007ad0',
              //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12132314/AnneJorunn.jpg',
              //         column: 3,
              //         offset: '75%'
              //     }, {
              //         id: 'CTO',
              //         title: 'CTO',
              //         name: 'Christer Vasseng',
              //         column: 4,
              //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12140620/Christer.jpg',
              //         layout: 'hanging'
              //     }, {
              //         id: 'CPO',
              //         title: 'CPO',
              //         name: 'Torstein Hønsi',
              //         column: 4,
              //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12131849/Torstein1.jpg'
              //     }, {
              //         id: 'CSO',
              //         title: 'CSO',
              //         name: 'Anita Nesse',
              //         column: 4,
              //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12132313/Anita.jpg',
              //         layout: 'hanging'
              //     }, {
              //         id: 'CMO',
              //         title: 'CMO',
              //         name: 'Vidar Brekke',
              //         column: 4,
              //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/13105551/Vidar.jpg',
              //         layout: 'hanging'
              //     }, {
              //         id: 'Product',
              //         name: 'Product developers'
              //     }, {
              //         id: 'Web',
              //         name: 'Web devs, sys admin'
              //     }, {
              //         id: 'Sales',
              //         name: 'Salessss team'
              //     }, {
              //         id: 'Market',
              //         name: 'Marketing team'
              //     }],
                  colorByPoint: false,
                  //color: '#007ad0',
                  // dataLabels: {
                  //     color: 'white'
                  // },
                  borderColor: 'white',
                  nodeWidth: '300',
                  // nodeHeight: '1%',
              }],
              // tooltip: {
              //     outside: true
              // },

              tooltip: {
                outside: true,
                formatter: function() {
                  return this.point.info;
                }
              },
              exporting: {
                  allowHTML: true,
                  sourceWidth: 800,
                  sourceHeight: 600
              }
          });
      }).done(function(){
        if(thisData==1){
          $("#graphPresentation").modal("show");
        }else{
          noData("No Data found!");
        }
      });
    }


  function addContact(a,b){
    $('html, body').animate({scrollTop : 0},800);
  
    $(".personRootId").val(a);
    $(".personRootName").val(b);
    $(".form_save_dataPrimary").slideUp();
    $(".form_save_dataContact").slideDown();

  }

  function updateStatus(a,b){
    $(".personStatusId").val(a);
    $(".personStatusName").val(b);
    $('#form_save_dataTestHistory .proceed').val(0);
    covid19_status();
  } 
  function updateTest(a,b){
    $(".personTestId").val(a);
    $(".personTestName").val(b);
    covid19_test();
  }
  
  function updateQStatus(a,b){
    $(".personQStatusId").val(a);
    $(".personQStatusName").val(b);
    covid19_qstatus();
  } 
  function updateCode(a,b){
    $(".personCodeId").val(a);
    $(".personCodeName").val(b);
    $("#codeHistory").modal("show");
    setTimeout(function(){
      $("#codeHistory .modalPersonCode").focus();
    },500);
  }

  function myContact2(a,b){
    $("#form_contact_tracing .personContactId").val(a);
    $("#form_contact_tracing .personContactName").text(b);
    $("#graphPresentation2").modal("show");
  }

  function chart5(a){
    $.post("<?= base_url() ?>" + "usermanagement/Dataentry/getContact",{value:a},
        function(a){
          var result = JSON.parse(a);
          thisData = result.length>0?1:0;

          Highcharts.chart('chart5', {
              chart: {
                  height: 600,
                  inverted: true
              },

              title: {
                  text: 'CLOSE CONTACT GRAPH'
              },

              accessibility: {
                  point: {
                      descriptionFormatter: function (point) {
                          var nodeName = point.toNode.name,
                              nodeId = point.toNode.id,
                              nodeDesc = nodeName === nodeId ? nodeName : nodeName + ', ' + nodeId,
                              parentDesc = point.fromNode.id;
                          return point.index + '. ' + nodeDesc + ', reports to ' + parentDesc + '.';
                      }
                  }
              },
              plotOptions: {
                  series: {
                      enableMouseTracking: false
                  }
              },

              series: [{
                  type: 'organization',
                  name: 'COVID19',
                  keys: ['from', 'to'],
                  // color: "#41c0a4",
                  data: result,
                  // levels: [{
                  //     level: 0,
                  //     color: 'silver',
                  //     dataLabels: {
                  //         color: 'black'
                  //     },
                  //     height: 20
                  // }
                  // , {
                  //     level: 1,
                  //     color: 'silver',
                  //     dataLabels: {
                  //         color: 'black'
                  //     },
                  //     height: 25
                  // }, {
                  //     level: 2,
                  //     color: '#980104'
                  // }, {
                  //     level: 4,
                  //     color: '#359154'
                  // }
                  //],
                  // nodes: [{
                  //     id: '1'
                  // }, {
                  //     id: '2'
                  // }, {
                  //     id: '3'
                  // }],

              // series: [{
              //     type: 'organization',
              //     name: 'Highsoft',
              //     keys: ['from', 'to'],
              //     data: [
              //         ['Shareholders', 'Board'],
              //         ['Board', 'CEO'],
              //         ['CEO', 'CTO'],
              //         ['CEO', 'CPO'],
              //         ['CEO', 'CSO'],
              //         ['CEO', 'CMO'],
              //         ['CEO', 'HR'],
              //         ['CTO', 'Product'],
              //         ['CTO', 'Web'],
              //         ['CSO', 'Sales'],
              //         ['CMO', 'Market']
              //     ],
              //     levels: [{
              //         level: 0,
              //         color: 'silver',
              //         dataLabels: {
              //             color: 'black'
              //         },
              //         height: 25
              //     }, {
              //         level: 1,
              //         color: 'silver',
              //         dataLabels: {
              //             color: 'black'
              //         },
              //         height: 25
              //     }, {
              //         level: 2,
              //         color: '#980104'
              //     }, {
              //         level: 4,
              //         color: '#359154'
              //     }],
              //     nodes: [{
              //         id: 'Shareholders'
              //     }, {
              //         id: 'Board'
              //     }, {
              //         id: 'CEO',
              //         title: 'CEO',
              //         name: 'Grethe Hjetland',
              //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12132317/Grethe.jpg'
              //     }, {
              //         id: 'HR',
              //         title: 'HR/CFO',
              //         name: 'Anne Jorunn Fjærestad',
              //         color: '#007ad0',
              //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12132314/AnneJorunn.jpg',
              //         column: 3,
              //         offset: '75%'
              //     }, {
              //         id: 'CTO',
              //         title: 'CTO',
              //         name: 'Christer Vasseng',
              //         column: 4,
              //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12140620/Christer.jpg',
              //         layout: 'hanging'
              //     }, {
              //         id: 'CPO',
              //         title: 'CPO',
              //         name: 'Torstein Hønsi',
              //         column: 4,
              //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12131849/Torstein1.jpg'
              //     }, {
              //         id: 'CSO',
              //         title: 'CSO',
              //         name: 'Anita Nesse',
              //         column: 4,
              //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12132313/Anita.jpg',
              //         layout: 'hanging'
              //     }, {
              //         id: 'CMO',
              //         title: 'CMO',
              //         name: 'Vidar Brekke',
              //         column: 4,
              //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/13105551/Vidar.jpg',
              //         layout: 'hanging'
              //     }, {
              //         id: 'Product',
              //         name: 'Product developers'
              //     }, {
              //         id: 'Web',
              //         name: 'Web devs, sys admin'
              //     }, {
              //         id: 'Sales',
              //         name: 'Salessss team'
              //     }, {
              //         id: 'Market',
              //         name: 'Marketing team'
              //     }],
                  colorByPoint: false,
                  color: '#007ad0',
                  dataLabels: {
                      color: 'white'
                  },
                  borderColor: 'white',
                  nodeWidth: 65
              }],
              tooltip: {
                  outside: true
              },
              exporting: {
                  allowHTML: true,
                  sourceWidth: 800,
                  sourceHeight: 600
              }
          });
    }).done(function(){
      if(thisData==1){
        $("#graphAnalytics").modal("show");
      }else{
        noData("No Data found!");
      }
    });
  }

  // $(".highcharts-root").css("font-family","arial");
  // $(".highcharts-data-labels").css("font-family","arial");
</script>