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
				<!-- <h1><i class="nav-icon fas fa-edit"></i> Data Entry</h1> -->
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
			<div class="col-lg-3 col-sm-0">
			</div>
			<div class="col-lg-6 col-sm-12 form_save_dataPersonnelInfo">
				<div class="row">
					<div class="col-md-12">
						<div class="card card-navy">
							<div class="card-header">
								<h3 class="card-title"><i class="fa fa-list"></i> My Subjects and Grades</h3>
								<!-- <div class="card-tools">
									<button type="button" class="btn btn-tool collapseAssignedSectionList" data-card-widget="collapse"><i class="fas fa-plus"></i>
									</button>
								</div> -->
							</div> <!-- /.card -->
							<!-- /.card-header -->
							<div class="card-body">
								<div class="row">
									<div class="col-12 mt-1">
										<div class="card">
											<!-- <div class="card-header">
												<h4 class="card-title w-100 my-n1">
													My Subjects and Grades
												</h4>
											</div> -->
											<div class="card-body p-1 table-responsive">
												<table class="table table-sm table-hover table-striped" id="tblGradesList" width="100%">
													<thead>
														<tr>
															<th>Subject</th>
															<th>Q1</th>
															<th>Q2</th>
															<th>Q3</th>
															<th>Q4</th>
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
			<div class="col-lg-3 col-sm-0">
			</div>
		</div>
	</div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<script type="text/javascript">
	$(function() {
		// let f1 = "EnrollmentInfo";
		// let f2 = "GradeSecInfo";
		// getTable("AssignedSectionList", 1, -1);
		// getTable("LearnersList", 0, -1);
		// getTable("SearchEnrollLearnersList", 0, 10);
		getTable("GradesList", 0, -1);
		// getFetchList(f1, "CityMunList", null, 1, {
		// 	v: 1602
		// }, 1);
		// getFetchList(f1, "BarangayList", null, 1, {
		// 	v: 160201
		// }, 0);
		// getFetchList(f1, "PurokList", null, 1, {
		// 	v: null
		// }, 0);
		// saveForm(f1, [f1], null);
		// saveForm("GradesList", [null], null, 1, -1);
	});
</script>