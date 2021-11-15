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

			<div class="col-lg-8 col-md-6 col-sm-12 col-xs-12 form_save_dataPersonnelInfo">
				<div class="row">
					<div class="col-12">
						<?= form_open(base_url($uri . '/Dataentry/savePersonnelInfo'), 'id=form_save_dataPersonnelInfo'); ?>
						<input type="" name="personId" hidden nr="1">
						<div class="card card-navy">
							<div class="card-header">
								<h3 class="card-title"><i class="fa fa-user"></i> Personnel Information Details</h3>

								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
									<!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button> -->
								</div>
							</div>
							<!-- /.card-header -->
							<div class="card-body p-2" style="overflow: auto;">
								<!-- <label>Basic Information</label> -->
								<h6>Basic Information Details</h6>
								<div class="row">
									<div class="col-lg-4 col-md-12 col-sm-12">
										<div class="input-group mb-2">
											<div class="input-group-prepend">
												<span class="input-group-text firstName"><i class="fas fa-user"></i></span>
											</div>
											<input type="text" class="form-control form-control-sm text-uppercase" name="firstName" placeholder="FIRST NAME" autocomplete="off">
										</div>
									</div>
									<div class="col-lg-3 col-md-12 col-sm-12 mb-2">
										<input type="text" class="form-control form-control-sm text-uppercase" name="middleName" placeholder="MIDDLE NAME" autocomplete="off" nr="1">
									</div>
									<div class="col-lg-4 col-md-12 col-sm-12 mb-2">
										<input type="text" class="form-control form-control-sm text-uppercase" name="lastName" placeholder="LAST NAME" autocomplete="off">
									</div>
									<div class="col-lg-1 col-md-12 col-sm-12 mb-2">
										<input type="text" class="form-control form-control-sm text-uppercase" name="extName" placeholder="EXTN" autocomplete="off" nr="1">
									</div>
									<div class="col-lg-2 col-md-12 col-sm-12">
										<div class="input-group mb-2">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
											</div>
											<select class="form-control form-control-sm" name="sex">
												<option value="t">MALE</option>
												<option value="f">FEMALE</option>
											</select>
										</div>
									</div>
									<div class="col-lg-3 col-md-12 col-sm-12">
										<div class="input-group mb-2">
											<div class="input-group-prepend">
												<span class="input-group-text birthdate"><i class="fas fa-birthday-cake"></i></span>
											</div>
											<input type="date" class="form-control form-control-sm" name="birthdate" value="<?= date('Y-m-d'); ?>">
										</div>
									</div>

									<div class="col-lg-4 col-md-12 col-sm-12 region_province" style="display:none;width:100%;">
										<div class="input-group mb-2">
											<!-- <div class="input-group-prepend">
												<span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
											</div> -->
											<select class="form-control selectRegionList" style="width:100%;" onchange="getLocation(['RegionList','ProvinceList','CityMunList','BarangayList'],
																												['ProvinceList','CityMunList','BarangayList','PurokList'],'PersonnelInfo');" type="select" name="region">
											</select>
										</div>
									</div>
									<div class="col-lg-3 col-md-12 col-sm-12 region_province" style="display:none;width:100%;">
										<div class="input-group mb-2">
											<!-- <div class="input-group-prepend">
												<span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
											</div> -->
											<select class="form-control selectProvinceList" style="width:100%;" onchange="getLocation(['ProvinceList','CityMunList','BarangayList'],
																												  ['CityMunList','BarangayList','PurokList'],'PersonnelInfo')" type="select" name="province">
											</select>
										</div>
									</div>
									<div class="col-lg-4 col-md-12 col-sm-12">
										<div class="input-group mb-2">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
											</div>
											<select class="form-control selectCityMunList" onchange="getLocation(['CityMunList','BarangayList'],
																												 ['BarangayList','PurokList'],'PersonnelInfo')" type="select" name="cty">
											</select>
											<div class="input-group-append" onclick="viewRegionProvince();" style="cursor:pointer;">
												<!-- <span class="input-group-text" data-toggle="modal" data-target="#modalRegionProvince"><i class="fas fa-pen text-primary"></i></span> -->
												<span class="input-group-text"><i class="fas fa-pen text-primary"></i></span>
											</div>
										</div>
									</div>
									<div class="col-lg-3 col-md-12 col-sm-12">
										<div class="input-group mb-2">
											<div class="input-group-prepend">
												<span class="input-group-text brgy"><i class="fas fa-map-marker-alt"></i></span>
											</div>
											<select class="form-control selectBarangayList" onchange="getLocation(['BarangayList'],['PurokList'],'PersonnelInfo')" type="select" name="brgy">
											</select>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 address_details">
										<div class="input-group mb-2">
											<div class="input-group-prepend">
												<span class="input-group-text homeAddress"><i class="fas fa-home"></i></span>
											</div>
											<input type="text" class="form-control form-control-sm text-uppercase" name="homeAddress" placeholder="ADDRESS DETAILS" autocomplete="off">
										</div>
									</div>
									<!-- <div class="col-lg-3 col-md-12 col-sm-12">
										<div class="input-group mb-2">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
											</div>
											<select class="form-control selectPurokList" type="select" name="prk" nr="1">
											</select>
										</div>
									</div> -->
									<!-- <div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-group mb-2">
											<div class="input-group-prepend">
												<span class="input-group-text emailAddress"><i class="fas fa-envelope"></i></span>
											</div>
											<input type="email" class="form-control" name="emailAddress" placeholder="EMAIL ADDRESS" autocomplete="off">
										</div>
									</div> -->
								</div>

								<!-- <div class="row"> -->
								<!-- <div class="col-lg-4 col-md-12 col-sm-12">
										<div class="input-group mb-2">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
											</div>
											<select class="form-control selectRegionList" onchange="getLocation(['RegionList','ProvinceList','CityMunList','BarangayList'],
																												['ProvinceList','CityMunList','BarangayList','PurokList'],'PersonnelInfo');" type="select" name="region">
											</select>
										</div>
									</div>
									<div class="col-lg-4 col-md-12 col-sm-12">
										<div class="input-group mb-2">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
											</div>
											<select class="form-control selectProvinceList" onchange="getLocation(['ProvinceList','CityMunList','BarangayList'],
																												  ['CityMunList','BarangayList','PurokList'],'PersonnelInfo')" type="select" name="province">
											</select>
										</div>
									</div> -->


								<!-- </div> -->

								<h6 class="mt-2">Employment Information Details</h6>
								<div class="row">
									<div class="col-lg-4 col-md-12 col-sm-12">
										<div class="input-group mb-2">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="fas fa-briefcase"></i></span>
											</div>
											<select class="form-control form-control-sm selectEmpList" name="emptype" onchange="getFetchList('PersonnelInfo', 'PtitleList', 'PartyList', 0, {v: $('.selectEmpList').val()}, 1);">
											</select>
										</div>
									</div>
									<div class="col-lg-4 col-md-12 col-sm-12">
										<div class="input-group mb-2">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="fas fa-briefcase"></i></span>
											</div>
											<select class="form-control form-control-sm selectPtitleList" name="personaltitle">
											</select>
											<div class="input-group-append" onclick="viewRegionProvince();" style="cursor:pointer;">
												<!-- <span class="input-group-text" data-toggle="modal" data-target="#modalRegionProvince"><i class="fas fa-pen text-primary"></i></span> -->
												<span class="input-group-text"><i class="fas fa-pen text-primary"></i></span>
											</div>
										</div>
									</div>
									<div class="col-lg-4 col-md-12 col-sm-12">
										<div class="input-group mb-2">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="fas fa-briefcase"></i></span>
											</div>
											<select class="form-control form-control-sm selectEStatusList" name="empstatus">
											</select>
										</div>
									</div>
								</div>
							</div>
							<!-- /.card-body -->
							<div class="card-footer">
								<button type="submit" class="btn btn-info btn-sm submitBtnPrimary">Save Data</button>
								<button type="button" class="btn btn-default btn-sm float-right" onclick="clear_form('form_save_dataPersonnelInfo')"><i class="fa fa-times"></i> Cancel</button>
							</div>
						</div>
						<!-- /.card -->
						</form>
					</div>

					<div class="col-12">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><i class="fa fa-list"></i> Personnel & User Account List</h3>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
									<!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button> -->
								</div>
							</div>
							<div class="card-body p-2" style="overflow: auto;">
								<div class="table-responsive mailbox-messages">
									<table id="tblPersonnelInfo" style="width:100%;" class="table table-sm table-striped table-hover">
										<thead>
											<tr>
												<th width="1">#</th>
												<th width="80"><i class='fa fa-briefcase'></i> Type</th>
												<th><i class='fa fa-user'></i> Personnel Details</th>
												<th width="200"><i class='fa fa-lock'></i> User Account Details</th>
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
			<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 form_save_dataGradeSecInfo">
				<div class="row">
					<div class="col-12">
						<div class="card card-navy">
							<div class="card-header">
								<h3 class="card-title"><i class="fa fa-puzzle-piece"></i> Grade level Subjects</h3>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
								</div>
							</div>
							<div class="card-body p-2" style="overflow: auto;">
								<div class="table-responsive mailbox-messages">
									<?= form_open(base_url($uri . '/Dataentry/saveGradeSubject'), 'id=form_save_dataGradeSubject'); ?>
									<div class="row">
										<div class="col-lg-6 col-md-12 col-sm-12 mb-2">
											<select class="form-control form-control-sm select2 selectGLevelList" data-placeholder="K-12" name="gradek12" onchange="getFetchList('GradeSubject', 'GradeList', 'PartyList', 0, {v: $('#form_save_dataGradeSubject .selectGLevelList').val()}, 0);getSelectSubject();"></select>
										</div>
										<div class="col-lg-6 col-md-12 col-sm-12 mb-2">
											<div class="input-group">
												<select class="form-control form-control-sm select2 selectGradeList" data-placeholder="GRADE LEVEL" name="gradelevel" onchange="getSelectSubject();"></select>
												<div class="input-group-append">
													<button type="button" class="btn btn-default btn-sm"><i class="fa fa-pen text-primary"></i></button>
												</div>
											</div>
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12 mb-2 sbj">
											<div class="input-group">
												<select class="form-control form-control-sm select2 selectSubjectList" multiple="multiple" data-placeholder="SUBJECT LISTS" name="subjectlist[]" nr="1"></select>
												<!-- <select class="form-control form-control-sm select2" multiple="multiple" data-placeholder="SUBJECT LISTS" name="asdf[]" nr="1">
													<option value='a'>a</option>
													<option value='b' disabled>b</option>
													<option value='c'>c</option>
												</select> -->
												<div class="input-group-append">
													<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modalSubjectList"><i class="fa fa-pen text-primary"></i></button>
													<button type="submit" class="btn btn-info btn-sm submitBtnPrimary">SAVE</button>
												</div>
											</div>
										</div>
									</div>
									</form>
									<!-- <table id="tblGradeSubject" style="width:100%;" class="table table-sm table-striped table-hover">
										<thead>
											<tr>
												<th width="1">#</th>
												<th><i class='fa fa-puzzle-piece'></i> Grade lvl Sectioning details</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table> -->
								</div>
							</div>
						</div>
					</div>

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
											<select class="form-control form-control-sm select2 selectGLevelList" data-placeholder="K-12" name="gradelevel" onchange="getFetchList('GradeSecInfo', 'GradeList', 'PartyList', 0, {v: $('#form_save_dataGradeSecInfo .selectGLevelList').val()}, 0);"></select>
										</div>
										<div class="col-lg-5 col-md-12 col-sm-12 mb-2">
											<!-- <label class="mb-n2">Grade Level</label> -->
											<select class="form-control form-control-sm select2 selectGradeList" data-placeholder="GRADE LEVEL" name="grade"></select>
										</div>
										<div class="col-lg-6 col-md-12 col-sm-12 mb-2">
											<input type="text" class="form-control form-control-sm text-uppercase" name="sectionName" placeholder="SECTION NAME" autocomplete="off">
										</div>
										<div class="col-lg-6 col-md-12 col-sm-12">
											<div class="input-group mb-2">
												<select class="form-control form-control-sm select2 selectSchedList" data-placeholder="SCHEDULE" name="sched"></select>
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

					<!-- <div class="col-12">
						<div class="card card-navy">
							<div class="card-header">
								<h3 class="card-title"><i class="fa fa-calendar"></i> List of School Year</h3>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
								</div>
							</div>
							<div class="card-body p-2" style="overflow: auto;">
								<div class="table-responsive mailbox-messages">
									<?= form_open(base_url($uri . '/Dataentry/saveSYInfo'), 'id=form_save_dataSYInfo'); ?>
									<div class="input-group mb-2">
										<button type="submit" class="btn btn-info btn-xs btn-block submitBtnPrimary">Generate new <b>School Year</b></button>
									</div>
									</form>
									<table id="tblSYInfo" style="width:100%;" class="table table-sm table-striped table-hover">
										<thead>
											<tr>
												<th width="1">#</th>
												<th><i class='fa fa-calendar'></i> School Year</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div> -->
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
	});
</script>