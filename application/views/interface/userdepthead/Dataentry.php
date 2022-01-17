<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script src="<?= base_url() ?>plugins/jquery/jquery.form.min.js"></script>
<?php
if (!$this->session->schoolmis_login_level) {
	redirect(base_url('login'));
}
$uri = $this->session->schoolmis_login_uri;
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container-fluid">
		<div class="row mt-2">
			<div class="col-sm-6">
				<h1><i class="nav-icon fas fa-edit"></i> Data Entry</h1>
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
		<div class="row">

			<div class="col-lg-12 col-md-6 col-sm-12 col-xs-12 form_save_dataGradeSecInfo">
				<div class="row">

					<div class="col-12">
						<div class="card card-navy">
							<div class="card-header">
								<h3 class="card-title"><i class="fa fa-puzzle-piece"></i> Grade level Sectioning</h3>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
								</div>
							</div>
							<div class="card-body p-2" style="overflow: auto;">
								<div class="table-responsive mailbox-messages">
									<?= form_open(base_url($uri . '/Dataentry/saveGradeSecInfo'), 'id=form_save_dataGradeSecInfo'); ?>
									<div class="row">
										<div class="col-lg-7 col-md-12 col-sm-12 mb-2">
											<!-- <label class="mb-n2">K-12</label> -->
											<select class="form-control form-control-sm selectGLevelList" data-placeholder="K-12" name="gradelevel" onchange="getFetchList('GradeSecInfo', 'GradeList', 'PartyList', 0, {v: $('#form_save_dataGradeSecInfo .selectGLevelList').val()}, 0);"></select>
										</div>
										<div class="col-lg-5 col-md-12 col-sm-12 mb-2">
											<!-- <label class="mb-n2">Grade Level</label> -->
											<select class="form-control form-control-sm selectGradeList" data-placeholder="GRADE LEVEL" name="grade"></select>
										</div>
										<div class="col-lg-6 col-md-12 col-sm-12 mb-2">
											<input type="text" class="form-control form-control-sm text-uppercase" name="sectionName" placeholder="SECTION NAME" autocomplete="off">
										</div>
										<div class="col-lg-6 col-md-12 col-sm-12">
											<div class="input-group mb-2">
												<select class="form-control form-control-sm selectSchedList" data-placeholder="SCHEDULE" name="sched"></select>
												<div class="input-group-append">
													<button type="submit" class="btn btn-info btn-sm submitBtnPrimary">SAVE</button>
												</div>
											</div>
										</div>
									</div>
									</form>
									<table id="tblGradeSecInfo" style="width:100%;" class="table table-sm table-striped table-hover">
										<thead>
											<tr>
												<th width="1">#</th>
												<th><i class='fa fa-puzzle-piece'></i> Grade lvl Sectioning details</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<script type="text/javascript">
	$(function() {
		let f1 = "PersonnelInfo";
		let f2 = "GradeSecInfo";
		getTable(f1, 0, 5);
		getTable(f2, 0, 5);
		getTable("SYInfo", 0, 5);
		getTable("SubjectList", 0, 10);
		getSbjctAssPrsnnl("SbjctAssPrsnnl");

		// getFetchList("RegionProvince", "RegionList", null, 1, {
		// 	v: null
		// }, 1, 1);
		// getFetchList("RegionProvince", "ProvinceList", null, 1, {
		// 	v: 16
		// }, 1, 1);

		getFetchList("PersonnelAccount", "RoleList", "RoleList", 0, {
			v: null
		}, 0);
		getFetchList("PersonnelAccount", "DepartmentList", "DepartmentList", 0, {
			v: null
		}, 0);

		getFetchList(f1, "RegionList", null, 1, {
			v: null
		}, 1, 1);
		getFetchList(f1, "ProvinceList", null, 1, {
			v: 16
		}, 1, 1);
		getFetchList(f1, "CityMunList", null, 1, {
			v: 1602
		}, 1, 1);
		getFetchList(f1, "BarangayList", null, 1, {
			v: 160201
		}, 1, 1);
		// getFetchList(f1, "PurokList", null, 1, {
		// 	v: null
		// }, 0, 1);

		getFetchList(f1, "EmpList", "PartyList", 0, {
			v: 2
		}, 1);
		getFetchList(f1, "PtitleList", "PartyList", 0, {
			v: 4
		}, 1);
		getFetchList(f1, "EStatusList", "StatusList", 0, {
			v: 1
		}, 1);


		getFetchList(f2, "GLevelList", "PartyTypeList", 0, {
			v: 5
		}, 0);
		getFetchList('GradeSubject', "GLevelList", "PartyTypeList", 0, {
			v: 5
		}, 0);
		getFetchList(f2, "GradeList", "PartyList", 0, {
			v: 14
		}, 0);
		getFetchList('GradeSubject', "GradeList", "PartyList", 0, {
			v: 14
		}, 0);
		// getFetchList('GradeSubject', "SubjectList", "PartyList", 0, {
		// 	v: 17
		// }, 0);
		getFetchList(f2, "SchedList", "PartyList", 0, {
			v: 18
		}, 0);
		saveForm(f1, [f1], null);
		saveForm(f2, [f2], null);
		saveForm("SYInfo", ["SYInfo"], null);
		saveForm("SbjctAssPrsnnl", [""], null);
		saveForm("GradeSubject", [""], null);
		saveForm("PersonnelAccount", [f1], null);
		saveForm("Subject", ["SubjectList"], null);
		saveForm("QuarterInfo", ["SYInfo"], null);
	});
</script>