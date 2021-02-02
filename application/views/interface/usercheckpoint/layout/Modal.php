<div class="modal fade" id="personExist">
  <div class="modal-dialog modal-lg">
      <div class="modal-content bg-default">
        <div class="modal-header bg-info">
          <h6 class="modal-title"><i class="fa fa-user"></i> An existing data found. You can add <b>STATUS</b>, <b>TEST</b> and <b>QUARANTINE STATUS</b></h6>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pb-0" style="overflow: auto;">
                
            <table id="tbl_person_covid19_exist" style="width:100%;" class="table table-bordered table-hover">
              <thead>
              <tr style="white-space: nowrap;">
                <th width="1"><i class='fa fa-qrcode'></i>Code</th>
                <th><i class='fa fa-user'></i>Name</th>
                <th width="1"><i class='fa fa-virus'></i>Status</th>
                <th width="1"><i class='fa fa-vial'></i>Test</th>
                <th width="1"><i class='fa fa-bed'></i>Quarantine</th>
              </tr>
              </thead>
              <tbody>
              </tbody>
            </table>

        </div>
        <div class="modal-footer justify-content-between">
        </div>
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
        <div id="myContact" style="min-width:100%; height: auto;"></div>
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
  <div class="modal-dialog modal-sm">
    <?= form_open(base_url('usercheckpoint/Dataentry/saveDataStatusHistory'), 'id=form_save_dataStatusHistory'); ?>
      <div class="modal-content bg-default">
        <div class="modal-header">
          <h6 class="modal-title"><i class="fa fa-viruses"></i> Status History</h6>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pb-0" style="overflow: auto;">
          
            <input class="personStatusId" name="personStatusId" hidden value="1">
                
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

            <table id="tbl_person_covid19_status" style="width:100%;display:none;" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>#</th>
                <th>Status</th>
                <th>Date</th>
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

<div class="modal fade" id="testHistory">
  <div class="modal-dialog modal-md">
    <?= form_open(base_url('usercheckpoint/Dataentry/saveDataTestHistory'), 'id=form_save_dataTestHistory'); ?>
      <div class="modal-content bg-default">
        <div class="modal-header">
          <h6 class="modal-title"><i class="fa fa-vials"></i> Test History</h6>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pb-0" style="overflow: auto;">
          
            <input class="personTestId" name="personTestId" hidden value="1">
            <input class="proceed" name="proceed" hidden value="0">
                
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
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                    <input type="date" value="<?= Date('Y-m-d') ?>" class="form-control form-control-sm" name="dateEntried">
                </div>
              </div>
            </div>

            <table id="tbl_person_covid19_test" width="100%" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>#</th>
                <th>Test</th>
                <th>Test Date</th>
                <th>Encoded Date</th>
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

<div class="modal fade" id="qstatusHistory">
  <div class="modal-dialog modal-sm">
    <?= form_open(base_url('usercheckpoint/Dataentry/saveDataQStatusHistory'), 'id=form_save_dataQStatusHistory'); ?>
      <div class="modal-content bg-default">
        <div class="modal-header">
          <h6 class="modal-title"><i class="fa fa-bed"></i> Quarantine Status History</h6>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pb-0" style="overflow: auto;">
          
            <input class="personQStatusId" name="personQStatusId" hidden value="1">
                
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

            <table id="tbl_person_covid19_qstatus" style="width:100%;display:none;" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>#</th>
                <th>Quarantine</th>
                <th>Date</th>
              </tr>
              </thead>
              <tbody>
              </tbody>
            </table>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-info btn-sm submitBtnTestQStatus"><i class="fa fa-check"></i> Save Data</button>
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
    <?= form_open(base_url('usercheckpoint/Dataentry/saveDataCodeHistory'), 'id=form_save_dataCodeHistory'); ?>
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
                 <p id="modal_selected_person"></p>
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