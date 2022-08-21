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
			<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 form_save_dataSectionList">
				<!-- <div class="card card-navy collapsed-card"> -->
				<div class="card card-navy">
					<div class="card-header">
						<h3 class="card-title"><i class="fa fa-puzzle-piece"></i> List of Sections</h3>
						<div class="card-tools">
							<!-- <button type="button" class="btn btn-tool collapseAssignedSectionList" data-card-widget="collapse"><i class="fas fa-plus"></i> -->
							<!-- <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
							</button> -->
						</div>
					</div>
					<!-- /.card-header -->
					<div class="card-body p-0 table-responsive">
						<table class="table table-sm table-hover table-striped" id="tblAssignedSectionList" width="100%">
							<thead>
								<tr>
									<th></th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<!-- /.card-body -->
				</div>
			</div>

			<div class="col-lg-9 col-md-8 col-sm-12 col-xs-12 form_save_dataPersonnelInfo">
				<div class="row">
					<div class="col-md-12">
						<div class="card card-navy">
							<div class="card-header">
								<h3 class="card-title"><i class="fa fa-puzzle-piece"></i> Grade Section Details</h3>
								<!-- <div class="card-tools">
									<button type="button" class="btn btn-tool collapseAssignedSectionList" data-card-widget="collapse"><i class="fas fa-plus"></i>
									</button>
								</div> -->
							</div> <!-- /.card -->

							<!-- <table class="" style="border:1px solid black;" border="1" id="tblGradesSMEAList" width="100%">
								<thead>
									<tr>
										<th rowspan="2" class="th-color" width="1">No</th>
										<th rowspan="2" class="th-color" width="1">Lrn</th>
										<th rowspan="2" class="th-color">Name</th>
										<th colspan="4">Grades Entry Data</th>
									</tr>
									<tr>
										<th class="th-color">Q1</th>
										<th class="th-color">Q2</th>
										<th class="th-color">Q3</th>
										<th class="th-color">Q4</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table> -->
							<!-- /.card-header -->
							<div class="card-body">
								<div class="row">
									<div class="col-12 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<div class="post">
											<div class="user-block">
												<img class="img-circle img-bordered-sm" src="<?= base_url(); ?>/dist/img/avatar1.jpg" alt="user image">
												<span class="username">
													<a href="#" class="personnel">-</a>
												</span>
												<span class="description">-</span>
											</div>
										</div>
									</div>
									<div class="col-12 col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-2">
										<span class="others">
										</span>
										<!-- <span class="downloads">
										</span> -->
										<span class="reports">
										</span>
										<span class="forms">
										</span>
									</div>
									<div class="col-12">
										<div class="list-group">
											<div class="list-group-item">
												<div class="row">
													<!-- <div class="col-lg-4 col-md-12">
													</div> -->

													<div class="col-12 col-lg-4 col-md-12 col-sm-6 small header1" style="display:none;">
														<table class="table table-sm" id="tblHonors">
															<thead>
																<tr>
																	<th width="150">Honors</th>
																	<th>Q1</th>
																	<th>Q2</th>
																	<th>Q3</th>
																	<th>Q4</th>
																	<th>FG</th>
																</tr>
															</thead>
															<tbody>
															</tbody>
														</table>
													</div>

													<div class="col-12 col-lg-12 col-md-12 col-sm-6 header2">
														<!-- <div class="col-lg-4 col-md-4"> -->
														<div class="text-center">
															<strong>No of learners</strong> <br><span class="small">as of EOSY</span>
														</div>
														<div class="text-center" style="font-size:42px;">
															<span class="total_enrollee">-</span>
														</div>

														<div class="row">
															<div class="col-6">
																<span class="small text-muted float-right">Male</span><br />
																<span class="float-right male">
																	<span class="male">-</span>
																</span>
															</div>
															<div class="col-6">
																<span class="small text-muted float-left">Female</span><br>
																<span class="float-left">
																	<span class="female">-</span>
																</span>
															</div>
														</div>
													</div>

													<div class="col-lg-4 col-md-4 small table-responsive" hidden>
														<table class="table table-sm">
															<thead>
																<tr>
																	<th style="width:100px">
																		&nbsp;
																	</th>
																	<th class="text-right">
																		Male
																	</th>
																	<th class="text-right">
																		Female
																	</th>
																	<th class="text-right">
																		Total
																	</th>
																</tr>
															</thead>
															<tbody>

																<tr>
																	<td>
																		Transfer-in
																	</td>
																	<td class="text-right">
																		2
																	</td>
																	<td class="text-right">
																		2
																	</td>
																	<td class="text-right">
																		4
																	</td>
																</tr>

																<tr>
																	<td>
																		Balik-aral
																	</td>
																	<td class="text-right">
																		0
																	</td>
																	<td class="text-right">
																		0
																	</td>
																	<td class="text-right">
																		0
																	</td>
																</tr>


																<tr>
																	<td>
																		Repeater
																	</td>
																	<td class="text-right">
																		8
																	</td>
																	<td class="text-right">
																		3
																	</td>
																	<td class="text-right">
																		11
																	</td>
																</tr>



															</tbody>
														</table>
													</div>

													<div class="col-lg-4 col-md-4 small table-responsive" hidden>
														<table class="table table-sm">
															<thead>
																<tr>
																	<th style="width:100px">
																		&nbsp;
																	</th>
																	<th class="text-right">
																		Male
																	</th>
																	<th class="text-right">
																		Female
																	</th>
																	<th class="text-right">
																		Total
																	</th>
																</tr>
															</thead>
															<tbody>

																<tr>
																	<td>
																		<abbr title="Conditional Cash Transfer">CCT</abbr> Recipient

																	</td>
																	<td class="text-right">
																		0
																	</td>
																	<td class="text-right">
																		0
																	</td>
																	<td class="text-right">
																		0
																	</td>
																</tr>

																<tr>
																	<td>
																		<abbr title="Arabic Language and Islamic Values Education">ALIVE</abbr>
																	</td>
																	<td class="text-right">
																		0
																	</td>
																	<td class="text-right">
																		0
																	</td>
																	<td class="text-right">
																		0
																	</td>
																</tr>

																<tr>
																	<td>
																		<abbr title="Alternative Delivery Mode">ADM</abbr>
																	</td>
																	<td class="text-right">
																		0
																	</td>
																	<td class="text-right">
																		0
																	</td>
																	<td class="text-right">
																		0
																	</td>
																</tr>
															</tbody>
														</table>

													</div>
												</div>
											</div>

										</div>
									</div>
									<!-- /.user-block -->

									<!-- <p>
										<a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
										<a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
										<span class="float-right">
											<a href="#" class="link-black text-sm">
												<i class="far fa-comments mr-1"></i> Comments (5)
											</a>
										</span>
									</p> -->

									<!-- <input class="form-control form-control-sm" type="text" placeholder="Type a comment"> -->
									<div class="col-12 mt-4">

										<div class="card">
											<div class="card-header">
												<h4 class="card-title w-100 my-n1">
													List of Learners
												</h4>
											</div>
											<form id="formLearnersList">
												<div class="card-body p-1 table-responsive">
													<table class="table table-sm table-hover table-striped" id="tblLearnersList" width="100%">
														<thead>
															<tr>
																<th width="1"></th>
																<th width="1">
																	<div class="normal_view">LRN</div>
																	<div class="custom-control custom-checkbox logs_account" style="display:none;">
																		<input style="cursor:pointer" class="custom-control-input" id="learnerCheckBox" onclick="check_all('learnerCheckBox')" type="checkbox" />
																		<label style="cursor:pointer" for="learnerCheckBox" class="custom-control-label"> </label>
																	</div>
																</th>
																<th>Personal Details</th>
																<th>Sex</th>
																<th>Birthdate</th>
																<th>Address Details</th>
																<th>Status</th>
															</tr>
														</thead>
														<tbody>
														</tbody>
													</table>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							<!-- /.card-body -->

							<!-- <div class="overlay LearnersList">
								<i class="fas fa-spin text-navy fa-5x fa-circle-notch"></i>
							</div> -->
						</div>
						<!-- /.card -->
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
				<!-- END ACCORDION & CAROUSEL-->
			</div>
		</div>
	</div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<script type="text/javascript">
	$(function() {
		let f1 = "EnrollmentInfo";
		let f2 = "GradeSecInfo";
		let f3 = "UpdateLearnerInfo";
		getTable("AssignedSectionList", 1, -1);
		getTable("LearnersList", 0, -1);
		getTable("Honors", 1, -1);
		// getTable("SearchEnrollLearnersList", 0, 10, "", 1);
		getFetchList(f1, "BarangayList", null, 1, {
			v: 160201
		}, 0, 1);
		getFetchList(f3, "BarangayList", null, 1, {
			v: 160201
		}, 0, 1);
		getFetchList(f3, "LearnerStatus", "StatusList", 0, {
			v: 4
		}, 1);
		getFetchList(f1, "LearnerStatus", "StatusList", 0, {
			v: 4
		}, 1);
		saveForm(f1, ["LearnersList"], null, 1, -1);
		saveForm("GradesList", [null], null, 1, -1);
		saveForm("GradesPSList", [null], null, 1, -1);
		saveForm(f3, [null], null, 1, -1);
	});
</script>