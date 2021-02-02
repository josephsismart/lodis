
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
      <div class="modal-content bg-default">
        <div class="modal-header">
          <h6 class="modal-title"><i class="fa fa-viruses"></i> Status History</h6>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pb-0" style="overflow: auto;">
          
            <input class="personStatusId" name="personStatusId" hidden value="1">
                
            <table id="tbl_person_covid19_status" style="width:100%;" class="table table-bordered table-hover">
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
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
        </div>
      </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="testHistory">
  <div class="modal-dialog modal-md">
    <?= form_open(base_url('useradmin/Dataentry/saveDataTestHistory'), 'id=form_save_dataTestHistory'); ?>
      <div class="modal-content bg-default">
        <div class="modal-header">
          <h6 class="modal-title"><i class="fa fa-vials"></i> Test History</h6>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pb-0" style="overflow: auto;">
          
            <input class="personTestId" name="personTestId" hidden value="1">
                
            <table id="tbl_person_covid19_test" style="width:100%;" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>#</th>
                <th>Test</th>
                <th>Result</th>
                <th>Date</th>
              </tr>
              </thead>
              <tbody>
              </tbody>
            </table>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
        </div>
      </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalUsername">
  <div class="modal-dialog modal-sm">
    <?= form_open(base_url('useradmin/Dataentry/saveUsername'), 'id=form_save_username'); ?>
      <div class="modal-content bg-default">
        <div class="modal-header">
          <h6 class="modal-title"><i class="fa fa-users"></i> User Settings</h6>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
            <input class="userName" name="userName" hidden>
        <div class="modal-body pb-0" style="overflow: auto;">
            <div class="row">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                    <input type="text" class="form-control text-uppercase thisUserName" name="thisUserName" placeholder="USERNAME" autocomplete="off">
                </div>
                <a type="button" onclick="resetPassword();" class="btn btn-info btn-block mb-2 text-white" data-dismiss="modal"><i class="fa fa-key"></i> Reset Password</a>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-success btn-sm btnUsername"><i class="fa fa-check"></i> Save</button>
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
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