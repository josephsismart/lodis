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
							<!-- /.card-header -->
							<div class="card-body">
								<div class="row">
									<div class="col-lg-9 col-md-6 col-sm-8 col-xs-6">
										<div class="post">
											<div class="user-block">
												<img class="img-circle img-bordered-sm" src="<?= base_url(); ?>/dist/img/avatar1.jpg" alt="user image">
												<span class="username">
													<a href="#" class="personnel">-</a>
													<!-- <a href="#" class="personnel">Jonathan Burke Jr. - Teacher I</a> -->
													<!-- <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a> -->
												</span>
												<span class="description">-</span>
												<!-- <span class="description">Class Advisory <b>Grade XII - ABCD</b> <small><i>ARTS</i> | <i>WD</i></small></span> -->
											</div>
										</div>
									</div>
									<div class="col-lg-3 col-md-6 col-sm-4 col-xs-6 mb-2">
										<span class="others">
										</span>
										<span class="grade_all">
										</span>
										<span class="grade">
										</span>
										<span class="enroll">
										</span>
									</div>
									<div class="col-12">
										<div class="list-group">
											<div class="list-group-item">
												<div class="row">
													<div class="col-lg-12 col-md-12">
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
											<div class="card-body p-1 table-responsive">
												<table class="table table-sm table-hover table-striped" id="tblLearnersList" width="100%">
													<thead>
														<tr>
															<th width="1"></th>
															<th>LRN</th>
															<th>Personal Details</th>
															<th>Sex</th>
															<th>Birthdate</th>
															<th>Address Details</th>
															<th>Status</th>
														</tr>
													</thead>
													<tbody>
														<!-- <tr>
													<td>a</td>
													<td>a</td>
													<td>a</td>
													<td>a</td>
												</tr> -->
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- /.card-body -->
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
		getTable("AssignedSectionList", 1, -1);
		getTable("LearnersList", 0, -1);
		getTable("SearchEnrollLearnersList", 0, 10);
		getTable("GradesList", 0, -1);
		getFetchList(f1, "CityMunList", null, 1, {
			v: 1602
		}, 1, 1);
		getFetchList(f1, "BarangayList", null, 1, {
			v: 160201
		}, 0, 1);
		saveForm(f1, ["LearnersList"], null, 1, -1);
		saveForm("GradesList", [null], null, 1, -1);
	});
</script>