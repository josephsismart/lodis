<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Highcharts -->
<!-- Content Header (Page header) -->
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
				<h1><i class="nav-icon fas fa-folder-open"></i> Reports</h1>
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
			<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 form_save_dataGradeSecInfo">
				<div class="card card-navy">
					<div class="card-header p-1 pr-2 pl-2">
						<h3 class="card-title"><i class="fa fa-chart-bar"></i> Male/Female & 4Ps per Grade level</h3>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
						</div>
					</div>
					<div class="card-body p-2">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12">
							<button type="submit" class="btn btn-info btn-sm btn-block submitBtnMFGradelvl">VIEW REPORT</button>
								<!-- <div class="input-group mb-2">
									<input type="text" class="form-control form-control-sm text-uppercase" name="abbr" placeholder="ABBREVIATION" autocomplete="off">
									<div class="input-group-append">
										<button type="submit" class="btn btn-info btn-sm submitBtnMFGL">VIEW</button>
									</div>
								</div> -->
							</div>
						</div>
					</div>
				</div>
			</div>


			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 form_save_dataGradeSecInfo">
				<div class="card card-navy">
					<div class="card-header p-1 pr-2 pl-2">
						<h3 class="card-title"><i class="fa fa-chart-bar"></i> Age Bracket</h3>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
						</div>
					</div>
					<div class="card-body p-2">
					</div>
				</div>
			</div>

		</div>
	</div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- <script type="text/javascript">
	$(function() {
		let f2 = "GradeSecInfo";
		getTable(f2, 0, 10);
	});
</script> -->