<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>User Account</h1>
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

    <div class="row">
      <div class="col-md-6">
            <?= form_open(base_url('useradmin/Dataentry/saveDataUserAccount'), 'id=form_save_dataUserAccount'); ?>
              <div class="card card-default">
                    <div class="card-header">
                      <h3 class="card-title">Personnel Account Details</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button> -->
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="overflow: auto;">
                      <!-- <label>PERONAL DATA</label> -->
                      <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                              </div>
                              <select class="form-control" name="barangayAssignment">
                                <?php foreach ($getBarangay['data3'] as $key => $value): ?>
                                    <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                                <?php endforeach ?>
                              </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                              </div>
                              <input type="text" class="form-control text-uppercase" name="personTitle" placeholder="PERSONAL TITLE" autocomplete="off">
                          </div>
                        </div>
                      </div>  
                      <div class="row">
                          <div class="col-md-5">
                            <div class="input-group mb-2">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                              </div>
                            <input type="text" class="form-control text-uppercase" name="firstName" placeholder="FIRST NAME" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <input type="text" class="form-control text-uppercase" name="middleName" placeholder="M.I." autocomplete="off">
                        </div>
                        <div class="col-md-5 mb-2">
                            <input type="text" class="form-control text-uppercase" name="lastName" placeholder="LAST NAME" autocomplete="off">
                        </div>
                      </div>
                      <div class="row">
                          <div class="col-md-4">
                            <div class="input-group mb-2">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-home"></i></span>
                              </div>
                              <select class="form-control" name="barangayName">
                                <?php foreach ($getBarangay['data2'] as $key => $value): ?>
                                    <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                                <?php endforeach ?>
                              </select>
                          </div>
                        </div>
                        <div class="col-md-8 mb-2">
                            <input type="text" class="form-control text-uppercase" name="streetName" placeholder="PUROK/STREET/LOT NUMBER" autocomplete="off">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-4">
                            <div class="input-group mb-2">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                              </div>
                              <select class="form-control" name="gender">
                                <option value="1">MALE</option>
                                <option value="0">FEMALE</option>
                              </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-2">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                              </div>
                              <input type="number" class="form-control" name="personAge" placeholder="AGE" autocomplete="off" step=".01">
                          </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-2">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                              </div>
                              <input type="number" class="form-control" name="personNumber" placeholder="CONTACT NUMBER" autocomplete="off">
                          </div>
                        </div>
                      </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-info btn-sm submitBtnPersonAccount"><i class="fa fa-check"></i> Save Data</button>
                    </div>
              </div>
              <!-- /.card -->
            </form>
      </div>

      <div class="col-md-6">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Personnel Account List
            </h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button> -->
            </div>
          </div>
          <!-- /.card-body -->

          <div class="card-body" style="overflow: auto;margin-right: 20px;white-space:nowrap;">
            <table id="tbl_person_user_account" style="width:100%;" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th width="1">#</th>
                <th width="1"></th>
                <th><i class='fa fa-user'></i> Name</th>
                <th><i class='fa fa-map-pin'></i> Assignment</th>
                <th width="1"><i class='fa fa-phone'></i></th>
                <th width="1">Address</th>
                <th width="1">Gender</th>
                <th width="1">Age</th>
              </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
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
        var tbl_person_user_account, tbl_personCovid19_data;
            tbl_person_user_account = $("#tbl_person_user_account").DataTable({
                                // "order": [[0, "desc" ]],
                                "columnDefs": [ {
                                  "targets"  : [1],
                                  "orderable": false,
                                }],
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
                                    url: "<?= base_url('useradmin/Dataentry/getPersonAccount') ?>",
                                    type: "POST",
                                    data:
                                    function(d) {
                                      return tbl_personCovid19_data;
                                    }
                                }
                            });
        $("#tbl_person_user_account_filter").addClass("row");
        $("#tbl_person_user_account_filter label").css("width","100%").css("padding-right","15px");
        $("#tbl_person_user_account_filter .form-control-sm").css("width","100%");
        
        var save_account = {
            clearForm: false,
            resetForm: false,
            beforeSubmit: function(e) {
                validate_form("form_save_dataUserAccount");
                validatorC==0?e.preventDefault():"";
                $(".submitBtnPersonAccount").attr("disabled", true);
                $(".submitBtnPersonAccount").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
            },
            success: function(data) {
                var d = JSON.parse(data);
                if(d.success == true) {
                    successAlert();
                    clear_form("form_save_dataUserAccount");
                } else {
                    failAlert();
                }
                $(".submitBtnPersonAccount").attr("disabled", false);
                $(".submitBtnPersonAccount").html("Save");
                $(".submitBtnPersonAccount").html("<span class=\"fa fa-check\"></span> Save Data");
                $('#tbl_person_user_account').DataTable().ajax.reload();
            }
        };
        $("#form_save_dataUserAccount").ajaxForm(save_account);

        var save_username = {
            clearForm: false,
            resetForm: false,
            beforeSubmit: function(e) {
                validate_form("form_save_username");
                validatorC==0?e.preventDefault():"";
                $(".btnUsername").attr("disabled", true);
                $(".btnUsername").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
            },
            success: function(data) {
                var d = JSON.parse(data);
                if(d.success == true) {
                    successAlert();
                    clear_form("form_save_username");
                    $("#modalUsername").modal("hide");
                } else if(d.exist == true) {
                    existAlert();
                } else {
                    failAlert();
                }
                $(".btnUsername").attr("disabled", false);
                $(".btnUsername").html("Save");
                $(".btnUsername").html("<span class=\"fa fa-check\"></span> Save Data");
                $('#tbl_person_user_account').DataTable().ajax.reload();
            }
        };
        $("#form_save_username").ajaxForm(save_username);

    });
    
    function resetPassword(){
        var a = $(".userName").val();
        $.post("<?= base_url() ?>" + "useradmin/Dataentry/resetPassword",{value:a},function(a){
            $("#modalUsername").modal("hide");
            $('#tbl_person_user_account').DataTable().ajax.reload();
            successAlert();
        });
    }

    function updateUsername(a,b){
        $(".userName").val(a);
        $(".thisUserName").val(b);
        $("#modalUsername").modal("show");
    }

    function select(){
        $('.select2').select2({
            placeholder: "SELECT BARANGAY"
        });
    }

</script>