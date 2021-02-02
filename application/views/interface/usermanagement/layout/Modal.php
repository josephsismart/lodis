<div class="modal fade" id="graphPresentation2">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <?= form_open(base_url('usermanagement/Dataentry/saveContactTracing'), 'id=form_contact_tracing'); ?>
          <div class="modal-header">
            <h5 class="modal-title"><i class="fa fa-sitemap"></i> Contact Tracing for <span class='badge bg-gradient-gray-dark text-md personContactName'></span></h5>
            <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <input type="text" class="personContactId" name="personContactId" hidden>
          <div class="modal-body p-1">

                <div class="table-responsive mailbox-messages" style="overflow: hidden;">
                    <table class="table table-hover table-striped" id="tbl_contact_trace" width="100%">
                        <thead>
                          <th width="1"><a style="cursor:pointer;" class="btn btn-success btn-xs text-white addEntry" title="Add" onclick="addEntry();"><i class="fa fa-plus"></i></a></th>
                          <th>Person</th>
                          <th>Relation</th>
                        </thead>
                      <tbody>
                      </tbody>
                    </table>
                </div>

          </div>
          <div class="modal-footer justify-content-between">
              <button type="submit" class="btn btn-info btn-sm submitBtnContactPerson"><i class="fa fa-check"></i> Save Data</button>
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
    <?= form_open(base_url('usermanagement/Dataentry/saveDataStatusHistory'), 'id=form_save_dataStatusHistory'); ?>
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
          <button type="button" class="btn btn-info btn-sm" onclick="batch_status();"><i class="fa fa-check"></i> Save Data</button>
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
    <?= form_open(base_url('usermanagement/Dataentry/saveDataTestHistory'), 'id=form_save_dataTestHistory'); ?>
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
                <th>Test</th>
                <th width="1">Result</th>
                <th width="1">Date</th>
                <th width="1">Encoded By</th>
                <th width="1">Encoded Date</th>
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
          <button type="button" class="btn btn-info btn-sm" onclick="batch_test();"><i class="fa fa-check"></i> Save Data</button>
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
    <?= form_open(base_url('usermanagement/Dataentry/saveDataQStatusHistory'), 'id=form_save_dataQStatusHistory'); ?>
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
                <th>Quarantine</th>
                <th width="1">Date</th>
                <th width="1">Encoded By</th>
                <th width="1">Encoded Date</th>
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
          <button type="button" class="btn btn-info btn-sm" onclick="batch_qstatus();"><i class="fa fa-check"></i> Save Data</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
        </div>
      </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="codeHistory">
  <div class="modal-dialog modal-sm">
    <?= form_open(base_url('usermanagement/Dataentry/saveDataCodeHistory'), 'id=form_save_dataCodeHistory'); ?>
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