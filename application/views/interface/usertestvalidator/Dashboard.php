<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Highcharts -->
<script src="<?= base_url() ?>assets/plugins/Highcharts-8.0.4/code/highcharts.js"></script>
<script src="<?= base_url() ?>assets/plugins/Highcharts-8.0.4/code/highcharts-3d.js"></script>
<script src="<?= base_url() ?>assets/plugins/Highcharts-8.0.4/code/modules/sankey.js"></script>
<script src="<?= base_url() ?>assets/plugins/Highcharts-8.0.4/code/modules/organization.js"></script>
<script src="<?= base_url() ?>assets/plugins/Highcharts-8.0.4/code/modules/exporting.js"></script>
<script src="<?= base_url() ?>assets/plugins/Highcharts-8.0.4/code/modules/accessibility.js"></script>
<script src="<?= base_url() ?>assets/plugins/Highcharts-8.0.4/code/modules/export-data.js"></script>
<script src="<?= base_url() ?>assets/plugins/Highcharts-8.0.4/code/modules/drilldown.js"></script>
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.form.min.js"></script>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <!-- <h1 class="m-0 text-dark">Dashboard</h1> -->
        <h1 class="m-0 text-dark">Dashboard as of <b><?= Date('F d, Y') ?></b></h1>
      </div><!-- /.col -->
      <!-- <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard v1</li>
        </ol>
      </div> --><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">

    <div class="row">
          <div class="col-lg-2 col-md-4 col-12">
            <!-- small box -->
            <div class="small-box bg-orange">
              <div class="inner text-white">
                <!-- <h3><?= $dashboard_data[0]['cc'] ?></h3> -->
                <!-- <p>Total</p> -->
                <div class="row p-0">
                    <div class="col-lg-12 col-12">
                        <div class="small-box bg-orange mb-2 p-1">
                          <div class="inner text-white text-center p-0">
                            <h3><?= $dashboard_data[0]['cc'] ?></h3>
                            <!-- <p>NEW</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white"><b>TOTAL CONFIRMED CASES</b></x></a>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="small-box bg-orange mb-1 p-1">
                          <div class="inner text-white text-center p-0">
                            <h4><?= $dashboard_data[1]['cc'] ?></h4>
                            <!-- <p>ACTIVE</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white">NEW</x></a>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="small-box bg-orange mb-1 p-1">
                          <div class="inner text-white text-center p-0">
                            <h4><?= number_format($dashboard_data[0]['cc2']-($dashboard_data[3]['cc2']+$dashboard_data[5]['cc2'])) ?></h4>
                            <!-- <p>TOTAL</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white">ACTIVE</x></a>
                        </div>
                    </div>
                </div>

              </div>
              <div class="icon">
                <i class="fa fa-virus"></i>
              </div>
              <!-- <a href="#" class="small-box-footer"><x class="text-white">CONFIRMED CASES</a> -->
              <!-- <a href="#" class="small-box-footer"><x class="text-white">More info </x><i class="fas fa-arrow-circle-right text-white"></i></a> -->
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-2 col-md-4 col-12">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner text-white">
                <!-- <h3><?= $dashboard_data[0]['cc'] ?></h3> -->
                <!-- <p>Total</p> -->
                <div class="row p-0">
                    <div class="col-lg-12 col-12">
                        <div class="small-box bg-green mb-2 p-1">
                          <div class="inner text-white text-center p-0">
                            <h3><?= $dashboard_data[3]['cc'] ?></h3>
                            <!-- <p>NEW</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white"><b>TOTAL RECOVERIES</b></x></a>
                        </div>
                    </div>

                    <div class="col-lg-12 col-12">
                        <div class="small-box bg-green mb-1 p-1">
                          <div class="inner text-white text-center p-0">
                            <h4><?= $dashboard_data[4]['cc'] ?></h4>
                            <!-- <p>ACTIVE</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white">NEW</x></a>
                        </div>
                    </div>
                </div>

              </div>
              <div class="icon">
                <i class="fa fa-child"></i>
              </div>
              <!-- <a href="#" class="small-box-footer"><x class="text-white">CONFIRMED CASES</a> -->
              <!-- <a href="#" class="small-box-footer"><x class="text-white">More info </x><i class="fas fa-arrow-circle-right text-white"></i></a> -->
            </div>
          </div>

          <!-- ./col -->
          <div class="col-lg-2 col-md-4 col-12">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner text-white">
                <!-- <h3><?= $dashboard_data[0]['cc'] ?></h3> -->
                <!-- <p>Total</p> -->
                <div class="row p-0">
                    <div class="col-lg-12 col-12">
                        <div class="small-box bg-danger mb-2 p-1">
                          <div class="inner text-white text-center p-0">
                            <h3><?= $dashboard_data[5]['cc'] ?></h3>
                            <!-- <p>NEW</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white"><b>TOTAL DEATHS</b></x></a>
                        </div>
                    </div>

                    <div class="col-lg-12 col-12">
                        <div class="small-box bg-danger mb-1 p-1">
                          <div class="inner text-white text-center p-0">
                            <h4><?= $dashboard_data[6]['cc'] ?></h4>
                            <!-- <p>ACTIVE</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white">NEW</x></a>
                        </div>
                    </div>

                </div>

              </div>
              <div class="icon">
                <i class="fa fa-skull"></i>
              </div>
              <!-- <a href="#" class="small-box-footer"><x class="text-white">CONFIRMED CASES</a> -->
              <!-- <a href="#" class="small-box-footer"><x class="text-white">More info </x><i class="fas fa-arrow-circle-right text-white"></i></a> -->
            </div>
          </div>

          <!-- ./col -->
          <div class="col-lg-3 col-12">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner text-white">
                <!-- <h3><?= $dashboard_data[0]['cc'] ?></h3> -->
                <!-- <p>Total</p> -->
                <div class="custom-control custom-checkbox ml-1">
                    <input class="custom-control-input checkbox-toggle" type="checkbox" id="RDTviewAll" checked="true" onclick="viewRDT()">
                    <label for="RDTviewAll" class="custom-control-label" style="cursor:pointer;">INCLUDE NON RESIDENT</label>
                </div>
                <div class="row p-0 RDTviewAll">
                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-warning mb-2 p-1">
                          <div class="inner text-white text-center p-0">
                            <h3><?= $dashboard_data[7]['cc'] ?></h3>
                            <!-- <p>NEW</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white"><b>NEGATIVE</b></x></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-warning mb-2 p-1">
                          <div class="inner text-white text-center p-0">
                            <h3><?= $dashboard_data[8]['cc'] ?></h3>
                            <!-- <p>NEW</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white"><b>POSITIVE</b></x></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-warning mb-2 p-1">
                          <div class="inner text-white text-center p-0">
                            <h3><?= number_format($dashboard_data[7]['cc2']+$dashboard_data[8]['cc2']) ?></h3>
                            <!-- <p>NEW</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white"><b>RDT/PERSON</b></x></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-warning mb-1 p-1">
                          <div class="inner text-white text-center p-0">
                            <h4><?= $dashboard_data[9]['cc'] ?></h4>
                            <!-- <p>ACTIVE</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white">NEW (-)</x></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-warning mb-1 p-1">
                          <div class="inner text-white text-center p-0">
                            <h4><?= $dashboard_data[10]['cc'] ?></h4>
                            <!-- <p>ACTIVE</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white">NEW (+)</x></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-warning mb-1 p-1">
                          <div class="inner text-white text-center p-0">
                            <h4><?= number_format($dashboard_data[9]['cc2']+$dashboard_data[10]['cc2']) ?></h4>
                            <!-- <p>ACTIVE</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white">DAILY TOTAL</x></a>
                        </div>
                    </div>

                </div>


                <div class="row p-0 RDTviewR" style="display: none;">
                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-warning mb-2 p-1">
                          <div class="inner text-white text-center p-0">
                            <h3><?= $dashboard_data[15]['cc'] ?></h3>
                            <!-- <p>NEW</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white"><b>NEGATIVE</b></x></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-warning mb-2 p-1">
                          <div class="inner text-white text-center p-0">
                            <h3><?= $dashboard_data[16]['cc'] ?></h3>
                            <!-- <p>NEW</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white"><b>POSITIVE</b></x></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-warning mb-2 p-1">
                          <div class="inner text-white text-center p-0">
                            <h3><?= number_format($dashboard_data[15]['cc2']+$dashboard_data[16]['cc2']) ?></h3>
                            <!-- <p>NEW</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white"><b>RDT/PERSON</b></x></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-warning mb-1 p-1">
                          <div class="inner text-white text-center p-0">
                            <h4><?= $dashboard_data[17]['cc'] ?></h4>
                            <!-- <p>ACTIVE</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white">NEW (-)</x></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-warning mb-1 p-1">
                          <div class="inner text-white text-center p-0">
                            <h4><?= $dashboard_data[18]['cc'] ?></h4>
                            <!-- <p>ACTIVE</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white">NEW (+)</x></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-warning mb-1 p-1">
                          <div class="inner text-white text-center p-0">
                            <h4><?= number_format($dashboard_data[17]['cc2']+$dashboard_data[18]['cc2']) ?></h4>
                            <!-- <p>ACTIVE</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white">DAILY TOTAL</x></a>
                        </div>
                    </div>

                </div>

              </div>
              <div class="icon">
                <i class="fa fa-vial"></i>
              </div>
              <!-- <a href="#" class="small-box-footer"><x class="text-white">CONFIRMED CASES</a> -->
              <!-- <a href="#" class="small-box-footer"><x class="text-white">More info </x><i class="fas fa-arrow-circle-right text-white"></i></a> -->
            </div>
          </div>

          <!-- ./col -->
          <div class="col-lg-3 col-12">
            <!-- small box -->
            <div class="small-box bg-purple">
              <div class="inner text-white">
                <!-- <h3><?= $dashboard_data[0]['cc'] ?></h3> -->
                <!-- <p>Total</p> -->
                <div class="custom-control custom-checkbox ml-1">
                    <input class="custom-control-input checkbox-toggle" type="checkbox" id="PCRviewAll" checked="true" onclick="viewPCR()">
                    <label for="PCRviewAll" class="custom-control-label" style="cursor:pointer;">INCLUDE NON RESIDENT</label>
                </div>
                <div class="row p-0 PCRviewAll">
                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-purple mb-2 p-1">
                          <div class="inner text-white text-center p-0">
                            <h3><?= $dashboard_data[11]['cc'] ?></h3>
                            <!-- <p>NEW</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white"><b>NEGATIVE</b></x></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-purple mb-2 p-1">
                          <div class="inner text-white text-center p-0">
                            <h3><?= $dashboard_data[12]['cc'] ?></h3>
                            <!-- <p>NEW</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white"><b>POSITIVE</b></x></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-purple mb-2 p-1">
                          <div class="inner text-white text-center p-0">
                            <h3><?= number_format($dashboard_data[11]['cc2']+$dashboard_data[12]['cc2']) ?></h3>
                            <!-- <p>NEW</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white"><b>PCR/PERSON</b></x></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-purple mb-1 p-1">
                          <div class="inner text-white text-center p-0">
                            <h4><?= $dashboard_data[13]['cc'] ?></h4>
                            <!-- <p>ACTIVE</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white">NEW (-)</x></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-purple mb-1 p-1">
                          <div class="inner text-white text-center p-0">
                            <h4><?= $dashboard_data[14]['cc'] ?></h4>
                            <!-- <p>ACTIVE</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white">NEW (+)</x></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-purple mb-1 p-1">
                          <div class="inner text-white text-center p-0">
                            <h4><?= number_format($dashboard_data[13]['cc2']+$dashboard_data[14]['cc2']) ?></h4>
                            <!-- <p>ACTIVE</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white">DAILY TOTAL</x></a>
                        </div>
                    </div>
                </div>

                <div class="row p-0 PCRviewR" style="display: none;">
                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-purple mb-2 p-1">
                          <div class="inner text-white text-center p-0">
                            <h3><?= $dashboard_data[19]['cc'] ?></h3>
                            <!-- <p>NEW</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white"><b>NEGATIVE</b></x></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-purple mb-2 p-1">
                          <div class="inner text-white text-center p-0">
                            <h3><?= $dashboard_data[20]['cc'] ?></h3>
                            <!-- <p>NEW</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white"><b>POSITIVE</b></x></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-purple mb-2 p-1">
                          <div class="inner text-white text-center p-0">
                            <h3><?= number_format($dashboard_data[19]['cc2']+$dashboard_data[20]['cc2']) ?></h3>
                            <!-- <p>NEW</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white"><b>PCR/PERSON</b></x></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-purple mb-1 p-1">
                          <div class="inner text-white text-center p-0">
                            <h4><?= $dashboard_data[21]['cc'] ?></h4>
                            <!-- <p>ACTIVE</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white">NEW (-)</x></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-purple mb-1 p-1">
                          <div class="inner text-white text-center p-0">
                            <h4><?= $dashboard_data[22]['cc'] ?></h4>
                            <!-- <p>ACTIVE</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white">NEW (+)</x></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-purple mb-1 p-1">
                          <div class="inner text-white text-center p-0">
                            <h4><?= number_format($dashboard_data[21]['cc2']+$dashboard_data[22]['cc2']) ?></h4>
                            <!-- <p>ACTIVE</p> -->
                          </div>
                            <a href="#" class="small-box-footer"><x class="text-white">DAILY TOTAL</x></a>
                        </div>
                    </div>
                </div>

              </div>
              <div class="icon">
                <i class="fa fa-vial"></i>
              </div>
              <!-- <a href="#" class="small-box-footer"><x class="text-white">CONFIRMED CASES</a> -->
              <!-- <a href="#" class="small-box-footer"><x class="text-white">More info </x><i class="fas fa-arrow-circle-right text-white"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
    </div>

    <!-- /.row -->
    <!-- Main row -->
    <!-- /.row (main row) -->
  </div><!-- /.container-fluid -->
  <div class="row m-0">

    <div class="col-md-6">
      <div class="card">
          <div class="card-header">
            <h5 class="card-title"><i class="fa fa-virus"></i> <b>COVID 19</b> GRAPHICAL REPRESENTATION</h5>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <div class="btn-group show">
                <!-- <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                  <i class="fas fa-wrench"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-end">
                  <a href="#" class="dropdown-item">Action</a>
                  <a href="#" class="dropdown-item">Another action</a>
                  <a href="#" class="dropdown-item">Something else here</a>
                  <a class="dropdown-divider"></a>
                  <a href="#" class="dropdown-item">Separated link</a>
                </div> -->
              </div>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <!-- <p class="text-center">
                  <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>
                </p> -->
                <div id="container1" style="height: 530px;margin:-15px;"></div>
              </div>
            </div>
          </div>
          <div class="overlay dark container1">
            <i  style="font-size:100px;color:#fff;" class="fa fa-circle-notch fa-spin"></i>
          </div>
      </div>
    </div>


    <div class="col-md-6">
      <div class="card">
          <div class="card-header">
            <h5 class="card-title text-uppercase">ACCUMULATED <b>COVID 19 CONFIRMED CASE</b> PER BARANGAY AS OF <b><?= Date('F d, Y') ?></b></h5>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <!-- <div class="btn-group show">
                <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                  <i class="fas fa-wrench"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-end">
                  <a href="#" class="dropdown-item">Action</a>
                  <a href="#" class="dropdown-item">Another action</a>
                  <a href="#" class="dropdown-item">Something else here</a>
                  <a class="dropdown-divider"></a>
                  <a href="#" class="dropdown-item">Separated link</a>
                </div>
              </div> -->
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <!-- <p class="text-center">
                  <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>
                </p> -->

                  <div class="table-responsive mailbox-messages" style="height: 500px;">
                      <table id="tbl_covid19_confirmed_barangay" style="width:100%;white-space:nowrap;" class="table table-bordered table-hover table-data-checkbox">
                        <thead>
                        <tr>
                          <th width="1">#</th>
                          <th><i class='fa fa-home'></i> BARANGAY</th>
                          <th width="1"><i class="fa fa-virus"></i> TOTAL</th>
                          <th width="1"><i class="fa fa-virus"></i> ACTIVE</th>
                          <th width="1"><i class="fa fa-child"></i> RECOVERED</th>
                          <th width="1"><i class="fa fa-skull"></i> DEATH</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                  </div>

                <!-- /.chart-responsive -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <div class="overlay dark containerTbl">
            <i  style="font-size:100px;color:#fff;" class="fa fa-circle-notch fa-spin"></i>
          </div>
          <!-- ./card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->

    <div class="col-md-6">
      <div class="card">
          <div class="card-header">
            <h5 class="card-title"><i class="fa fa-vial"></i> <b>RDT & PCR</b> GRAPHICAL REPRESENTATION</h5>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <div class="btn-group show">
                <!-- <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                  <i class="fas fa-wrench"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-end">
                  <a href="#" class="dropdown-item">Action</a>
                  <a href="#" class="dropdown-item">Another action</a>
                  <a href="#" class="dropdown-item">Something else here</a>
                  <a class="dropdown-divider"></a>
                  <a href="#" class="dropdown-item">Separated link</a>
                </div> -->
              </div>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">


                <div class="row">
                    <!-- <div class="col-12">
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            
                            <select class="form-control" name="selectYearTest">
                               <option value="">VIEW ALL</option>
                               <?php foreach ($getYearMonth['data1'] as $key => $value): ?>
                                   <option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>
                               <?php endforeach ?>
                             </select>

                            <div class="input-group-append">
                              <button type="button" class="btn btn-warning btn-sm text-white searchBtn" onclick="$('#tbl_person_covid19 tobdy').empty();$('#tbl_person_covid19').DataTable().ajax.reload();$(this).html('<span class=\'fa fa-spinner fa-spin\'></span>');$(this).attr('disabled',true);"><i class="fas fa-search"></i></span></button>
                            </div>
                        </div>
                    </div> -->

                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                          <div class="inner text-white">
                            <h3 class="totalRDT"></h3>

                            <p>RAPID DIAGNOSTIC TEST (RDT)</p>
                          </div>
                          <div class="icon">
                            <i class="fa fa-vial"></i>
                          </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <!-- small box -->
                        <div class="small-box bg-purple">
                          <div class="inner text-white">
                            <h3 class="totalPCR"></h3>

                            <p>POLYMERASE CHAIN REACTION (PCR)</p>
                          </div>
                          <div class="icon">
                            <i class="fa fa-vial"></i>
                          </div>
                        </div>
                    </div>
                  <!-- /.col -->
                </div>

                <!-- <p class="text-center">
                  <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>
                </p> -->
                <div id="container2" style="height: 530px;margin:-15px;"></div>
              </div>
            </div>
          </div>
          <div class="overlay dark container2">
            <i  style="font-size:100px;color:#fff;" class="fa fa-circle-notch fa-spin"></i>
          </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card">
          <div class="card-header">
            <h5 class="card-title"><i class="fa fa-mars"></i> <b>INFECTED BASED ON GENDER</b> GRAPHICAL REPRESENTATION</h5>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <div class="btn-group show">
                <!-- <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                  <i class="fas fa-wrench"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-end">
                  <a href="#" class="dropdown-item">Action</a>
                  <a href="#" class="dropdown-item">Another action</a>
                  <a href="#" class="dropdown-item">Something else here</a>
                  <a class="dropdown-divider"></a>
                  <a href="#" class="dropdown-item">Separated link</a>
                </div> -->
              </div>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">

                <!-- <p class="text-center">
                  <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>
                </p> -->
                <div id="container3" style="height: 660px;margin:-15px;"></div>
              </div>
            </div>
          </div>
          <div class="overlay dark container3">
            <i  style="font-size:100px;color:#fff;" class="fa fa-circle-notch fa-spin"></i>
          </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card">
          <div class="card-header">
            <h5 class="card-title"><i class="fas fa-list-alt"></i> <b>INFECTED BASED ON CATEGORY</b> GRAPHICAL REPRESENTATION</h5>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <div class="btn-group show">
                <!-- <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                  <i class="fas fa-wrench"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-end">
                  <a href="#" class="dropdown-item">Action</a>
                  <a href="#" class="dropdown-item">Another action</a>
                  <a href="#" class="dropdown-item">Something else here</a>
                  <a class="dropdown-divider"></a>
                  <a href="#" class="dropdown-item">Separated link</a>
                </div> -->
              </div>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">

                <!-- <p class="text-center">
                  <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>
                </p> -->
                <div id="container4" style="height: 660px;margin:-15px;"></div>
              </div>
            </div>
          </div>
          <div class="overlay dark container4">
            <i  style="font-size:100px;color:#fff;" class="fa fa-circle-notch fa-spin"></i>
          </div>
      </div>
    </div>

  </div>
</section>
<script type="text/javascript">

    $(function(){
      $("#tbl_covid19_confirmed_barangay tbody").empty();
        var tbl_covid19_confirmed_barangay, tbl_covid19_confirmed_barangay_data;
            tbl_covid19_confirmed_barangay = $("#tbl_covid19_confirmed_barangay").DataTable({
                                "columnDefs": [ {
                                  "orderable": false,
                                }],
                                dom: 'Bfrtip',
                                buttons: [
                                    'pageLength', 
                                    {
                                        text: "<i class='fa fa-redo-alt'></i>",
                                        action: function(e, dt, node, config) {
                                            $('#tbl_covid19_confirmed_barangay').DataTable().ajax.reload();
                                        }
                                    }
                                ],
                                "oLanguage": { "sSearch": "" },
                                language: {
                                    searchPlaceholder: "Search...",
                                },
                                "paging": true,
                                "pageLength": 10,
                                "lengthChange": false,
                                "searching": true,
                                "ordering": true,
                                "info": false,
                                "autoWidth": true,
                                ajax: {
                                    url: "<?= base_url('usertestvalidator/Dashboard/getCovid19Confirmed') ?>",
                                    type: "POST",
                                    data:
                                    function(d) {
                                      //d.personId=$("#personQStatusId").val();
                                      return tbl_covid19_confirmed_barangay_data;
                                    }
                                }
                            });

                            $("#tbl_covid19_confirmed_barangay").on("draw.dt", function () {
                                $(".containerTbl").slideUp();
                            });
    })

    function viewRDT(){
        if($("#RDTviewAll").prop("checked")==false){
            $(".RDTviewAll").slideUp();
            $(".RDTviewR").slideDown();
        }else{
            $(".RDTviewAll").slideDown();
            $(".RDTviewR").slideUp();
        }
    }

    function viewPCR(){
        if($("#PCRviewAll").prop("checked")==false){
            $(".PCRviewAll").slideUp();
            $(".PCRviewR").slideDown();
        }else{
            $(".PCRviewAll").slideDown();
            $(".PCRviewR").slideUp();
        }
    }

    covidGraph();
    testGraph();
    covidGraphGender();
    covidGraphCategory();

    function covidGraph(){
        $.post("<?= base_url() ?>" + 'usertestvalidator/dashboard/covidGraph',
            //{ value: $("#year1").val() },
            function(data) {
                var result = JSON.parse(data);
                Highcharts.chart('container1', {
                    chart: {
                        type: ''
                    },
                    title: {
                        text: 'COVID 19 STATUS'//+$("#year1").val()
                    },
                    subtitle: {
                        text: 'ACCUMULATED COVID 19 STATUS'
                    },
                    xAxis: {
                        categories: result['date'],
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'ACCUMULATED COVID 19 STATUS'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:12px;font-family:arial">Date:<b>{point.key}</b></span>,   Day:<table style="font-size:15px;font-family:arial;font-weight:bold;"><thead style="font-size:9px;"><th>CASE </th><th>ADDED</th><th style="padding-left:20px">TOTAL</th></thead>',
                        pointFormat: ''+
                            '<b>{point.day:.0f}</b>'+
                            '<tr style="color:{series.color};"><td style="padding:0">{series.name}: </td>' +
                            '<td style="padding:0" align="center">{point.a:.0f}</td>'+
                            '<td style="padding:0" align="right"><b>{point.y:.0f}</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true,
                        crosshairs: [true]
                    },

                    // tooltip: {
                    //     headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    //     pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    //         '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
                    //     footerFormat: '</table>',
                    //     shared: true,
                    //     useHTML: true
                    // },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [{
                        name: 'CONFIRMED',
                        data:  result['confirmed'],
                        color: '#fd7e14',
                    },{
                        name: 'RECOVERED',
                        data:  result['recovered'],
                        color: '#28a745',
                    },{
                        name: 'DEATHS',
                        data:  result['deaths'],
                        color: '#dc3545',
                    }

                    
                    // , {
                    //     name: 'Medical',
                    //     data: result['medical'],
                    //     color: '#39cccc'
                    // }
                    ],

                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    }
                });
            }).done(function(){
                $(".container1").slideUp();
            });
    }

    function testGraph(){
        $.post("<?= base_url() ?>" + 'usertestvalidator/dashboard/testGraph',
            //{ value: $("#year1").val() },
            function(data) {
                var result = JSON.parse(data);
                $(".totalRDT").text(result["testTotal"][0]["TOTALRDT"]);
                $(".totalPCR").text(result["testTotal"][0]["TOTALPCR"]);
                Highcharts.chart('container2', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'TESTS CONDUCTED'//+$("#year1").val()
                    },
                    subtitle: {
                        text: 'CLICK TO VIEW RDT AND PCR TESTS CONDUCTED PER DAY'
                    },
                    xAxis: {
                        type: 'category'
                    },
                    // xAxis: {
                    //     categories: result['category'],
                    //     crosshair: true
                    // },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'ACCUMULATED COVID 19 STATUS'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:12px;font-family:arial">Date:<b>{point.key}</b></span><table style="font-size:15px;font-family:arial;font-weight:bold;"><thead style="font-size:9px;"><th>TEST </th><th style="padding-left:30px;">TOTAL</th></thead>',
                        pointFormat: ''+
                            '<tr style="color:{series.color};"><td style="padding:0">{series.name}: </td>' +
                            '<td style="padding:0;color:black;" align="right"><b>{point.b:.0f}</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true,
                        crosshairs: [true]
                    },

                    // tooltip: {
                    //     headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    //     pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    //         '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
                    //     footerFormat: '</table>',
                    //     shared: true,
                    //     useHTML: true
                    // },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        },
                        series: {
                            borderWidth: 0,
                            dataLabels: {
                                enabled: true,
                                format: '{point.b:.0f}'
                            }
                        }
                    },
                    series: [{
                        name: 'RDT',
                        data:  result['RDT'],
                        color: '#ffc107',
                    },{
                        name: 'PCR',
                        data:  result['PCR'],
                        color: '#6f42c1',
                    }],

                    drilldown:{
                        series: result["drilldown"],
                    },

                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    }
                });
            }).done(function(){
                $(".container2").slideUp();
            });
    }

    function covidGraphGender(){
        $.post("<?= base_url() ?>" + 'usertestvalidator/dashboard/covidGraphGender',
            //{ value: $("#year1").val() },
            function(data) {
                var result = JSON.parse(data);
                Highcharts.chart('container3', {
                    chart: {
                        type: 'pie',
                    },
                    title: {
                        text: 'CONFRIMED CASE BASED ON GENDER'//+$("#year1").val()
                    },
                    subtitle: {
                        text: 'CLICK TO VIEW BARANGAY DESTRIBUTION'
                    },
                    xAxis: {
                        type: 'category'
                    },
                    // xAxis: {
                    //     categories: result['category'],
                    //     crosshair: true
                    // },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'CONFRIMED CASE BASED ON GENDER'
                        }
                    },
                    tooltip: {
                        //headerFormat: '<span style="font-size:12px;font-family:arial">{point.key}</b></span><table style="font-size:15px;font-family:arial;font-weight:bold;"><thead style="font-size:9px;"><th>TEST </th><th style="padding-left:30px;">TOTAL</th></thead>',
                        pointFormat: ''+
                            '<tr style="color:{series.color};"><td style="padding:0">{series.name}: </td>' +
                            '<td style="padding:0;color:black;" align="right"><b>{point.b:.0f}</b></td></tr><br/>' +
                            '<tr style="color:{series.color};"><td style="padding:0">PERCENTAGE: </td>' +
                            '<td style="padding:0;color:black;" align="right"><b>{point.p:.2f}%</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true,
                        crosshairs: [true]
                    },

                    // tooltip: {
                    //     headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    //     pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    //         '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
                    //     footerFormat: '</table>',
                    //     shared: true,
                    //     useHTML: true
                    // },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        },
                        pie: {
                            //innerSize: 250,
                            //depth: 100
                            size:400,
                        },
                        series: {
                            borderWidth: 2,
                            dataLabels: {
                                enabled: true,
                                //format: '<div style="color:{point.color};font-size:15px;"> {point.name}: {point.b:.0f} , {point.p:.2f}% </div>'
                            }
                        }
                    },
                    series: [{
                        name: 'GENDER',
                        data:  result['GENDER'],
                        //color: '#ffc107',
                    }],

                    drilldown:{
                        series: result["drilldown"],
                    },

                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    }
                });
            }).done(function(){
                $(".container3").slideUp();
            });
    }

    function covidGraphCategory(){
        $.post("<?= base_url() ?>" + 'usertestvalidator/dashboard/covidGraphCategory',
            //{ value: $("#year1").val() },
            function(data) {
                var result = JSON.parse(data);
                Highcharts.chart('container4', {
                    chart: {
                        type: 'pie',
                    },
                    title: {
                        text: 'CONFRIMED CASE BASED ON CATEGORY'//+$("#year1").val()
                    },
                    subtitle: {
                        text: 'CLICK TO VIEW BARANGAY DESTRIBUTION'
                    },
                    xAxis: {
                        type: 'category'
                    },
                    // xAxis: {
                    //     categories: result['category'],
                    //     crosshair: true
                    // },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'CONFRIMED CASE BASED ON CATEGORY'
                        }
                    },
                    tooltip: {
                        //headerFormat: '<span style="font-size:12px;font-family:arial">{point.key}</b></span><table style="font-size:15px;font-family:arial;font-weight:bold;"><thead style="font-size:9px;"><th>TEST </th><th style="padding-left:30px;">TOTAL</th></thead>',
                        pointFormat: ''+
                            '<tr style="color:{series.color};"><td style="padding:0">{series.name}: </td>' +
                            '<td style="padding:0;color:black;" align="right"><b>{point.b:.0f}</b></td></tr><br/>' +
                            '<tr style="color:{series.color};"><td style="padding:0">PERCENTAGE: </td>' +
                            '<td style="padding:0;color:black;" align="right"><b>{point.p:.2f}%</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true,
                        crosshairs: [true]
                    },

                    // tooltip: {
                    //     headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    //     pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    //         '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
                    //     footerFormat: '</table>',
                    //     shared: true,
                    //     useHTML: true
                    // },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        },
                        pie: {
                            innerSize: 150,
                            //depth: 100,
                            size: 400,
                        },
                        series: {
                            borderWidth: 2,
                            dataLabels: {
                                enabled: true,
                                //format: '<div style="color:{point.color};font-size:15px;"> {point.name}: {point.b:.0f} , {point.p:.2f}% </div>'
                            }
                        }
                    },
                    series: [{
                        name: 'CATEGORY',
                        data:  result['CATEGORY'],
                        //color: '#ffc107',
                    }],

                    drilldown:{
                        series: result["drilldown"],
                    },

                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    }
                });
            }).done(function(){
                $(".container4").slideUp();
            });
    }
</script>

<!-- /.content -->