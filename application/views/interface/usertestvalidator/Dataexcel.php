<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Content Header (Page header) -->
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
        <form method="post" id="import_form" enctype="multipart/form-data">
            <p><button type="submit" name="import" class="btn btn-sm btn-info submitBtnUpload"><i class="fa fa-upload"></i> Import Excel</button>
               <input type="file" name="file" id="file" required accept=".xlsm" /></p>
        </form>
        <div class="row">

            <div class="col-md-6">
                <div class="table-responsive" id="customer_data">
                </div>
                <div class="card card-lightblue">
                    <div class="card-header">
                      <h3 class="card-title"><i class="fa fa-list"></i> Uploaded List
                      </h3>
    
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button> -->
                      </div>
                    </div>
                    <!-- /.card-body -->
    
                    <div class="card-body" style="overflow: auto;margin-right: 20px;white-space:nowrap;">
                      <form id='form_person'>
                        <table id="tbl_person_covid19" style="width:100%;" class="table table-bordered table-hover table-data-checkbox">
                          <thead>
                          <tr>
                            <th width="1"><div class="custom-control custom-checkbox ml-1">
                                                <input class="custom-control-input checkbox-toggle1" type="checkbox" id="CheckAll1">
                                                <label for="CheckAll1" class="custom-control-label" style="cursor:pointer;"></label>
                                            </div>
                            </th>
                            <th width="1"><i class='fa fa-sitemap'></i></th>
                            <th><i class='fa fa-qrcode'></i> Code</th>
                            <th><i class='fa fa-user'></i> Name</th>
                            <th width="1"><i class='fa fa-virus'></i> Status</th>
                            <th width="1"><i class='fa fa-vial'></i> Test</th>
                            <th width="1"><i class='fa fa-phone'></i></th>
                            <!-- <th>Barangay/Address</th> -->
                            <th>Street</th>
                            <th><i class='fa fa-plane'></i> Travel History</th>
                            <th width="1"><i class='fa fa-venus-mars'></i></th>
                            <th width="1">Age</th>
                            <th width="1"><i class='fas fa-head-side-cough'></i></th>
                            <th width="1"><i class='fas fa-sticky-note'></i></th>
                            <th width="1">Level</th>
                            <th width="1">Encoded By</th>
                          </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </form>
                    </div>
                    <!-- /.card-body -->
                  <!-- <div class="card-footer">
                    <button type="submit" class="btn btn-info submitBtnLocal"><i class="fa fa-check"></i> Save Data</button>
                  </div> -->
                </div>
            </div>


            <div class="col-md-6">
                <div class="table-responsive" id="customer_data">
                </div>
                <div class="card card-danger">
                    <div class="card-header">
                      <h3 class="card-title"><i class="fa fa-list"></i> Existed List
                      </h3>
    
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button> -->
                      </div>
                    </div>
                    <!-- /.card-body -->
    
                    <div class="card-body" style="overflow: auto;margin-right: 20px;white-space:nowrap;">
                      <form id='form_person_exist'>
                        <table id="tbl_person_covid19_exist" style="width:100%;" class="table table-bordered table-hover table-data-checkbox">
                          <thead>
                          <tr>
                            <th width="1"><div class="custom-control custom-checkbox ml-1">
                                                <input class="custom-control-input checkbox-toggle2" type="checkbox" id="CheckAll2">
                                                <label for="CheckAll2" class="custom-control-label" style="cursor:pointer;"></label>
                                            </div>
                            </th>
                            <th><i class='fa fa-qrcode'></i> Code</th>
                            <th><i class='fa fa-user'></i> Name</th>
                            <th width="1"><i class='fa fa-virus'></i> Status</th>
                            <th width="1"><i class='fa fa-vial'></i> Test</th>
                            <th width="1"><i class='fa fa-phone'></i></th>
                            <!-- <th>Barangay/Address</th> -->
                            <th>Street</th>
                            <th><i class='fa fa-plane'></i> Travel History</th>
                            <th width="1"><i class='fa fa-venus-mars'></i></th>
                            <th width="1">Age</th>
                            <th width="1"><i class='fas fa-head-side-cough'></i></th>
                            <th width="1"><i class='fas fa-sticky-note'></i></th>
                            <th width="1">Level</th>
                            <th width="1">Encoded By</th>
                          </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </form>
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

<script>

    $(function(){
        var tbl_person_covid19, tbl_personCovid19_data;
            tbl_person_covid19 = $("#tbl_person_covid19").DataTable({
                                "order": [[1, "desc" ]],
                                "columnDefs": [ {
                                  "targets"  : [0],
                                  "orderable": false,
                                }],
                                dom: 'Bfrtip',
                                buttons: [
                                    {
                                        text: "<i class='fa fa-virus'></i> Status",
                                        action: function(e, dt, node, config) {
                                            //clear_form("form_assign_personnel");
                                            validate_form2("tbl_person_covid19","batch_status");
                                        }
                                    },{
                                        text: "<i class='fa fa-vial'></i> Test",
                                        action: function(e, dt, node, config) {
                                            //clear_form("form_assign_personnel");
                                            validate_form2("tbl_person_covid19","batch_test");
                                        }
                                    },'pageLength',{
                                        text: "<i class='fa fa-redo-alt'></i>",
                                        action: function(e, dt, node, config) {
                                            $('#tbl_person_covid19').DataTable().ajax.reload();
                                        }
                                    }
                                ],
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
                                    url: "<?= base_url('usertestvalidator/Dataexcel/getPersonCovid') ?>",
                                    type: "POST",
                                }
                            });
        $("#tbl_person_covid19_filter").addClass("row");
        $("#tbl_person_covid19_filter label").css("width","100%");
        $("#tbl_person_covid19_filter .form-control-sm").css("width","100%");

        var tbl_person_covid19_exist, tbl_personCovid19_data;
            tbl_person_covid19_exist = $("#tbl_person_covid19_exist").DataTable({
                                "order": [[1, "asc" ]],
                                "columnDefs": [ {
                                  "targets"  : [0],
                                  "orderable": false,
                                }],
                                dom: 'Bfrtip',
                                buttons: [
                                    {
                                        text: "<i class='fa fa-plus'></i> Append Data",
                                        action: function(e, dt, node, config) {
                                            //clear_form("form_assign_personnel");
                                            validate_form2("tbl_person_covid19_exist","batch_append");
                                        }
                                    },{
                                        text: "<i class='fa fa-trash'></i> Remove Data",
                                        action: function(e, dt, node, config) {
                                            //clear_form("form_assign_personnel");
                                            validate_form2("tbl_person_covid19_exist","batch_remove");
                                        }
                                    },
                                    'pageLength',{
                                        text: "<i class='fa fa-redo-alt'></i>",
                                        action: function(e, dt, node, config) {
                                            $('#tbl_person_covid19_exist').DataTable().ajax.reload();
                                        }
                                    }
                                ],
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
                                    url: "<?= base_url('usertestvalidator/Dataexcel/getPersonCovidExist') ?>",
                                    type: "POST",
                                }
                            });
        $("#tbl_person_covid19_exist_filter").addClass("row");
        $("#tbl_person_covid19_exist_filter label").css("width","100%");
        $("#tbl_person_covid19_exist_filter .form-control-sm").css("width","100%");
    });

    $('#import_form').on('submit', function(event){
        event.preventDefault();
        $(".submitBtnUpload").attr("disabled", true);
        $.ajax({
            url:"<?= base_url(); ?>usertestvalidator/Dataexcel/import",
            method:"POST",
            data:new FormData(this),
            contentType:false,
            cache:false,
            processData:false,
            success:function(data){
                console.log(data)
                $('#file').val('');
                // load_data();
                //var d = JSON.parse(data);
                //console.log(d);
                //alert(data);
                successAlert("Successfully Saved!");
                $(".submitBtnUpload").attr("disabled", false);
                $(".submitBtnUpload").html("<i class=\"fa fa-upload\"></i> Import Excel");
                $('#tbl_person_covid19,#tbl_person_covid19_exist').DataTable().ajax.reload();

            },
            error:function(data){
                console.log(data.responseText)
            }
        })
    });

    function batch_append(){
        var a = $("#form_person_exist").serialize();
        $(".btn_batch_append").attr("disabled", true);
        $.post("<?= base_url() ?>" + "usertestvalidator/Dataexcel/batch_append",a,
            function(data) {
            var d = JSON.parse(data);
            if(d.success == true) {
                successAlert("Successfully Saved!");
                $("#batch_append").modal("hide");
            } else {
                failAlert("Something went wrong!");
            }
        }).done(function(){
            $("#batch_test").modal("hide");
            //setTimeout(function(){
              $('#tbl_person_covid19,#tbl_person_covid19_exist').DataTable().ajax.reload();
              uncheckMother();
              $(".btn_batch_append").attr("disabled", false);
            //},1000);
        });
    }

    function batch_remove(){
        var a = $("#form_person_exist").serialize();
        $(".btn_batch_remove").attr("disabled", true);
        $.post("<?= base_url() ?>" + "usertestvalidator/Dataexcel/batch_remove",a,
            function(data) {
            var d = JSON.parse(data);
            if(d.success == true) {
                successAlert("Successfully Saved!");
                $("#batch_remove").modal("hide");
            } else {
                failAlert("Something went wrong!");
            }
        }).done(function(){
            $("#batch_test").modal("hide");
            //setTimeout(function(){
              $('#tbl_person_covid19,#tbl_person_covid19_exist').DataTable().ajax.reload();
              uncheckMother();
              $(".btn_batch_remove").attr("disabled", false);
            //},1000);
        });
    }
</script>