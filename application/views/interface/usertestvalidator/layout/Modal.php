
<div class="modal fade" id="graphPresentation2">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <?= form_open(base_url('usertestvalidator/Dataentry/saveContactTracing'), 'id=form_contact_tracing'); ?>
          <div class="modal-header">
            <h5 class="modal-title"><i class="fa fa-sitemap"></i> Contact Tracing for <span class='badge bg-gradient-gray-dark text-md personContactName'></span></h5>
            <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <input type="text" class="personContactId" name="personContactId" hidden>
          <input type="text" class="personHasContact" name="personHasContact" value="0" hidden>
          <div class="modal-body p-1">

                <div class="card-body p-2" style="overflow: auto;margin-right: 20px;white-space:nowrap; margin-right:0px;">
                    <div class="card card-lightblue">
                        <div class="card-header p-2">
                          <h3 class="card-title"><i class="fa fa-search"></i> Find Contact Person
                          </h3>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-body p-2">
                            <div class="row">
                                  <div class="col-md-12">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" class="form-control text-uppercase personNameFilter" name="personNameFilter"  placeholder="SELECT LAST NAME / FIRST NAME" autocomplete="off">
                                            <div class="input-group-append">
                                              <button type="button" class="btn btn-warning btn-sm text-white searchBtnContact" onclick="getContactTrace('form_contact_tracing');$(this).html('<span class=\'fa fa-spinner fa-spin\'></span>');$(this).attr('disabled',true);"><i class="fas fa-search"></i></span></button>
                                            </div>
                                        </div>
                                  </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive mailbox-messages">
                        <table id="tbl_person_covid19_contact_trace" style="width:100%;" class="table table-bordered table-hover table-data-checkbox">
                          <thead>
                          <tr>
                            <th width="1">#</th>
                            <th width="1"><i class='fa fa-plus'></i></th>
                            <th width="1"><i class='fa fa-qrcode'></i> Code</th>
                            <th><i class='fa fa-user'></i> Name</th>
                          </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                    </div>
                </div>

                <div class="table-responsive mailbox-messages" style="overflow: hidden;">
                    <table class="table table-hover table-striped" id="tbl_contact_trace" width="100%">
                        <thead>
                          <th width="1"></th>
                          <th>Person</th>
                          <th>Relation</th>
                        </thead>
                      <tbody>
                      </tbody>
                    </table>
                </div>

          </div>
          <div class="modal-footer justify-content-between">
              <button type="submit" class="btn btn-info btn-sm submitBtnContactPerson hidden2"><i class="fa fa-check"></i> Save Data</button>
              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
          </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="graphPresentation">
  <div class="modal-dialog modal-xl">
    <div class="modal-content bg-dark">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-chart-bar"></i> Graphical Presentation</h4>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pb-0" style="overflow: auto;">
            <div id="myContact" style="min-width:100%; height: auto;margin:-15px;padding-bottom:20px;"></div><br/>

            <div class="col-md-12 p-0">
                <?= form_open(base_url('usertestvalidator/Dataentry/saveContactTracing'), 'id=form_contact_tracing2'); ?>
                <div class="card card-lightblue">
                    <div class="card-header">
                      <h3 class="card-title"><i class="fa fa-sitemap"></i> Add New Contact for <span class='badge bg-gradient-gray-dark text-md personContactName'></span></h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool clickMeToHideContact" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button> -->
                      </div>
                    </div>
                    <input type="text" class="personContactId" name="personContactId" hidden>
                    <input type="text" class="personHasContact" name="personHasContact" value="1" hidden>
                    <div class="card-body p-1">
                        <div class="card-body p-2" style="overflow: auto;margin-right: 20px;white-space:nowrap; margin-right:0px;">
                            <div class="card card-lightblue">
                                <div class="card-header p-2">
                                  <h3 class="card-title"><i class="fa fa-search"></i> Find Contact Person
                                  </h3>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-body p-2">
                                    <div class="row">
                                          <div class="col-md-12">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control text-uppercase personNameFilter" name="personNameFilter"  placeholder="ENTER LAST NAME / FIRST NAME" autocomplete="off">
                                                    <div class="input-group-append">
                                                      <button type="button" class="btn btn-warning btn-sm text-white searchBtnContact" onclick="getContactTrace('form_contact_tracing2');$(this).html('<span class=\'fa fa-spinner fa-spin\'></span>');$(this).attr('disabled',true);"><i class="fas fa-search"></i></span></button>
                                                    </div>
                                                </div>
                                          </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="table-responsive mailbox-messages">
                                <table id="tbl_person_covid19_contact_trace" style="width:100%;color:black;" class="table table-bordered table-hover table-data-checkbox">
                                  <thead>
                                  <tr>
                                    <th width="1">#</th>
                                    <th width="1"><i class='fa fa-plus'></i></th>
                                    <th width="1"><i class='fa fa-qrcode'></i> Code</th>
                                    <th><i class='fa fa-user'></i> Name</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="table-responsive mailbox-messages" style="overflow: hidden;color:black;">
                            <table class="table table-hover table-striped" id="tbl_contact_trace2" width="100%">
                                <thead>
                                  <th width="1"></th>
                                  <th>Person</th>
                                  <th>Relation</th>
                                </thead>
                              <tbody>
                              </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-info btn-sm submitBtnContactPerson2 hidden2"><i class="fa fa-check"></i> Save Data</button>
                    </div>
                </div>
                </form>
            </div>

        </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="statusHistory">
  <div class="modal-dialog modal-lg">
    <?= form_open(base_url('usertestvalidator/Dataentry/saveDataStatusHistory'), 'id=form_save_dataStatusHistory'); ?>
      <div class="modal-content bg-default">
        <div class="modal-header">
          <h6 class="modal-title"><i class="fa fa-viruses"></i> Status History</h6>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pb-0" style="overflow: auto;">
          
            <input class="personStatusId" name="personStatusId" hidden value="1">
            <input class="proceedStatus" name="proceedStatus" hidden value="0">
                
            <div class="row">
              <div class="col-md-12">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-xs"><i class="fas fa-user"></i></span>
                    </div>
                    <input class="form-control form-control-sm personStatusName" type="text" readonly id="personStatusName">
                </div>
              </div>
              <div class="col-md-12">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-virus"></i></span>
                    </div>
                    <select class="form-control form-control-sm" name="statusCOVID">
                      <?php foreach ($getStatus['data1'] as $key => $value): ?>
                          <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                      <?php endforeach ?>
                    </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                    <input type="date" value="<?= Date('Y-m-d') ?>" class="form-control form-control-sm" name="dateEntried">
                </div>
              </div>
            </div>

            <table id="tbl_person_covid19_status" style="width:100%;" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th width="1">#</th>
                <th>Status</th>
                <th width="1">Date</th>
                <th width="1">Encoded By</th>
                <th width="1">Encoded Date</th>
                <th width="1"></th>
              </tr>
              </thead>
              <tbody>
              </tbody>
            </table>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-info btn-sm submitBtnStatusHistory"><i class="fa fa-check"></i> Save Data</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
        </div>
      </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="batch_status">
  <div class="modal-dialog">
    <form id="form_batch_dataStatusHistory">
      <div class="modal-content bg-default">
        <div class="modal-header">
          <h6 class="modal-title"><i class="fa fa-viruses"></i> Status</h6>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pb-0" style="overflow: auto;">
                
            <div class="row">

              <div class="col-md-12">
                 <p id="modal_selected_person"></p>
              </div>

              <div class="col-md-12">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-virus"></i></span>
                    </div>
                    <select class="form-control form-control-sm" name="statusCOVID">
                      <?php foreach ($getStatus['data1'] as $key => $value): ?>
                          <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                      <?php endforeach ?>
                    </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                    <input type="date" value="<?= Date('Y-m-d') ?>" class="form-control form-control-sm" name="dateEntried">
                </div>
              </div>
            </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-info btn-sm" onclick="showMdl('status');"><i class="fa fa-check"></i> Save Data</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
        </div>
      </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="testHistory">
  <div class="modal-dialog modal-lg">
    <?= form_open(base_url('usertestvalidator/Dataentry/saveDataTestHistory'), 'id=form_save_dataTestHistory'); ?>
      <div class="modal-content bg-default">
        <div class="modal-header">
          <h6 class="modal-title"><i class="fa fa-vials"></i> Test History</h6>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pb-0" style="overflow: auto;">
          
            <input class="personTestId" name="personTestId" hidden value="1">
            <input class="proceedTest" name="proceedTest" hidden value="0">
                
            <div class="row">
              <div class="col-md-12">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-xs"><i class="fas fa-user"></i></span>
                    </div>
                    <input class="form-control form-control-sm personTestName" type="text" readonly id="personTestName">
                </div>
              </div>
              <div class="col-md-12">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-vial"></i></span>
                    </div>
                    <select class="form-control form-control-sm" name="testCOVID">
                      <?php foreach ($getStatus['data4'] as $key => $value): ?>
                          <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                      <?php endforeach ?>
                    </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                    </div>
                    <select class="form-control form-control-sm" name="resultCOVID">
                      <?php foreach ($getStatus['data6'] as $key => $value): ?>
                          <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                      <?php endforeach ?>
                    </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-head-side-cough"></i></span>
                  </div>
                  <select class="form-control form-control-sm" name="symptomsCOVID">
                    <?php foreach ($getStatus['data5'] as $key => $value): ?>
                        <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                    <input type="date" value="<?= Date('Y-m-d') ?>" class="form-control form-control-sm" name="dateEntried">
                </div>
              </div>
            </div>

            <table id="tbl_person_covid19_test" style="width:100%;" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th width="1">#</th>
                <th width="1">Test</th>
                <th width="1">Result</th>
                <th width="1"><i class="fas fa-head-side-cough"></i></th>
                <th width="1">Date</th>
                <th width="1">Encoded By</th>
                <th width="1">Encoded Date</th>
                <th width="1"></th>
              </tr>
              </thead>
              <tbody>
              </tbody>
            </table>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-info btn-sm submitBtnTestHistory"><i class="fa fa-check"></i> Save Data</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
        </div>
      </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="batch_test">
  <div class="modal-dialog">
    <form id="form_batch_dataTestHistory">
      <div class="modal-content bg-default">
        <div class="modal-header">
          <h6 class="modal-title"><i class="fa fa-vials"></i> Test History</h6>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pb-0" style="overflow: auto;">
            <div class="row">
                
              <div class="col-md-12">
                 <p id="modal_selected_person"></p>
              </div>
              <div class="col-md-12">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-vial"></i></span>
                    </div>
                    <select class="form-control form-control-sm" name="testCOVID">
                      <?php foreach ($getStatus['data4'] as $key => $value): ?>
                          <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                      <?php endforeach ?>
                    </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                    </div>
                    <select class="form-control form-control-sm" name="resultCOVID">
                      <?php foreach ($getStatus['data6'] as $key => $value): ?>
                          <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                      <?php endforeach ?>
                    </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-head-side-cough"></i></span>
                  </div>
                  <select class="form-control form-control-sm" name="symptomsCOVID">
                    <?php foreach ($getStatus['data5'] as $key => $value): ?>
                        <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                    <input type="date" value="<?= Date('Y-m-d') ?>" class="form-control form-control-sm" name="dateEntried">
                </div>
              </div>
            </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-info btn-sm" onclick="showMdl('test');"><i class="fa fa-check"></i> Save Data</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
        </div>
      </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="qstatusHistory">
  <div class="modal-dialog modal-lg">
    <?= form_open(base_url('usertestvalidator/Dataentry/saveDataQStatusHistory'), 'id=form_save_dataQStatusHistory'); ?>
      <div class="modal-content bg-default">
        <div class="modal-header">
          <h6 class="modal-title"><i class="fa fa-bed"></i> Quarantine Status History</h6>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pb-0" style="overflow: auto;">
          
            <input class="personQStatusId" name="personQStatusId" hidden value="1">
            <input class="proceedQStatus" name="proceedQStatus" hidden value="0">
                
            <div class="row">
              <div class="col-md-12">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-xs"><i class="fas fa-user"></i></span>
                    </div>
                    <input class="form-control form-control-sm personQStatusName" type="text" readonly id="personQStatusName">
                </div>
              </div>
              <div class="col-md-12">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-vial"></i></span>
                    </div>
                    <select class="form-control form-control-sm" name="qstatusCOVID">
                      <?php foreach ($getStatus['data9'] as $key => $value): ?>
                          <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                      <?php endforeach ?>
                    </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                    <input type="date" value="<?= Date('Y-m-d') ?>" class="form-control form-control-sm" name="dateEntried">
                </div>
              </div>
            </div>

            <table id="tbl_person_covid19_qstatus" width="100%" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th width="1">#</th>
                <th width="1">Quarantine</th>
                <th width="1">Date</th>
                <th width="1">Encoded By</th>
                <th width="1">Encoded Date</th>
                <th width="1"></th>
              </tr>
              </thead>
              <tbody>
              </tbody>
            </table>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-info btn-sm submitBtnQStatusHistory"><i class="fa fa-check"></i> Save Data</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
        </div>
      </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="batch_qstatus">
  <div class="modal-dialog">
    <form id="form_batch_dataQStatusHistory">
      <div class="modal-content bg-default">
        <div class="modal-header">
          <h6 class="modal-title"><i class="fa fa-bed"></i> Quarantine Status</h6>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pb-0" style="overflow: auto;">
                
            <div class="row">

              <div class="col-md-12">
                 <p id="modal_selected_person"></p>
              </div>

              <div class="col-md-12">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-vial"></i></span>
                    </div>
                    <select class="form-control form-control-sm" name="qstatusCOVID">
                      <?php foreach ($getStatus['data9'] as $key => $value): ?>
                          <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                      <?php endforeach ?>
                    </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                    <input type="date" value="<?= Date('Y-m-d') ?>" class="form-control form-control-sm" name="dateEntried">
                </div>
              </div>

            </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-info btn-sm" onclick="showMdl('qstatus');"><i class="fa fa-check"></i> Save Data</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
        </div>
      </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="batch_merge">
  <div class="modal-dialog">
    <form id="form_batch_dataMerge">
      <div class="modal-content bg-default">
        <div class="modal-header">
          <h6 class="modal-title"><i class="fa fa-project-diagram"></i> Merge</h6>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pb-0" style="overflow: auto;">
                
            <div class="row">

                <div class="col-md-12">
                    <table id="modal_selected_person_merge" style="width:100%;" class="table table-bordered table-hover table-data-checkbox">
                        <thead>
                            <tr>
                                <th width="1"></th>
                                <th><i class='fa fa-user'></i> Name</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-info btn-sm" onclick="showMdl('merge');"><i class="fa fa-check"></i> Merge Person</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
        </div>
      </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="codeHistory">
  <div class="modal-dialog modal-sm">
    <?= form_open(base_url('usertestvalidator/Dataentry/saveDataCodeHistory'), 'id=form_save_dataCodeHistory'); ?>
      <div class="modal-content bg-default">
        <div class="modal-header">
          <h6 class="modal-title"><i class="fa fa-qrcode"></i> Code Assignment</h6>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pb-0" style="overflow: auto;">
          
            <input class="personCodeId" name="personCodeId" hidden value="1">
                
            <div class="row">
              <div class="col-md-12">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-xs"><i class="fas fa-user"></i></span>
                    </div>
                    <input class="form-control form-control-sm personCodeName" type="text" readonly id="personCodeName">
                </div>
              </div>
              <div class="col-md-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-qrcode"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm text-uppercase modalPersonCode" name="modalPersonCode" autocomplete="off">
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-info btn-sm submitBtnPersonCode"><i class="fa fa-check"></i> Save Data</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
        </div>
      </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="batch_append">
  <div class="modal-dialog">
    <form id="form_batch_append">
      <div class="modal-content bg-default">
        <div class="modal-header">
          <h6 class="modal-title"><i class="fa fa-plus"></i> Append Existing Data</h6>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pb-0" style="overflow: auto;">
                
            <div class="row">
              <div class="col-md-12">
                 
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-info"></i> Note</h5>
                  Only <b>Status</b> and <b>Test Result</b> may append to the Person's data, other data will still remain.
                </div>
                 <p id="modal_selected_person"></p>
              </div>

            </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-info btn-sm btn_batch_append" onclick="batch_append();"><i class="fa fa-check"></i> Append Confirmation</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
        </div>
      </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="batch_remove">
  <div class="modal-dialog">
    <form id="form_batch_remove">
      <div class="modal-content bg-default">
        <div class="modal-header bg-danger">
          <h6 class="modal-title"><i class="fa fa-trash"></i> Remove Existing Data</h6>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pb-0" style="overflow: auto;">
                
            <div class="row">
              <div class="col-md-12">
                 
                <!-- <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-info"></i> Note</h5>
                  Only <b>Status</b> and <b>Test Result</b> may append to the Person's data, other data will still remain.
                </div> -->
                 <p id="modal_selected_person"></p>
              </div>

            </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-info btn-sm btn_batch_remove" onclick="batch_remove();"><i class="fa fa-check"></i> Remove Confirmation</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
        </div>
      </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="graphAnalytics">
  <div class="modal-dialog modal-xl">
    <div class="modal-content bg-dark">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-chart-bar"></i> Graphical Presentation</h4>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pb-0">
        <div id="chart5" style="min-width: 100%; height: auto;margin:-15px;"></div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="testHistoryDateDuplicate">
  <div class="modal-dialog modal-sm">

      <div class="modal-content bg-default">
        <div class="modal-header">
          <h6 class="modal-title"><i class="fa fa-vial"></i> Test History</h6>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pb-0" style="overflow: auto;">
          
            <div class="row">
              <div class="col-md-12">
                <div class="alert alert-info text-white">
                  <h5><i class="icon fas fa-info"></i> Duplicate Date</h5>
                  The System detected Duplicate Test Date. <b>Would you like to proceed?</b>
                </div>
              </div>

            </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-success btn-sm submitBtnTestHistoryProceed"><i class="fa fa-check"></i> Proceed</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
        </div>
      </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="statusHistoryDateDuplicate">
  <div class="modal-dialog modal-sm">

      <div class="modal-content bg-default">
        <div class="modal-header">
          <h6 class="modal-title"><i class="fa fa-virus"></i> Status History</h6>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pb-0" style="overflow: auto;">
          
            <div class="row">
              <div class="col-md-12">
                <div class="alert alert-info text-white">
                  <h5><i class="icon fas fa-info"></i> Duplicate Date</h5>
                  The System detected Duplicate Status Date. <b>Would you like to proceed?</b>
                </div>
              </div>

            </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-success btn-sm submitBtnStatusHistoryProceed"><i class="fa fa-check"></i> Proceed</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
        </div>
      </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="qstatusHistoryDateDuplicate">
  <div class="modal-dialog modal-sm">

      <div class="modal-content bg-default">
        <div class="modal-header">
          <h6 class="modal-title"><i class="fa fa-bed"></i> Quarantine Status History</h6>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pb-0" style="overflow: auto;">
          
            <div class="row">
              <div class="col-md-12">
                <div class="alert alert-info text-white">
                  <h5><i class="icon fas fa-info"></i> Duplicate Date</h5>
                  The System detected Duplicate Quarantine Status Date. <b>Would you like to proceed?</b>
                </div>
              </div>

            </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-success btn-sm submitBtnQStatusHistoryProceed"><i class="fa fa-check"></i> Proceed</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
        </div>
      </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>



<div class="modal fade" id="modal_test_report">
  <div class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header no-print">
              <div  class='radioBtn btn-group pull-right'>
                  <a href="#" onclick="printForm('print_test_report','p','Letter');" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-print"></i> Print</a>
                  <!-- <a href="#" onclick="downloadExcel('tbl_test_reportExp','City Health Office');" class="btn btn-primary btn-sm"><i class="fa fa-file-excel-o"></i> Export</a> -->
                  <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i></button>
              </div>
              <h4 class="modal-title">Test Results</h4>
          </div>
          <div class="modal-body" id="print_test_report">
              <!-- Main content -->
              
              <div class="table-responsive mailbox-messages" style="overflow: hidden;">
                    <div class="col-md-12">
                      <table border="0" width="100%" style="font-size:13px;">
                            <tr style="text-align:center;border:1px solid white;">
                              <td width="1" style="padding-right:5px;">
                                <img src="<?= $system_logo ?>" width="52" height="52">
                              </td>
                              <td>
                                <?php $this->load->view('interface/usertestvalidator/layout/Report_header')?>
                              </td>
                            </tr>
                      </table><br/>
                      <!-- <small class="total_service">Total: </small> -->
                      <table cellspacing="0" cellpadding="0" border="1" id="tbl_test_report" width="100%" style="font-size: 12px;border:.5px solid gray">
                          <thead>
                            <th width="1">#</th>
                            <th width="1">CATEGORY</th>
                            <th width="1">CODE</th>
                            <th>NAME</th>
                            <th width="1">SEX</th>
                            <th width="1">AGE</th>
                            <th>BARANGAY</th>
                            <th width="1">TEST</th>
                            <th width="1">RESULT</th>
                            <th width="1" style="font-size:10px;">RESULT DATE</th>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                      <!-- <table cellspacing="0" cellpadding="0" border="1" id="tbl_test_reportExp" width="100%" style="font-size: 12px;border:.5px solid gray" hidden>
                          <thead>
                              <th colspan="2" align="center">
                                  <div class="text-center">
                                      <center><img src="<?= $butuan_logo ?>" align="right" width="70" height="70"></center>
                                  </div>
                              </th>
                              <th colspan="4" class="text-center">
                                  <div class="text-center">
                                      <h2 class="page-header text-center" style="font-size:12px;padding-bottom:0px;">
                                          <center>
                                              Republic of the Philippines<br/><strong>OFFICE OF THE CITY HEALTH OFFICER</strong><br/>Barangay Tiniwisan, Butuan City<br>Agusan del Norte, 8600
                                          </center>
                                          <center class="certificationHeader" id="certificationHeader"></center>
                                      </h2>
                                  </div>
                              </th>
                              <th colspan="2" align="center">
                                  <div class="text-center">
                                      <center><img src="<?= $cho_logo ?>" align="left" width="70" height="70"></center>
                                  </div>
                              </th>
                          </thead>
                          <thead>
                            <th width="1"><b>#</b></th>
                            <th width="1" align="center"><center><b>Date</b><b class="certificateTable">|Certificate</center></th>
                            <th width="1" align="center"><center><b>Name</b></center></th>
                            <th width="1" align="center"><center><b>Age</b></center></th>
                            <th width="1" align="center"><center><b>Sex</b></center></th>
                            <th width="1" align="center"><center><b>Establishment</b></center></th>
                            <th width="1" align="center"><center><b>Type</b></center></th>
                            <th width="1" align="center"><center><b>OR Number</b></center></th>
                          </thead>
                        <tbody>
                        </tbody>
                      </table> -->
                      <!-- /.table -->
                    </div>
                    <div class="row" style="width:97%;">
                        <div class="col-md-4">
                          <small>Summary</small>
                          <table cellspacing="0" cellpadding="0" border="1" id="tbl_summary_test_category" width="100%" style="font-size: 12px;border:.5px solid gray">
                            <thead style="font-weight: bold;">
                                <tr>
                                    <td rowspan="2" align="center">CATEGORY</td>
                                    <td width="1" colspan="2" align="center">RDT</td>
                                    <td width="1" colspan="2" align="center">PCR</td>
                                    <td rowspan="2" width="1" align="center">TOTAL</td>
                                </tr>
                                <tr style="padding:0px;">
                                    <td width="1" align="center" style="text-align:center;">-</td>
                                    <td width="1" align="center" style="text-align:center;">+</td>
                                    <td width="1" align="center" style="text-align:center;">-</td>
                                    <td width="1" align="center" style="text-align:center;">+</td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-md-3">
                          <small> </small>
                          <table cellspacing="0" cellpadding="0" border="1" id="tbl_summary_test_gender" width="100%" style="font-size: 12px;border:.5px solid gray">
                            <thead style="font-weight: bold;">
                                <tr>
                                    <td rowspan="2" align="center">GENDER</td>
                                    <td width="1" colspan="2" align="center">RDT</td>
                                    <td width="1" colspan="2" align="center">PCR</td>
                                    <td rowspan="2" width="1" align="center">TOTAL</td>
                                </tr>
                                <tr style="padding:0px;">
                                    <td width="1" align="center" style="text-align:center;">-</td>
                                    <td width="1" align="center" style="text-align:center;">+</td>
                                    <td width="1" align="center" style="text-align:center;">-</td>
                                    <td width="1" align="center" style="text-align:center;">+</td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-md-3">
                          <small> </small>
                          <table cellspacing="0" cellpadding="0" border="1" id="tbl_summary_test_barangay" width="100%" style="font-size: 12px;border:.5px solid gray">
                            <thead style="font-weight: bold;">
                                <tr>
                                    <td rowspan="2" align="center">BARANGAY</td>
                                    <td width="1" colspan="2" align="center">RDT</td>
                                    <td width="1" colspan="2" align="center">PCR</td>
                                    <td rowspan="2" width="1" align="center">TOTAL</td>
                                </tr>
                                <tr style="padding:0px;">
                                    <td width="1" align="center" style="text-align:center;">-</td>
                                    <td width="1" align="center" style="text-align:center;">+</td>
                                    <td width="1" align="center" style="text-align:center;">-</td>
                                    <td width="1" align="center" style="text-align:center;">+</td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-md-2">
                          <small> </small>
                          <table cellspacing="0" cellpadding="0" border="1" id="tbl_summary_test_age" width="100%" style="font-size: 12px;border:.5px solid gray">
                            <thead style="font-weight: bold;">
                                <tr>
                                    <td rowspan="2" align="center" width="1">AGE</td>
                                    <td width="1" colspan="2" align="center">RDT</td>
                                    <td width="1" colspan="2" align="center">PCR</td>
                                    <td rowspan="2" width="1" align="center">TOTAL</td>
                                </tr>
                                <tr style="padding:0px;">
                                    <td width="1" align="center" style="text-align:center;">-</td>
                                    <td width="1" align="center" style="text-align:center;">+</td>
                                    <td width="1" align="center" style="text-align:center;">-</td>
                                    <td width="1" align="center" style="text-align:center;">+</td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                        </div>
                    </div>
                  <!-- <div class="col-xs-3">
                      <small> </small>
                      <table cellspacing="0" cellpadding="0" border="1" id="tbl_summary_test_barangay" width="100%" style="font-size: 12px;border:.5px solid gray">
                        <tbody>
                        </tbody>
                      </table>
                  </div> -->
              </div>
          </div>
          <div class="modal-footer no-print">
              <a href="#" onclick="printForm('print_test_report','p','Letter');" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-print"></i> Print</a>
              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i></button>
          </div>
      </div>
      <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal_status_report">
  <div class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header no-print">
              <div  class='radioBtn btn-group pull-right'>
                  <a href="#" onclick="printForm('print_status_report','p','Letter');" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-print"></i> Print</a>
                  <!-- <a href="#" onclick="downloadExcel('tbl_status_reportExp','City Health Office');" class="btn btn-primary btn-sm"><i class="fa fa-file-excel-o"></i> Export</a> -->
                  <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i></button>
              </div>
              <h4 class="modal-title">COVID 19 Status</h4>
          </div>
          <div class="modal-body" id="print_status_report">
              <!-- Main content -->
              
              <!-- <div class="table-responsive mailbox-messages"> -->
                  <div class="col-xs-12">

                      <table border="0" width="100%" style="font-size:13px;">
                            <tr style="text-align:center;border:1px solid white;">
                              <td width="1">
                                <img src="<?= $system_logo ?>" width="52" height="52">
                              </td>
                              <td>
                                <?php $this->load->view('interface/usertestvalidator/layout/Report_header')?>
                              </td>
                            </tr>
                      </table><br/>
                      <!-- <small class="total_service">Total: </small> -->
                      <table cellspacing="0" cellpadding="0" border="1" id="tbl_status_report" width="100%" style="font-size: 12px;border:.5px solid gray">
                          <thead>
                            <th width="1">#</th>
                            <th width="1">CATEGORY</th>
                            <th width="1">CODE</th>
                            <th>NAME</th>
                            <th width="1">SEX</th>
                            <th width="1">AGE</th>
                            <th>BARANGAY</th>
                            <th width="1">STATUS</th>
                            <th width="1">DATE</th>
                            <th width="1">QUARANTINE STATUS</th>
                            <th width="1">DATE</th>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                      <!-- <table cellspacing="0" cellpadding="0" border="1" id="tbl_status_reportExp" width="100%" style="font-size: 12px;border:.5px solid gray" hidden>
                          <thead>
                              <th colspan="2" align="center">
                                  <div class="text-center">
                                      <center><img src="<?= $butuan_logo ?>" align="right" width="70" height="70"></center>
                                  </div>
                              </th>
                              <th colspan="4" class="text-center">
                                  <div class="text-center">
                                      <h2 class="page-header text-center" style="font-size:12px;padding-bottom:0px;">
                                          <center>
                                              Republic of the Philippines<br/><strong>OFFICE OF THE CITY HEALTH OFFICER</strong><br/>Barangay Tiniwisan, Butuan City<br>Agusan del Norte, 8600
                                          </center>
                                          <center class="certificationHeader" id="certificationHeader"></center>
                                      </h2>
                                  </div>
                              </th>
                              <th colspan="2" align="center">
                                  <div class="text-center">
                                      <center><img src="<?= $cho_logo ?>" align="left" width="70" height="70"></center>
                                  </div>
                              </th>
                          </thead>
                          <thead>
                            <th width="1"><b>#</b></th>
                            <th width="1" align="center"><center><b>Date</b><b class="certificateTable">|Certificate</center></th>
                            <th width="1" align="center"><center><b>Name</b></center></th>
                            <th width="1" align="center"><center><b>Age</b></center></th>
                            <th width="1" align="center"><center><b>Sex</b></center></th>
                            <th width="1" align="center"><center><b>Establishment</b></center></th>
                            <th width="1" align="center"><center><b>Type</b></center></th>
                            <th width="1" align="center"><center><b>OR Number</b></center></th>
                          </thead>
                        <tbody>
                        </tbody>
                      </table> -->
                      <!-- /.table -->
                  </div>
                  <!-- <div class="col-xs-3">
                      <small>Summary</small>
                      <table cellspacing="0" cellpadding="0" border="1" id="tbl_certificate_summary" width="100%" style="font-size: 12px;border:.5px solid gray">
                        <tbody>
                        </tbody>
                      </table>
                  </div>
                  <div class="col-xs-3">
                      <small> </small>
                      <table cellspacing="0" cellpadding="0" border="1" id="tbl_certificate_summary_certficate" width="100%" style="font-size: 12px;border:.5px solid gray">
                        <tbody>
                        </tbody>
                      </table>
                  </div>
                  <div class="col-xs-3">
                      <small> </small>
                      <table cellspacing="0" cellpadding="0" border="1" id="tbl_certificate_summary_establishment" width="100%" style="font-size: 12px;border:.5px solid gray">
                        <tbody>
                        </tbody>
                      </table>
                  </div> -->
                  
              <!-- </div> -->
          </div>
          <div class="modal-footer no-print">
              <a href="#" onclick="printForm('print_status_report','p','A4');" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-print"></i> Print</a>
              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i></button>
          </div>
      </div>
      <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="confirmUser">
    <div class="modal-dialog modal-sm">
        <div class="modal-content bg-default">
            <div class="modal-header">
                <h6 class="modal-title"><i class="fa fa-lock"></i> User Confirmation</h6>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="overflow: auto;">
                <input type="password" name="" class="form-control" placeholder="PASSWORD" id="confirmPassword">
            </div>
            <!-- <div class="modal-footer justify-content-between">
              <button type="submit" class="btn btn-info btn-sm submitBtnStatusHistory"><i class="fa fa-check"></i> Save Data</button>
              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div> -->
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>