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

    <div class="row">
      <div class="col-md-6">

        <div class="row">
          
          <div class="col-md-12 form_save_dataPrimary">
            <?= form_open(base_url('userhealthworker/Dataentry/saveDataPrimary'), 'id=form_save_dataPrimary'); ?>
              <div class="card card-lightblue">
                <div class="card-header">
                  <h3 class="card-title"><i class="fa fa-virus"></i> Primary Person Data Entry</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button> -->
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="overflow: auto;">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-virus"></i></span>
                            </div>
                            <select class="form-control" name="statusCOVID">
                              <?php foreach ($getStatus['data1'] as $key => $value): ?>
                                  <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                              <?php endforeach ?>
                            </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            </div>
                            <input type="date" value="<?= Date('Y-m-d') ?>" class="form-control" name="dateEntried">
                        </div>
                      </div>
                    </div>

                    <!-- <label>PERONAL DATA</label> -->

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

                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group mb-2">
                              <div class="input-group-prepend" style="width:100%;">
                                <span class="input-group-text"><i class="fas fa-home"></i></span>
                                <select class="form-control select2" name="barangayName">
                                  <?php foreach ($getBarangay['data1'] as $key => $value): ?>
                                      <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                                  <?php endforeach ?>
                                </select>
                              </div>
                          </div>
                        </div>
                        <div class="col-md-8 mb-2">
                            <input type="text" class="form-control text-uppercase" name="streetName" placeholder="OTHER ADDRESS/PUROK/STREET/LOT NUMBER/" autocomplete="off">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 category">
                            <label>CATEGORY</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                                </div>
                                <select class="form-control" name="categoryCOVID" onchange="specifyPrimary($(this).val());">
                                  <?php foreach ($getStatus['data8'] as $key => $value): ?>
                                      <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                                  <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 specify hidden">
                            <label> </label>
                            <div class="input-group mb-2 specifyAgency hidden">
                                <input type="text" class="text-uppercase form-control" name="specifyAgency" placeholder="DOH, PNP, BMC, ...">
                            </div>
                            <div class="input-group mb-2 specifyOffice hidden">
                                <select class="form-control select2" name="specifyOffice" style="width:100%;">
                                  <option value="">SELECT OFFICE</option>
                                  <?php foreach ($getStatus['data10'] as $key => $value): ?>
                                      <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                                  <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>TRAVEL HISTORY</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-plane"></i></span>
                                </div>
                                <input type="text" class="form-control text-uppercase" name="travelHistory" placeholder="TRAVEL HISTORY: MANILA, CHINA, ..." autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>ARRIVAL DATE</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                </div>
                                <input type="date" class="form-control" name="dateArrival">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- <div class="col-md-4">
                            <div class="input-group mb-2">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-head-side-cough"></i></span>
                              </div>
                              <select class="form-control" name="symptomsCOVID">
                                <?php  foreach ($getStatus['data5'] as $key => $value): ?>
                                    <option value='<?=  $value['id'] ?>'><?=  $value['text'] ?></option>
                                <?php endforeach ?>
                              </select>
                          </div>
                        </div> -->
                        <div class="col-md-6">
                          <div class="input-group mb-2">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
                              </div>
                              <input type="text" class="form-control text-uppercase" name="remarksCOVID" placeholder="REMARKS" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="input-group mb-2">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                              </div>
                              <input type="text" class="form-control text-uppercase" name="whereaboutsCOVID" placeholder="WHEREABOUTS" autocomplete="off">
                          </div>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-info btn-sm submitBtnPrimary"><i class="fa fa-check"></i> Save Data</button>
                </div>
              </div>
              <!-- /.card -->
            </form>
          </div>

          <div class="col-md-12 form_save_dataContact" style="display: none;">
            <?= form_open(base_url('userhealthworker/Dataentry/saveDataContact'), 'id=form_save_dataContact'); ?>
              <input class="personRootId" name="personRootId" hidden>
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title"><i class="fa fa-virus"></i> Contact Person Data Entry</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button> -->
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="overflow: auto;">
                  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <span class="input-group-text text-xs"><i class="fas fa-user"></i></span>
                          </div>
                          <input class="form-control personRootName" type="text" readonly id="personRootName">
                      </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend" style="width:100%;">
                            <span class="input-group-text"><i class="fas fa-heart"></i></span>
                            <select class="form-control select2" name="relation" style="width:100%;">
                              <?php foreach ($getStatus['data2'] as $key => $value): ?>
                                  <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-virus"></i></span>
                          </div>
                          <select class="form-control" name="statusCOVID">
                            <?php foreach ($getStatus['data1'] as $key => $value): ?>
                                <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                            <?php endforeach ?>
                          </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                          </div>
                          <input type="date" value="<?= Date('Y-m-d') ?>" class="form-control" name="dateEntried">
                          <!-- <div class="input-group-append">
                            <button type="button" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                          </div> -->
                      </div>
                    </div>
                  </div>

                  <!-- <label>PERONAL DATA</label> -->

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

                  <div class="row">
                      <div class="col-md-4">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend" style="width:100%;">
                            <span class="input-group-text"><i class="fas fa-home"></i></span>
                            <select class="form-control select2" name="barangayName" style="width:100%;">
                              <?php foreach ($getBarangay['data2'] as $key => $value): ?>
                                  <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                      </div>
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" class="form-control text-uppercase" name="streetName" placeholder="OTHER ADDRESS/PUROK/STREET/LOT NUMBER/" autocomplete="off">
                    </div>
                  </div>

                  <div class="row">
                        <div class="col-md-6 category">
                            <label>CATEGORY</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                                </div>
                                <select class="form-control" name="categoryCOVID" onchange="specifyContact($(this).val());">
                                  <?php foreach ($getStatus['data8'] as $key => $value): ?>
                                      <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                                  <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 specify hidden">
                            <label> </label>
                            <div class="input-group mb-2 specifyAgency hidden">
                                <input type="text" class="text-uppercase form-control" name="specifyAgency" placeholder="DOH, PNP, BMC, ...">
                            </div>
                            <div class="input-group mb-2 specifyOffice hidden">
                                <select class="form-control select2" name="specifyOffice" style="width:100%;">
                                  <option value="">SELECT OFFICE</option>
                                  <?php foreach ($getStatus['data10'] as $key => $value): ?>
                                      <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                                  <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>TRAVEL HISTORY</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-plane"></i></span>
                                </div>
                                <input type="text" class="form-control text-uppercase" name="travelHistory" placeholder="TRAVEL HISTORY: MANILA, CHINA, ..." autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>ARRIVAL DATE</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                </div>
                                <input type="date" class="form-control" name="dateArrival">
                            </div>
                        </div>
                  </div>

                  <div class="row">
                    <!-- <div class="col-md-4">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-head-side-cough"></i></span>
                          </div>
                          <select class="form-control" name="symptomsCOVID">
                            <?php foreach ($getStatus['data5'] as $key => $value): ?>
                                <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                            <?php endforeach ?>
                          </select>
                      </div>
                    </div> -->
                    <div class="col-md-6">
                      <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
                          </div>
                          <input type="text" class="form-control text-uppercase" name="remarksCOVID" placeholder="REMARKS" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                          </div>
                          <input type="text" class="form-control text-uppercase" name="whereaboutsCOVID" placeholder="WHEREABOUTS" autocomplete="off">
                      </div>
                    </div>
                  </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-info btn-sm submitBtnContact"><i class="fa fa-check"></i> Save Data</button>
                  <a class="btn btn-danger float-right text-white" onclick="clear_form('form_save_dataContact');$('.form_save_dataContact').slideUp();$('.form_save_dataPrimary').slideDown();"><i class="fa fa-times"></i> Close</a>
                </div>
              </div>
              <!-- /.card -->
            </form>
          </div>

        </div>
      </div>

      <div class="col-md-6">
        <div class="row">
          
          <div class="col-md-12">
            <div class="card card-lightblue">
              <div class="card-header">
                <h3 class="card-title"><i class="fa fa-list"></i> Person List
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button> -->
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-body" style="overflow: auto;margin-right: 20px;white-space:nowrap;">
                <table id="tbl_person_covid19" style="width:100%;" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th width="1"></th>
                    <th width="1"><i class='fa fa-sitemap'></i></th>
                    <th><i class='fa fa-user'></i> Name</th>
                    <!-- <th width="1"><i class='fa fa-virus'></i> Status</th> -->
                    <!-- <th width="1"><i class='fa fa-vial'></i> Test</th> -->
                    <th width="1"><i class='fas fa-list-alt'></i></th>
                    <th width="1"><i class='fa fa-phone'></i></th>
                    <!-- <th>Street</th> -->
                    <th><i class='fa fa-plane'></i> Travel History</th>
                    <th width="1">Office/Agency</th>
                    <!-- <th width="1"><i class='fa fa-venus-mars'></i></th> -->
                    <!-- <th width="1">Age</th> -->
                    <th width="1"><i class='fas fa-sticky-note'></i></th>
                    <th width="1"><i class='fas fa-map-pin'></i></th>
                    <!-- <th width="1">Level</th> -->
                    <th width="1">Encoded By</th>
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
        <!-- /.card -->
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
                            "order": [[1, "desc" ]],
                            "columnDefs": [ {
                              "targets"  : [0],
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
                                url: "<?= base_url('userhealthworker/Dataentry/getPersonCovid') ?>",
                                type: "POST",
                                data:
                                function(d) {
                                  return tbl_personCovid19_data;
                                }
                            }
                        });
    $("#tbl_person_covid19_filter").addClass("row");
    $("#tbl_person_covid19_filter label").css("width","100%").css("padding-right","15px");
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
                successAlert("Successfully Saved!");
                clear_form("form_save_dataPrimary");
                specifyPrimary(0);
            }else if(d.exist == true) {
                existAlert("Person already exist!<br/>Search Person and Change Status");
            }else{
                failAlert("Something went wrong!");
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
                successAlert("Successfully Saved!");
                clear_form("form_save_dataContact");

                $('.form_save_dataContact').slideUp();
                $('.form_save_dataPrimary').slideDown();
                specifyContact(0);
            }else if(d.exist == true) {
                existAlert("Person already exist!<br/>Search Person and Change Status");
            }else{
                failAlert("Something went wrong!");
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

    //covid19_status();
  });


specifyPrimary(0);
specifyContact(0);


function specifyPrimary(a){
    if(a==44){
        $("#form_save_dataPrimary .specifyAgency").slideUp();
        $("#form_save_dataPrimary .specify,.specifyOffice").slideDown();
        $("#form_save_dataPrimary .category").removeClass('col-md-6').addClass('col-md-3');
    }else if(a==45){
        $("#form_save_dataPrimary .specifyOffice").slideUp();
        $("#form_save_dataPrimary .specify,.specifyAgency").slideDown();
        $("#form_save_dataPrimary .category").removeClass('col-md-6').addClass('col-md-3');
    }else{
        $("#form_save_dataPrimary .specify,.specifyAgency,.specifyOffice").slideUp();
        $("#form_save_dataPrimary .category").removeClass('col-md-3').addClass('col-md-6');
    }
}

function specifyContact(a){
    if(a==44){
        $("#form_save_dataContact .specifyAgency").slideUp();
        $("#form_save_dataContact .specify,.specifyOffice").slideDown();
        $("#form_save_dataContact .category").removeClass('col-md-6').addClass('col-md-3');
    }else if(a==45){
        $("#form_save_dataContact .specifyOffice").slideUp();
        $("#form_save_dataContact .specify,.specifyAgency").slideDown();
        $("#form_save_dataContact .category").removeClass('col-md-6').addClass('col-md-3');
    }else{
        $("#form_save_dataContact .specify,.specifyAgency,.specifyOffice").slideUp();
        $("#form_save_dataContact .category").removeClass('col-md-3').addClass('col-md-6');
    }
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
                                url: "<?= base_url('userhealthworker/Dataentry/getPersonCovidStatus') ?>",
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
                                url: "<?= base_url('userhealthworker/Dataentry/getPersonCovidTest') ?>",
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


    function tfoot(){
      if($('#tbl_entry tr').length>6){
        $('#tbl_entry_foot').show();
      }else{
        $('#tbl_entry_foot').hide();
      }
    }

  //chart5();
  
  function myContact(a){
    
    // $('#toTopContact').click(function() {
        //$("#toTopContact").animate({scrollTop: 0}, 500);
    // });
    $.post("<?= base_url() ?>" + "userhealthworker/Dataentry/getMyContact",{value:a},
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
    covid19_status();
  }

  function updateTest(a,b){
    $(".personTestId").val(a);
    $(".personTestName").val(b);
    covid19_test();
  }

  
  // $(".highcharts-root").css("font-family","arial");
  // $(".highcharts-data-labels").css("font-family","arial");
</script>