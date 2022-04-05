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
				<h1><i class="nav-icon fas fa-tachometer-alt"></i> Dashboard</h1>
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
			<div class="col-lg-4 col-sm-4 col-12">
				<!-- small card -->
				<div class="small-box bg-info">
					<a href="#" class="small-box-footer">
						Number of Enrollee <i class="fas fa-graduation-cap"></i>
					</a>
					<div class="inner p-1">
						<div class="row mb-n3">
							<div class="col-lg-4 col-sm-12 col-4">
								<div class="small-box bg-info">
									<div class="inner text-center">
										<h3><?= $getSHdboard["emale"]; ?></h3>
									</div>
									<a href="#" class="small-box-footer">
										Male <i class="fas fa-male"></i>
									</a>
								</div>
							</div>
							<div class="col-lg-4 col-sm-12 col-4">
								<div class="small-box bg-info">
									<div class="inner text-center">
										<h3><?= $getSHdboard["efmale"]; ?></h3>
									</div>
									<a href="#" class="small-box-footer">
										Female <i class="fas fa-female"></i>
									</a>
								</div>
							</div>
							<div class="col-lg-4 col-sm-12 col-4">
								<div class="small-box bg-info">
									<div class="inner text-center">
										<h3><?= $getSHdboard["tenroll"]; ?></h3>
									</div>
									<a href="#" class="small-box-footer">
										Total
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-4 col-sm-4 col-12">
				<!-- small card -->
				<div class="small-box bg-success">
					<a href="#" class="small-box-footer">
						Teaching Personnel <i class="fas fa-user-tie"></i>
					</a>
					<div class="inner p-1">
						<div class="row mb-n3">
							<div class="col-lg-4 col-sm-12 col-4">
								<div class="small-box bg-success">
									<div class="inner text-center">
										<h3><?= $getSHdboard["tpmale"]; ?></h3>
									</div>
									<a href="#" class="small-box-footer">
										Male <i class="fas fa-male"></i>
									</a>
								</div>
							</div>
							<div class="col-lg-4 col-sm-12 col-4">
								<div class="small-box bg-success">
									<div class="inner text-center">
										<h3><?= $getSHdboard["tpmale"]; ?></h3>
									</div>
									<a href="#" class="small-box-footer">
										Female <i class="fas fa-female"></i>
									</a>
								</div>
							</div>
							<div class="col-lg-4 col-sm-12 col-4">
								<div class="small-box bg-success">
									<div class="inner text-center">
										<h3><?= $getSHdboard["ttpenroll"]; ?></h3>
									</div>
									<a href="#" class="small-box-footer">
										Total
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- ./col -->

			<!-- <div class="col-lg-4 col-sm-4 col-12">
				<div class="small-box bg-warning">
					<div class="inner text-white">
						<div class="row">
							<div class="col-lg-3 col-sm-4 col-4">
								<h3>150</h3>
								<p>Male</p>
							</div>
							<div class="col-lg-3 col-sm-4 col-4">
								<h3>150</h3>
								<p>Female</p>
							</div>
							<div class="col-lg-6 col-sm-4 col-4">
								<h3>150</h3>
								<p>Total</p>
							</div>
						</div>
					</div>
					<div class="icon">
						<i class="fas fa-users"></i>
					</div>
					<a href="#" class="small-box-footer">
						Active User <i class="fas fa-users"></i>
					</a>
				</div>
			</div> -->
			<!-- ./col -->
			<!-- <div class="col-lg-3 col-6">
				<div class="small-box bg-danger">
					<div class="inner">
						<h3>53<sup style="font-size: 20px">%</sup></h3>

						<p>Dropout Percentage</p>
					</div>
					<div class="icon">
						<i class="fas fa-chart-pie"></i>
					</div>
					<a href="#" class="small-box-footer"> 
						More info <i class="fas fa-arrow-circle-right"></i>
					</a>
				</div>
			</div> -->
			<!-- ./col -->
		</div>


		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 form_save_dataGradeSecInfo">
				<div class="card card-navy">
					<div class="card-header p-1 pr-2 pl-2">
						<h3 class="card-title"><i class="fa fa-chart-bar"></i> Male & Female Grade level</h3>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
						</div>
					</div>
					<div class="card-body p-2">
						<div class="row">
							<div class="col-lg-3 col-md-5 col-sm-3 col-xs-3">
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<small class="input-group-text text-xs text-bold p-1">S.Y.</small>
									</div>
									<select class="form-control form-control-sm" name="sex">
										<option value="t">2021-2022</option>
										<option value="f">FEMALE</option>
									</select>
								</div>
							</div>
							<!-- <div class="col-lg-3 col-md-5 col-sm-3 col-xs-3">
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<small class="input-group-text text-xs text-bold p-1">QRTR</small>
									</div>
									<select class="form-control form-control-sm" name="sex">
										<option value="t">Q1</option>
										<option value="f">FEMALE</option>
									</select>
								</div>
							</div> -->
						</div>
						<!-- <figure class="highcharts-figure"> -->
						<div id="container1"></div>
						<!-- <p class="highcharts-description p-2 mb-n2">
							A basic column chart compares rainfall values between four cities.
							Tokyo has the overall highest amount of rainfall, followed by New York.
							The chart is making use of the axis crosshair feature, to highlight
							months as they are hovered over.
						</p> -->
						<!-- </figure> -->
					</div>
				</div>
			</div>


			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 form_save_dataGradeSecInfo">
				<div class="card card-navy">
					<div class="card-header p-1 pr-2 pl-2">
						<h3 class="card-title"><i class="fa fa-chart-bar"></i> Age Bracket Grade level</h3>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
						</div>
					</div>
					<div class="card-body p-2">
						<div id="container2"></div>
					</div>
					<!-- <figure class="highcharts-figure">
						<p class="highcharts-description p-2 mb-n2">
							A basic column chart compares rainfall values between four cities.
							Tokyo has the overall highest amount of rainfall, followed by New York.
							The chart is making use of the axis crosshair feature, to highlight
							months as they are hovered over.
						</p>
					</figure> -->
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