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
            <?= form_open(base_url('usertestvalidator/Dataentry/saveDataPrimary'), 'id=form_save_dataPrimary'); ?>
              <input type="" name="Pid" hidden>
              <div class="card card-lightblue">
                <div class="card-header">
                  <h3 class="card-title"><i class="fa fa-virus"></i> Primary Person Data Entry</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button> -->
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-2" style="overflow: auto;">

                  <label>PERONAL DATA</label>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-qrcode"></i><!--    <b><?= $getStatusCode ?>-</b> --></span>
                          </div>
                          <input type="text" class="form-control text-uppercase personCode" name="personCode"  placeholder="CODE" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                          </div>
                        <input type="text" class="form-control text-uppercase" name="firstName" placeholder="FIRST NAME" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-md-1 mb-2">
                        <input type="text" class="form-control text-uppercase" name="middleName" placeholder="M.I." autocomplete="off">
                    </div>
                    <div class="col-md-4 mb-2">
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
                        <input type="text" class="form-control text-uppercase" name="streetName" placeholder="STREET/PUROK/STREET/LOT NUMBER" autocomplete="off">
                    </div>
                  </div>

                  <div class="row">
                        <div class="col-md-6 category">
                             <label>CATEGORY</label>
                             <div class="input-group mb-2">
                                 <div class="input-group-prepend">
                                   <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                                 </div>
                                 <select class="form-control" name="categoryCOVID" onchange="specify($(this).val());">
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
                        <div class="col-md-3 update_qstatus">
                             <label>QUARANTINE STATUS</label>
                             <div class="input-group mb-2">
                                 <div class="input-group-prepend">
                                   <span class="input-group-text"><i class="fas fa-bed"></i></span>
                                 </div>
                                 <select class="form-control" name="qstatusCOVID">
                                   <?php foreach ($getStatus['data9'] as $key => $value): ?>
                                       <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                                   <?php endforeach ?>
                                 </select>
                             </div>
                        </div>
                        <div class="col-md-3 update_qstatus">
                             <label> </label>
                             <div class="input-group mb-2">
                                 <div class="input-group-prepend">
                                   <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                 </div>
                                 <input type="date" value="<?= Date('Y-m-d') ?>" class="form-control" name="qstatusDate">
                             </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                              <div class="col-md-6">
                                <label>TRAVEL HISTORY</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-plane"></i></span>
                                    </div>
                                    <input type="text" class="form-control text-uppercase" name="travelHistory" placeholder="MANILA, CHINA, CANADA, ..." autocomplete="off">
                                </div>
                              </div>
                              <div class="col-md-6">
                                   <label>ARRIVAL DATE</label>
                                   <div class="input-group mb-2">
                                     <div class="input-group-prepend">
                                       <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                     </div>
                                     <input type="date" class="form-control" name="dateArrival">
                                   </div>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-6 update_status">
                            <label>PERSON STATUS</label>
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
                        </div>
                  </div>

                  <label>OTHER DATA</label>
                  <div class="row">
                    <div class="col-md-6 update_contact">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend" style="width:100%;">
                            <span class="input-group-text"><i class="fas fa-handshake"></i></span>
                            <x class="selectPrimary2 hidden2">
                                <select class="form-control select8 selectPrimary" name="contactCode" style="width:200px;">
                                    <option value="">SELECT</option>
                                </select>
                            </x>
                            <input type="text" class="form-control text-uppercase" name="contactCodePerson" id="contactCodePerson" placeholder="ENTER LAST NAME / FIRST NAME" autocomplete="off">
                            <a class="btn btn-info btnViewContactT text-white"><i class="fa fa-search"></i></a>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6 update_contact">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend" style="width:100%;">
                            <span class="input-group-text"><i class="fas fa-heart"></i></span>
                            <select class="form-control select2" name="relation">
                              <option value=''>SELECT RELATION TO PRIMARY CONTACT</option>
                              <?php foreach ($getStatus['data2'] as $key => $value): ?>
                                  <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                    </div>
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

                   <div class="row update_test">
                     <div class="col-md-6">
                         <label>RAPID DIAGNOSTIC TEST</label>
                         <div class="row">
                           <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-vial"></i></span>
                                    </div>
                                    <select class="form-control" name="resultRDT">
                                        <option value=''>TEST RESULT</option>
                                        <?php foreach ($getStatus['data6'] as $key => $value): ?>
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
                                  <input type="date" class="form-control" name="dateRDT">
                                </div>
                           </div>

                            <div class="col-md-12">
                                <div class="input-group mb-2">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-head-side-cough"></i></span>
                                  </div>
                                  <select class="form-control" name="symptomsCOVIDRDT">
                                    <?php foreach ($getStatus['data5'] as $key => $value): ?>
                                        <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                                    <?php endforeach ?>
                                  </select>
                                </div>
                            </div>

                         </div>
                     </div>
                     <div class="col-md-6">
                         <label>POLYMERASE CHAIN REACTION</label>
                         <div class="row">
                           <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-vial"></i></span>
                                    </div>
                                    <select class="form-control" name="resultPCR">
                                        <option value=''>TEST RESULT</option>
                                        <?php foreach ($getStatus['data6'] as $key => $value): ?>
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
                                  <input type="date" class="form-control" name="datePCR">
                                </div>
                           </div>

                            <div class="col-md-12">
                                <div class="input-group mb-2">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-head-side-cough"></i></span>
                                  </div>
                                  <select class="form-control" name="symptomsCOVIDPCR">
                                    <?php foreach ($getStatus['data5'] as $key => $value): ?>
                                        <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                                    <?php endforeach ?>
                                  </select>
                                </div>
                            </div>

                         </div>
                     </div>
                   </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-info btn-sm submitBtnPrimary"><i class="fa fa-check"></i> Save Data</button>
                  <button type="button" class="btn btn-danger btn-sm form_save_dataPrimary_cncl hidden2" onclick="cancelBtn('form_save_dataPrimary')" ><i class="fa fa-times"></i> Cancel</button>
                </div>
              </div>
              <input type="" name="PidUpdate" hidden>
              <input type="" name="PCodeTemp" hidden>
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

              <div class="card-body p-2" style="overflow: auto;margin-right: 20px;white-space:nowrap; margin-right:0px;">

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
                                                <option value='2'>TEST</option>
                                                <option value='3'>STATUS</option>
                                                <option value='4'>CATEGORY</option>
                                                <option value='5'>QUARANTINE</option>
                                                <option value='6'>CODE</option>
                                                <option value='7'>NAME</option>
                                                <option value='8'>VIEW DUPLICATE DATA</option>
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
                  <form id='form_person'>
                    <table id="tbl_person_covid19" style="width:100%;" class="table table-bordered table-hover table-data-checkbox">
                      <thead>
                      <tr>
                        <th width="1"><div class="custom-control custom-checkbox ml-1">
                                            <input class="custom-control-input checkbox-toggle" type="checkbox" id="CheckAll">
                                            <label for="CheckAll" class="custom-control-label" style="cursor:pointer;"></label>
                                        </div>
                        </th>
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
                        <th width="1">Updated By</th>
                      </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </form>
                </div>

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
        var tbl_person_covid19, tbl_personCovid19_data;
            tbl_person_covid19 = $("#tbl_person_covid19").DataTable({
                                "order": [[1, "asc" ]],
                                "columnDefs": [ {
                                  "targets"  : [0],
                                  "orderable": false,
                                }],
                                dom: 'Bfrtip',
                                buttons: [
                                    'pageLength', 
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
                                    },{
                                        text: "<i class='fa fa-bed'></i> Quarantine",
                                        action: function(e, dt, node, config) {
                                            //clear_form("form_assign_personnel");
                                            validate_form2("tbl_person_covid19","batch_qstatus");
                                        }
                                    },{
                                        text: "<i class='fa fa-project-diagram'></i> Merge",
                                        action: function(e, dt, node, config) {
                                            validate_form2("tbl_person_covid19","batch_merge");
                                        }
                                    },{
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
                                // 'processing': true,
                                // 'serverSide': true,
                                // 'serverMethod': 'post',
                                ajax: {
                                    url: "<?= base_url('usertestvalidator/Dataentry/getPersonCovid') ?>",
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
                $("#saveConfirmation").modal("show");
            },
            success: function(data) {
                var d = JSON.parse(data);
                if(d.success == true){
                    successAlert("Successfully Saved!");
                    clear_form("form_save_dataPrimary");
                    $(".form_save_dataPrimary_cncl").hide();
                    specify(0);
                    showUpdate();
                }else if(d.exist == true) {
                    existAlert("Person already exist!<br/>You can search and add TEST RESULT");
                }else if(d.existCode == true) {
                    existAlert("Code already taken!<br/>by: "+d.existPerson);
                }else{
                    failAlert("Something went wrong!");
                }
                $(".submitBtnPrimary").attr("disabled", false);
                $(".submitBtnPrimary").html("<span class=\"fa fa-check\"></span> Save Data");
                $('#tbl_person_covid19').DataTable().ajax.reload();
            }
        };
        $("#form_save_dataPrimary").ajaxForm(save_primary);

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
                $(".submitBtnPersonCode").html("<span class=\"fa fa-check\"></span> Save Data");
            }
        };
        $("#form_save_dataCodeHistory").ajaxForm(save_personCode);

        var save_personContactTrace = {
            clearForm: false,
            resetForm: false,
            beforeSubmit: function(e) {
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
    });

    specify(0);


    $(".btnViewContactT").click(function(){
        if($(".btnViewContactT .fa").hasClass("fa-arrow-left")){
            $('#contactCodePerson').slideDown().focus();
            $('.selectPrimary2').slideUp();
            $(".btnViewContactT").html("<span class=\"fa fa-search\"></span>");
        }else{
            if($("#contactCodePerson").val().length<3){
                $('#contactCodePerson').focus().addClass('is-invalid');
                existAlert("Please enter an person name of at least 3 characters");
                $(".btnViewContactT").attr("disabled", false);
                $(".btnViewContactT").html("<span class=\"fa fa-search\"></span>");
            }else{
                getPrimaryContact();
            }
        }
    });


    function getContactTrace(form_id){
        if(!$('#'+form_id+' .personNameFilter').val()==1 || $('#'+form_id+' .personNameFilter').val().length<3){
            $('#'+form_id+' .personNameFilter').focus().addClass('is-invalid');
            existAlert("Please enter an person name of at least 3 characters");
        }
        
        if($('#'+form_id+' .personNameFilter').val()!="" && $('#'+form_id+' .personNameFilter').val().length>2){
            $('#'+form_id+' .personNameFilter').removeClass('is-invalid');
            var a = $('#'+form_id+' .personNameFilter,#'+form_id+' .personContactId,#'+form_id+' .personHasContact').serialize();
            $('#'+form_id+' #tbl_person_covid19_contact_trace').DataTable().destroy();
            $('#'+form_id+' #tbl_person_covid19_contact_trace tbody').empty();
            $.post("<?= base_url() ?>" + "usertestvalidator/Dataentry/getPersonCovidContactTrace",a,
                function(data) {
                    var result = JSON.parse(data);
                    for(var i=0;i<result["data"].length;i++){
                        $('#'+form_id+' #tbl_person_covid19_contact_trace').append("<tr><td>"+result["data"][i][0]+"</td>"+
                                                                          "<td>"+result["data"][i][1]+"</td>"+
                                                                          "<td>"+result["data"][i][2]+"</td>"+
                                                                          "<td>"+result["data"][i][3]+"</td></tr>");
                    }
                }
            ).done(function(){
                $('#'+form_id+' .searchBtnContact').attr('disabled', false);
                $('#'+form_id+' .searchBtnContact').html("<span class=\"fa fa-search\"></span>");
                $('#'+form_id+' #tbl_person_covid19_contact_trace').DataTable({"order": [[0, "asc" ]],
                                                                    "columnDefs": [ {
                                                                    "targets"  : [1],
                                                                    "orderable": false,
                                                                }],
                                                                "lengthChange": false,
                                                                "searching": true,
                                                                "info": true,
                                                                "autoWidth": false,
                                                                lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],});
            });
        }else{
            setTimeout(function(){
                $('#'+form_id+' .searchBtnContact').attr("disabled", false);
                $('#'+form_id+' .searchBtnContact').html("<span class=\"fa fa-search\"></span>");
            },500);
        }
    }

    function getPrimaryContact(){
        $(".selectPrimary").empty();
        a=$("#contactCodePerson").val();
        // $(".btnViewContactT").attr("disabled", true);
        // $(".btnViewContactT").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
        $('#contactCodePerson').focus().removeClass('is-invalid');
        $.post("<?= base_url() ?>" + "usertestvalidator/Dataentry/getPrimaryContact",{v:a},
            function(data) {
                var result = JSON.parse(data);
                $(".selectPrimary").append("<option value=''>SELECT PRIMARY CONTACT</option>");
                for(var i=0;i<result["data1"].length;i++){
                    $(".selectPrimary").append("<option value='"+result["data1"][i]['id']+"'>"+result["data1"][i]['text']+"</option>");
                }
                (result["data1"].length>1?$("#contactCodePerson").slideUp() && $(".selectPrimary2").slideDown() && $(".btnViewContactT").html("<span class=\"fa fa-arrow-left\"></span>"):$(".selectPrimary").empty() && failAlert("No data found!") && $("#contactCodePerson").slideDown() && $(".selectPrimary2").slideUp() && $(".btnViewContactT").html("<span class=\"fa fa-search\"></span>"));
            }
        ).done(function(){
            $(".select8").select2();
            $(".btnViewContactT").attr("disabled", false);
        });
    }
    
    function specify(a){
        if(a==44){
            $(".specifyAgency").slideUp();
            $(".specify,.specifyOffice").slideDown();
            $(".category").removeClass('col-md-6').addClass('col-md-3');
        }else if(a==45){
            $(".specifyOffice").slideUp();
            $(".specify,.specifyAgency").slideDown();
            $(".category").removeClass('col-md-6').addClass('col-md-3');
        }else{
            $(".specify,.specifyAgency,.specifyOffice").slideUp();
            $(".category").removeClass('col-md-3').addClass('col-md-6');
        }
    }

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
                                    url: "<?= base_url('usertestvalidator/Dataentry/getPersonCovidStatus') ?>",
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
                                    url: "<?= base_url('usertestvalidator/Dataentry/getPersonCovidTest') ?>",
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
                                    url: "<?= base_url('usertestvalidator/Dataentry/getPersonCovidQStatus') ?>",
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

    function batch_status(){
        pwd = $("#confirmPassword").val();
        var a = $("#form_person,#form_batch_dataStatusHistory").serialize();
        $.post("<?= base_url() ?>" + "usertestvalidator/Dataentry/batch_status",{b:a,pwdx:pwd},
            function(data) {
            var d = JSON.parse(data);
            if(d.pwd == false) {
                existAlert("Password Mismatch!");
            }else if(d.success == true) {
                successAlert("Successfully Saved!");
                $("#batch_status").modal("hide");
                $('#tbl_person_covid19').DataTable().ajax.reload();
                hideConf();
                uncheckMother();
            } else {
                failAlert("Something went wrong!");
            }
        }).done(function(){
            //setTimeout(function(){
            //},1000);
        });
    }

    function batch_test(){
        pwd = $("#confirmPassword").val();
        var a = $("#form_person,#form_batch_dataTestHistory").serialize();
        $.post("<?= base_url() ?>" + "usertestvalidator/Dataentry/batch_test",{b:a,pwdx:pwd},
            function(data) {
            var d = JSON.parse(data);
            if(d.pwd == false) {
                existAlert("Password Mismatch!");
            }else if(d.success == true) {
                successAlert("Successfully Saved!");
                $("#batch_test").modal("hide");
                $('#tbl_person_covid19').DataTable().ajax.reload();
                hideConf();
                uncheckMother();
            }   else {
                failAlert("Something went wrong!");
            }
        }).done(function(){
            //setTimeout(function(){
            //},1000);
        });
    }

    function batch_qstatus(){
        pwd = $("#confirmPassword").val();
        var a = $("#form_person,#form_batch_dataQStatusHistory").serialize();
        $.post("<?= base_url() ?>" + "usertestvalidator/Dataentry/batch_qstatus",{b:a,pwdx:pwd},
            function(data) {
            var d = JSON.parse(data);
            if(d.pwd == false) {
                existAlert("Password Mismatch!");
            }else if(d.success == true) {
                successAlert("Successfully Saved!");
                $("#batch_qstatus").modal("hide");
                $('#tbl_person_covid19').DataTable().ajax.reload();
                hideConf();
                uncheckMother();
            } else {
                failAlert("Something went wrong!");
            }
        }).done(function(){
            //},1000);
        });
    }


    function batch_merge(){
        pwd = $("#confirmPassword").val();
        var a = $("#form_person,#form_batch_dataMerge").serialize();
        $.post("<?= base_url() ?>" + "usertestvalidator/Dataentry/batch_merge",{b:a,pwdx:pwd},
            function(data) {
            var d = JSON.parse(data);
            if(d.pwd == false) {
                existAlert("Password Mismatch!");
            }else if(d.success == true) {
                $("#modal_selected_person_merge tbody").empty();
                $("#batch_merge").modal("hide");
                successAlert("Successfully Saved!");
                $("#batch_qstatus").modal("hide");
                $('#tbl_person_covid19').DataTable().ajax.reload();
                hideConf();
                uncheckMother();
            } else {
                failAlert("Something went wrong!");
            }
        }).done(function(){
            //},1000);
        });
    }


    function batch_rmv(){
        pwd = $("#confirmPassword").val();
        $.post("<?= base_url() ?>" + "usertestvalidator/Dataentry/batch_remove",{a:refrmvP,b:rmvP,c:stq,pwdx:pwd},
            function(data) {
            var d = JSON.parse(data);
            if(d.pwd == false) {
                existAlert("Password Mismatch!");
            }else if(d.success == true) {
                $("#statusHistory,#testHistory,#qstatusHistory").modal("hide");
                successAlert("Successfully Saved!");
                $("#batch_qstatus").modal("hide");
                $('#tbl_person_covid19').DataTable().ajax.reload();
                hideConf();
                uncheckMother();
            } else {
                failAlert("Something went wrong!");
            }
        }).done(function(){
            //},1000);
        });
    }

    var addEntyExist1 = [];

    function addEntry(a,b){
        if(validateEntryExist(a)==1){
        }else{
            entryId=entryId+1;
            $('#tbl_contact_trace tbody').append("<tr id='entry"+a+"'>"+
                "<td align='center'><a style='margin-top:5px;cursor:pointer;' class='btn btn-xs btn-danger text-white' onclick='removeEntry(\""+a+"\")'><span class='fa fa-times'></span></a></td>"+
                "<td><input type='text' value="+a+" name='contactTracePerson[]' id='contactTracePerson"+entryId+"' hidden><input type='text' value='"+b+"' class='form-control' readonly></td>"+
                "<td><select type='text' class='form-control select3' name='contactTraceRelation[]' id='contactTraceRelation"+entryId+"' style='width:100%;'>"+
                        "<?php foreach ($getStatus['data2'] as $key => $value): ?>"+
                            "<option value='<?= $value['id'] ?>' ><?= $value['text'] ?></option>"+
                        "<?php endforeach ?>"+
                    "</select></td>"+
            "</tr>");
            $('.select3').select2();
            $(".submitBtnContactPerson").slideDown();
        }
    }

    function addEntry2(a,b){
        if(validateEntryExist(a)==1){
        }else{
            entryId=entryId+1;
            $('#tbl_contact_trace2 tbody').append("<tr id='entry"+a+"'>"+
                "<td align='center'><a style='margin-top:5px;cursor:pointer;' class='btn btn-xs btn-danger text-white' onclick='removeEntry2(\""+a+"\")'><span class='fa fa-times'></span></a></td>"+
                "<td><input type='text' value="+a+" name='contactTracePerson[]' id='contactTracePerson"+entryId+"' hidden><input type='text' value='"+b+"' class='form-control' readonly></td>"+
                "<td><select type='text' class='form-control select4' name='contactTraceRelation[]' id='contactTraceRelation"+entryId+"' style='width:100%;'>"+
                        "<?php foreach ($getStatus['data2'] as $key => $value): ?>"+
                            "<option value='<?= $value['id'] ?>' ><?= $value['text'] ?></option>"+
                        "<?php endforeach ?>"+
                    "</select></td>"+
            "</tr>");
            $('.select4').select2();
            $(".submitBtnContactPerson2").slideDown();
        }
    }

    function removeEntry(b){
        $('#tbl_contact_trace tbody tr').each(function() {
        var id = this.id;
            if(id=="entry"+b){
                "entry"+this.remove();
                addEntyExist1.pop(b);
            }
        });

        if(addEntyExist1.length<1){
            $(".submitBtnContactPerson").slideUp();
        }
    }

    function removeEntry2(b){
        $('#tbl_contact_trace2 tbody tr').each(function() {
        var id = this.id;
            if(id=="entry"+b){
                "entry"+this.remove();
                addEntyExist1.pop(b);
            }
        });

        if(addEntyExist1.length<1){
            $(".submitBtnContactPerson2").slideUp();
        }
    }

    function removeAllEntry(){
        entryId=0;
        addEntyExist1 = [];
        $('#form_contact_tracing #tbl_contact_trace tbody').empty();
        $(".submitBtnContactPerson").slideUp();
        $('#form_contact_tracing #tbl_person_covid19_contact_trace tbody').empty();
    }

    function removeAllEntry2(){
        entryId=0;
        addEntyExist1 = [];
        $('#form_contact_tracing2 #tbl_contact_trace2 tbody').empty();
        $(".submitBtnContactPerson2").slideUp();
        $('#form_contact_tracing2 #tbl_person_covid19_contact_trace tbody').empty();
    }

    function validateEntryExist(ab){
        var ex = 0;
        var exist = addEntyExist1.includes(ab);
        if(exist==false){
            addEntyExist1.push(ab);
        }else{
            ex=1;
            existAlert("Person already exist!");
        }
        return ex;
    }


    function tfoot(){
          if($('#tbl_entry tr').length>6){
            $('#tbl_entry_foot').show();
          }else{
            $('#tbl_entry_foot').hide();
          }
    }

    function myContact(a,b){

        $("#form_contact_tracing2 .personContactId").val(a);
        $("#form_contact_tracing2 .personContactName").text(b);
        removeAllEntry2();
        
        // $('#toTopContact').click(function() {
            //$("#toTopContact").animate({scrollTop: 0}, 500);
        // });
        $.post("<?= base_url() ?>" + "usertestvalidator/Dataentry/getMyContact",{value:a},
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
      $('#form_save_dataStatusHistory .proceedStatus').val(0);
      covid19_status();
    }

    function updateTest(a,b){
      $(".personTestId").val(a);
      $(".personTestName").val(b);
      $('#form_save_dataTestHistory .proceedTest').val(0);
      covid19_test();
    }
    
    function updateQStatus(a,b){
      $(".personQStatusId").val(a);
      $(".personQStatusName").val(b);
      $('#form_save_dataQStatusHistory .proceedQStatus').val(0);
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
      removeAllEntry();
    }
</script>