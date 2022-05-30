<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script src="<?= base_url() ?>plugins/jquery/jquery.form.min.js"></script>
<?php
if (!$this->session->schoolmis_login_level) {
    redirect(base_url('login'));
}
$uri = $this->session->schoolmis_login_uri;
?>
<!-- <div class="modal fade show" id="modalEnrollment" aria-modal="true" style="padding-right: 16px; display: block;"> -->
<div class="modal fade" id="modalEnrollment">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary p-2 px-3">
                <h5 class="modal-title p-0">
                    Enrollment entry form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mb-n3">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <!-- <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-search-tab" data-toggle="pill" href="#custom-tabs-four-search" role="tab" aria-controls="custom-tabs-four-search" aria-selected="true">Search</a>
                            </li> -->
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-new" role="tab" aria-controls="custom-tabs-four-new" aria-selected="false">New</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-import" role="tab" aria-controls="custom-tabs-four-import" aria-selected="false">Import SF1</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <!-- <div class="tab-pane fade" id="custom-tabs-four-search" role="tabpanel" aria-labelledby="custom-tabs-four-search-tab"> -->
                            <!-- <div class="row">
                                    <div class="col-5">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">by:</span>
                                            </div>
                                            <select name="searchby" id="searchby" class="form-control">
                                                <option value="1">LRN</option>
                                                <option value="2">LAST NAME</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="keyword" placeholder="INPUT KEYWORD...">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-warning" onclick="tblReload('SearchEnrollLearnersList')"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                            <!-- <form id="formSearchEnrollLearnersList">
                                    <div class="card-body p-0 table-responsive mt-3">
                                        <table class="table table-sm table-hover table-striped" id="tblSearchEnrollLearnersList" width="100%">
                                            <thead>
                                                <tr>
                                                    <th width="1">#</th>
                                                    <th width="1">LRN</th>
                                                    <th>Personal Details</th>
                                                    <th>Sex</th>
                                                    <th>Birthdate</th>
                                                    <th>Enrolled</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </form> -->

                            <!-- </div> -->
                            <div class="tab-pane fade active show" id="custom-tabs-four-new" role="tabpanel" aria-labelledby="custom-tabs-four-new-tab">
                                <div class="row">
                                    <?= form_open(base_url($uri . '/Dataentry/saveEnrollmentInfo'), 'id=form_save_dataEnrollmentInfo'); ?>
                                    <input name="details" hidden nr="1" />
                                    <input id="ersid" hidden name="rsId" />
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">
                                        <!-- <label>Basic Information</label> -->
                                        <h6>Basic Information Details</h6>
                                        <div class="row">
                                            <div class="col-lg-2 col-md-12 col-sm-12">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text text-bold text-success text-xs">LRN</span>
                                                    </div>
                                                    <input type="number" class="form-control form-control-sm text-uppercase" name="lrn" placeholder="LEARNER'S REFERENCE NUMBER (LRN)" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-12 col-sm-12">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text firstName text-primary"><i class="fas fa-user"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm text-uppercase" name="firstName" placeholder="FIRST NAME" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                                <input type="text" class="form-control form-control-sm text-uppercase" name="middleName" placeholder="MIDDLE NAME" autocomplete="off" nr="1">
                                            </div>
                                            <div class="col-lg-3 col-md-12 col-sm-12 mb-2">
                                                <input type="text" class="form-control form-control-sm text-uppercase" name="lastName" placeholder="LAST NAME" autocomplete="off">
                                            </div>
                                            <div class="col-lg-1 col-md-12 col-sm-12 mb-2">
                                                <input type="text" class="form-control form-control-sm text-uppercase" name="extName" placeholder="EXTN" autocomplete="off" nr="1">
                                            </div>
                                            <div class="col-lg-1 col-md-12 col-sm-12">
                                                <select class="form-control form-control-sm" name="sex">
                                                    <option value="t">MALE</option>
                                                    <option value="f">FEMALE</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-12 col-sm-12">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text birthdate"><i class="fas fa-birthday-cake"></i></span>
                                                    </div>
                                                    <input type="date" class="form-control form-control-sm" name="birthdate" value="<?= date('Y-m-d'); ?>">
                                                </div>
                                            </div>
                                            <!-- <div class="col-lg-3 col-md-12 col-sm-12">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                    </div>
                                                    <select class="form-control selectCityMunList" onchange="getLocation('CityMunList','BarangayList','PersonnelInfo')" type="select" name="cty">
                                                    </select>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-edit text-primary"></i></span>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="col-lg-2 col-md-12 col-sm-12">
                                                <div class="input-group mb-2">
                                                    <!-- <div class="input-group-prepend">
                                                        <span class="input-group-text brgy"><i class="fas fa-map-marker-alt"></i></span>
                                                    </div> -->
                                                    <select class="form-control form-control-sm select2 selectBarangayList" data-placeholder="SELECT BARANGAY" onchange="getLocation('BarangayList','PurokList','PersonnelInfo')" type="select" name="brgy" style="width:100%;">
                                                    </select>
                                                    <!-- <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-edit text-primary"></i></span>
                                                    </div> -->
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-5 col-sm-12">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text homeAddress"><i class="fas fa-home"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm text-uppercase" name="homeAddress" placeholder="ADDRESS DETAILS" autocomplete="off" nr="1">
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-5 col-sm-12">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text text-xs text-bold">STATUS</span>
                                                    </div>
                                                    <div class="input-group-prepend">
                                                        <select class="form-control form-control-sm selectLearnerStatus" name="status">
                                                        </select>
                                                    </div>
                                                    <input type="date" class="form-control form-control-sm text-uppercase" name="enrollDate" value="<?= date('Y-m-d'); ?>">
                                                    <div class="input-group-append">
                                                        <!-- <span class="input-group-text"><i class="fas fa-edit text-primary"></i></span> -->
                                                        <button type="submit" class="btn btn-success btn-sm submitBtnPrimary"><i class="fa fa-check"></i> Enroll Learner</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text emailAddress"><i class="fas fa-envelope"></i></span>
                                                    </div>
                                                    <input type="email" class="form-control" name="emailAddress" placeholder="EMAIL ADDRESS" autocomplete="off">
                                                </div>
                                            </div> -->
                                        </div>
                                        <!-- <h6 class="mt-2">Employment Information Details</h6>
                                        <div class="row">
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                                    </div>
                                                    <select class="form-control selectEmpList" name="emptype" onchange="getFetchList('PersonnelInfo', 'PtitleList', 'PartyList', 0, {v: $('.selectEmpList').val()}, 1);">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                                    </div>
                                                    <select class="form-control selectPtitleList" name="personaltitle">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                                    </div>
                                                    <select class="form-control selectEStatusList" name="empstatus">
                                                    </select>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                    <!-- /.card-body -->
                                    <!-- <div class="col-12 mt-2">
                                        <button type="button" class="btn btn-default btn-sm float-right" onclick="clear_form('form_save_dataPersonnelInfo')"><i class="fa fa-times"></i> Cancel</button>
                                        <button type="submit" class="btn btn-info btn-sm submitBtnPrimary float-right mr-2">Save Data</button>
                                    </div> -->
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-four-import" role="tabpanel" aria-labelledby="custom-tabs-four-import-tab">

                                <form method="post" id="import_form" enctype="multipart/form-data">
                                    <p><button type="submit" name="import" class="btn btn-xs btn-info submitBtnUpload"><i class="fa fa-upload"></i> Import SF1 Excel</button>
                                        <!-- <input type="file" name="file" id="file" required accept=".xlsm" /> -->
                                        <input type="file" name="file" id="file" required accept=".xls" />
                                    </p>
                                </form>
                                <!-- Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna. -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <div class="card-body p-0" style="overflow: auto;">
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->


<!-- /.modal -->
<!-- <div class="modal fade show" id="modal-default" aria-modal="true" style="padding-right: 16px; display: block;"> -->
<div class="modal fade" id="modalGradesList">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary p-2 px-3">
                <h5 class="modal-title p-0">
                    Grades Entry form - SY: <b><?= $getOnLoad["sy"]; ?> | </b> Q: <b><?= $getOnLoad["qrtr"]; ?></b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open(base_url($uri . '/Dataentry/saveGradesList'), 'id=form_save_dataGradesList'); ?>
            <div class="modal-body mb-n3 form_save_dataGradesList content">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-6 p-1"><span class="q1c">-</span></div>
                    <div class="col-md-3 col-sm-6 col-xs-6 p-1"><span class="q2c">-</span></div>
                    <div class="col-md-3 col-sm-6 col-xs-6 p-1"><span class="q3c">-</span></div>
                    <div class="col-md-3 col-sm-6 col-xs-6 p-1"><span class="q4c">-</span></div>
                </div>

                <div class="card-body p-0 table-responsive mt-3">
                    <table class="table table-striped table-bordered table-sm " cellspacing="0" id="tblGradesList" width="100%">
                        <thead width="100%">
                            <tr style="text-align:center;">
                                <th>Student</th>
                                <!-- <th>Sex</th>
                                <th>Status</th> -->
                                
                                <th>Q1</th>
                                <th>Q2</th>
                                <th>Q3</th>
                                <th>Q4</th>
                                <th>AVG</th>

                                <!-- <th>     Q1      </th>
                                <th>     Q2      </th>
                                <th>     Q3      </th>
                                <th>     Q4      </th>
                                <th>    AVG </th> -->
                            </tr>
                        </thead>
                        <tbody style="text-align:center">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer content">
                <button type="submit" class="btn btn-info submitBtnPrimary">Save Grades</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
            <div class="overlay">
                <i class="fas fa-spin text-white fa-3x fa-circle-notch"></i>
            </div>
            </form>
        </div>

        <div class="tab-pane fade" id="custom-tabs-four-import" role="tabpanel" aria-labelledby="custom-tabs-four-import-tab">
            Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna.
        </div>
    </div>
</div>

<div class="modal fade" id="modalAllGrades">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-gradient-success p-2 px-3">
                <h5 class="modal-title p-0">
                    List of Grades - SY: <b><?= $getOnLoad["sy"]; ?> | </b> Q: <b><?= $getOnLoad["qrtr"]; ?></b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mb-n3">
                <div class="card card-navy p-0 table-responsive viewAllGrades">
                </div>
            </div>
            <div class="overlay">
                <i class="fas fa-spin text-white fa-3x fa-circle-notch"></i>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAllStudentLogs">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-default p-2 px-3">
                <h5 class="modal-title p-0">
                    Learner Logs form - SY: <b><?= $getOnLoad["sy"]; ?> | </b> Q: <b><?= $getOnLoad["qrtr"]; ?></b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mb-n2">
                <!-- <div class="card card-navy p-0 table-responsive viewAllGrades">
                </div> -->

                <div class="card-body p-0 table-responsive mt-3" id="printAllStudentLogs">
                    <table class="table table-sm table-hover table-striped text-xs p-0" id="tblAllStudentLogs" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>LRN & Full name</th>
                                <th>Date & Time</th>
                                <th>Action</th>
                                <th>IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="tab-pane fade" id="custom-tabs-four-import" role="tabpanel" aria-labelledby="custom-tabs-four-import-tab">
            Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna.
        </div>
    </div>
</div>
<!-- /.card -->

<!-- <div class="modal fade show" id="modalLearnersList" aria-modal="true" style="padding-right: 16px; display: block;"> -->
<div class="modal fade" id="modalLearnersList">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-gradient-navy p-2">
                <h5 class="modal-title p-0"><span class="fa fa-cog"></span> Account Settings </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body p-1 mt-n2 mb-n2">
                    <select class="form-control" name="accountSettings">
                        <option value="create">CREATE ACCOUNT</option>
                        <option value="reset">RESET PASSWORD</option>
                        <option value="disable">DISABLE ACCOUNT</option>
                        <option value="enable">ENABLE ACCOUNT</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer p-1">
                <button type="submit" class="btn btn-info btn-xs submitBtnPrimary" onclick="batchUpdateAccount('LearnersList');">Save Changes</button>
                <!-- <button type="button" class="btn btn-default btn-xs" data-dismiss="modal"><i class="fa fa-times"></i> Close</button> -->
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalLearnersUnenroll">
    <div class="modal-dialog modal-sm">
        <form id="form_save_dataUnenrollConfirm">
            <div class="modal-content">
                <div class="modal-header bg-danger p-2">
                    <h5 class="modal-title p-0"><span class="fa fa-trash-alt"></span> Unenroll Confirmation </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5><strong class='lrn'></strong></h5>
                    <input name="details" hidden />
                    <p class="lead">
                        <strong class="last_fullname"></strong>
                    </p>
                    <input type="password" name="password" class="form-control passwordUnenroll submitBtnPrimary" placeholder="Enter Password" />
                </div>
                <div class="modal-footer p-1">
                    <button type="button" class="btn btn-danger btn-xs btn-block submitBtnPrimary" onclick="unenroll();">Unenroll Student</button>
                    <!-- <button type="button" class="btn btn-default btn-xs" data-dismiss="modal"><i class="fa fa-times"></i> Close</button> -->
                </div>
            </div>
        </form>
    </div>
</div>

<!-- <div class="modal fade show" id="modalLearnersList" aria-modal="true" style="padding-right: 16px; display: block;"> -->
<div class="modal fade mt-5" id="modalLearnersSubmitGrades">
    <div class="modal-dialog modal-sm">
        <form id="form_save_dataSubmitGradesConfirm">
            <div class="modal-content">
                <div class="modal-header bg-success p-2">
                    <h5 class="modal-title p-0"><span class="fa fa-paper-plane"></span> Submit Confirmation<br />
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <center class="mb-3"><b>NOTE:</b> <i> You will <b>NOT</b> be able to UPDATE the grades after <b>SUBMISSION/APPROVAL</b>.</i></center>

                    <!-- <small><b class="detail">9 - MERCURY</b> JHS ARAL PAN | WD | <b>Q1 - 100%</b></small> -->
                    <input type="text" name="qrssa" id="qrssa" hidden />
                    <textarea class="form-control form-control-sm text-uppercase mb-2 remarks" name="remarks" rows="3" placeholder="REMARKS" nr="1"></textarea>
                    <!-- <input type="password" name="password" class="form-control passwordSubmitGrades submitBtnPrimary" placeholder="Enter Password" /> -->
                </div>
                <div class="modal-footer p-1">
                    <button type="button" class="btn btn-success btn-xs btn-block submitBtnPrimary" onclick="submitGrades();">Submit Student Grades</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- <div class="modal fade show" id="modalLearnersList" aria-modal="true" style="padding-right: 16px; display: block;"> -->
<div class="modal fade" id="modalUpdateLearnerInfo">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary p-2">
                <h5 class="modal-title p-0"><span class="fa fa-pencil-alt"></span> Update Learner Information </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-2 mb-n3">

                <div id="accordion">
                    <div class="card card-white">
                        <div class="card-header p-2">
                            <h4 class="card-title w-100">
                                <!-- <a class="d-block w-100" data-toggle="collapse" href="#collapseOne" aria-expanded="true"> -->
                                <a class="d-block w-100" data-toggle="#" href="#collapseOne" aria-expanded="true">
                                    <span class="fa fa-user"></span> Basic Information Details
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="collapse show" data-parent="#accordion">
                            <?= form_open(base_url($uri . '/Dataentry/saveEnrollmentInfo'), 'id=form_save_dataUpdateLearnerInfo'); ?>
                            <input name="details" hidden />
                            <div class="card-body p-2">
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-bold text-success text-xs">LRN</span>
                                            </div>
                                            <input type="number" class="form-control form-control-sm text-uppercase" name="lrn" placeholder="LEARNER'S REFERENCE NUMBER (LRN)" autocomplete="off" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12 col-sm-12">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text firstName text-primary"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm text-uppercase" name="firstName" placeholder="FIRST NAME" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                        <input type="text" class="form-control form-control-sm text-uppercase" name="middleName" placeholder="MIDDLE NAME" autocomplete="off" nr="1">
                                    </div>
                                    <div class="col-lg-3 col-md-12 col-sm-12 mb-2">
                                        <input type="text" class="form-control form-control-sm text-uppercase" name="lastName" placeholder="LAST NAME" autocomplete="off">
                                    </div>
                                    <div class="col-lg-1 col-md-12 col-sm-12 mb-2">
                                        <input type="text" class="form-control form-control-sm text-uppercase" name="extName" placeholder="EXTN" autocomplete="off" nr="1">
                                    </div>
                                    <div class="col-lg-1 col-md-12 col-sm-12">
                                        <!-- <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                            </div> -->
                                        <select class="form-control form-control-sm" name="sex">
                                            <option value="t">MALE</option>
                                            <option value="f">FEMALE</option>
                                        </select>
                                        <!-- </div> -->
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text birthdate"><i class="fas fa-birthday-cake"></i></span>
                                            </div>
                                            <input type="date" class="form-control form-control-sm" name="birthdate" value="<?= date('Y-m-d'); ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <div class="input-group mb-2">
                                            <select class="form-control form-control-sm select2 selectBarangayList" data-placeholder="SELECT BARANGAY" onchange="getLocation('BarangayList','PurokList','PersonnelInfo')" type="select" name="brgy" style="width:100%;">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text homeAddress"><i class="fas fa-home"></i></span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm text-uppercase" name="homeAddress" placeholder="ADDRESS DETAILS" autocomplete="off" nr="1">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-xs text-bold">STATUS</span>
                                            </div>
                                            <div class="input-group-prepend">
                                                <select class="form-control form-control-sm selectLearnerStatus" name="status">
                                                </select>
                                            </div>
                                            <input type="date" class="form-control form-control-sm" name="enrollDate" autocomplete="off">
                                            <div class="input-group-append">
                                                <!-- <span class="input-group-text"><i class="fas fa-edit text-primary"></i></span> -->
                                                <button type="submit" class="btn btn-info btn-sm submitBtnPrimary"><i class="fa fa-check"></i> Update Data</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <!-- <div class="card card-white">
                        <div class="card-header p-2">
                            <h4 class="card-title w-100">
                                <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false">
                                    <span class="fa fa-user-friends"></span> Parent/Guardian Information
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="collapse" data-parent="#accordion">
                            <div class="card-body p-3">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                                3
                                wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                                laborum
                                eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee
                                nulla
                                assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                                nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft
                                beer
                                farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                                labore sustainable VHS.
                            </div>
                        </div>
                    </div>
                    <div class="card card-white">
                        <div class="card-header p-2">
                            <h4 class="card-title w-100">
                                <a class="d-block w-100" data-toggle="collapse" href="#collapseThree">
                                    <span class="fa fa-info"></span> Other Information
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="collapse" data-parent="#accordion">
                            <div class="card-body p-3">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                                3
                                wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                                laborum
                                eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee
                                nulla
                                assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                                nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft
                                beer
                                farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                                labore sustainable VHS.
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalHonor">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-navy py-1">
                <h5 class="modal-title p-0"><span class="fa fa-medal"></span> Honors List
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-1">
                <!-- <table class="table table-sm tblHonorsList"> -->
                <table class="table table-striped table-bordered table-sm" cellspacing="0" id="tblHonorsList" width="100%">
                    <thead>
                        <tr>
                            <!-- <th width="1">#</th> -->
                            <th>#   Learner</th>
                            <th><center>AVG</center></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>