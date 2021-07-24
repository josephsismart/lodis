<!DOCTYPE html>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Butuan COVID-19 Monitoring | Map</title>

  <link rel="icon" type="image/png" href="<?= $system_svg ?>">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/ol3/ol.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/ol3/Popup.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/ol3/LayersControl.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/ol3/ol3.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/toastr/toastr.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
  <style type="text/css">
    /*highcharts*/
    .highcharts-figure, .highcharts-data-table table {
        min-width: 360px; 
        max-width: 800px;
        margin: 1em auto;
    }

    .highcharts-data-table table {
      font-family: Verdana, sans-serif;
      border-collapse: collapse;
      border: 1px solid #EBEBEB;
      margin: 10px auto;
      text-align: center;
      width: 100%;
      max-width: 500px;
    }
    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }
    .highcharts-data-table th {
      font-weight: 600;
        padding: 0.5em;
    }
    .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
        padding: 0.5em;
    }
    .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }
    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }

    #chart5 h4 {
        text-transform: none;
        font-size: 12px;
        font-weight: normal;
        font-family: Arial;
    }
    #chart5 p {
        font-size: 12px;
        line-height: 16px;
        font-family: Arial;
    }

    @media screen and (max-width: 600px) {
        #chart5 h4 {
            font-size: 2.3vw;
            line-height: 3vw;
            font-family: Arial;
        }
        #chart5 p {
            font-size: 2.3vw;
            line-height: 3vw;
            font-family: Arial;
        }
    }
    b{font-weight:bold;}
    r{color:red;
      font-weight:bold;}
    r2{color:red;
      font-weight:bold;
      font-size:17px;}
    bl{color:blue;
    font-weight:bold;}
  </style>
  <style>
    .layers-control {
        position: fixed;
        bottom: 10px;
        top: auto;
    }
    html,
    body,
    #map {
        height: 100%;
        width: 100%;
        overflow: hidden;
    }
   
    #tabulator,
    #menubot {
        z-index: 9999999;
        position: absolute;
    }
    
    .checkbox:hover {
        background-color: gold;
        border-radius: 2px;
    }
    .custom-control-input:checked~.custom-control-label::before {
        color: #fff;
        border-color: #fff; 
        background-color: #001f3f;
        box-shadow: none;
    }
  </style>
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark navbar-dark">
    <div class="container">
      <a href="#" class="navbar-brand">
        <img src="<?= $system_svg ?>" alt="Locator Logo" class="brand-image" style="border: 2px solid white;border-radius: 999em;">
        <span class="brand-text font-weight-light">  </span>
      </a>
      
      <div class="row">
          <div class="input-group input-group-sm">
            <!-- <input class="form-control form-control-navbar" id="search" type="search" placeholder="Search Barangay" aria-label="Search"> -->
            <select class="form-control form-control-navbar select2 searchBarangay">
              <?php foreach ($getBarangay["data1"] as $key => $value): ?>
                <option value="<?= $value["id"] ?>" data-text_area="<?= $value["area"] ?>" data-text_lat="<?= $value["lat"] ?>" data-text_lon="<?= $value["lon"] ?>"><?= $value["text"] ?></option>
              <?php endforeach ?>
            </select>
            <div class="input-group-append">
              <button class="btn btn-navbar" onclick="zoomMap()">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        <!-- </form> -->
      </div>
      <!-- <div class="row">
        
          <div class="input-group input-group-sm">
            <label></label> class="text-warning">DATA IS FOR DEMONSTRATION PURPOSES ONLY. STILL WORK IN PROGRESS</label></label>>
          </div>
      </div> -->

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        
        <li class="nav-item">
          <a class="nav-link" href="#" onclick="zoomCenter();"><i class="fas fa-home"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link clickMe" data-widget="control-sidebar" data-slide="true" href="#"><i class="fas fa-chevron-right"></i></a>
        </li>
      </ul>
    </div>
  </nav>


  <nav class="main-header navbar navbar-expand navbar-dark navbar-dark">
    <div class="container">
      
      <div class="row">
        <label class="text-warning">DATA IS FOR DEMONSTRATION PURPOSES ONLY. STILL WORK IN PROGRESS</label>
      </div>

    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="map">
        <div id="popup" class="ol-popup">
        </div>
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->

    <!-- <aside class="control-sidebar control-sidebar-lightblue"> -->
    <aside class="control-sidebar control-sidebar" style="height: 1000px;">
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                      <!-- /.card-header -->
                <li class="nav-item">
                    <div class="card card-dark color-palette-box">
                      <div class="card-header p-1 text-center" style="border-radius:5px;">
                        <h2 class="card-title text-uppercase text-warning" style="white-space: nowrap;font-size:25px;"><b><?= Date("F d, Y")?></b></h2>
                      </div>
                    </div>
                </li>

                <li class="nav-item">
                    <div class="card card-dark color-palette-box">
                      <div class="card-header" style="padding:5px 10px 5px 10px;">
                        <h2 class="card-title text-warning" style="white-space: nowrap;"><b>BUTUAN CITY DATA</b></h2>
                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                          </button>
                        </div>
                      </div>
                      <div class="card-body bg-dark" style="padding: 0px 10px 0px 10px">
                        <div class="row">
                          <div class="col-12" style="padding: 2px 2px 2px 0px">
                            <div class="color-palette-set">
                              <div class="bg-orange color-palette">
                                <div class="custom-control custom-checkbox">
                                  <input class="custom-control-input" type="checkbox" id="TPS_MAP" checked onclick="showLayer($(this).prop('checked'),covidTPS);">
                                  <label for="TPS_MAP" class="custom-control-label text-white" style="cursor:pointer;"><center class="text-white"><i class="fa fa-virus"></i> <b>CONFIRMED CASES</b></center></label>
                                </div>
                              </div>
                              <div class="bg-dark color-palette"><span><center><h1 class="text-white"><b><?= $getStatusCount[5]["count"] ?></b></h1></center></span></div>
                            </div>
                          </div>
                          <div class="col-6" style="padding: 5px 2px 2px 0px;margin-top:-7px;">
                            <div class="color-palette-set">
                              <div class="bg-danger color-palette">
                                <div class="custom-control custom-checkbox">
                                  <input class="custom-control-input" type="checkbox" id="DED_MAP" checked onclick="showLayer($(this).prop('checked'),covidDED);">
                                  <label for="DED_MAP" class="custom-control-label" style="cursor:pointer;">DEATHS</label>
                                </div>
                              </div>
                              <div class="bg-dark color-palette"><span><center><h1 class="text-white"><b><?= $getStatusCount[2]["count"] ?></b></h1></center></span></div>
                            </div>
                          </div>
                          <div class="col-6" style="padding: 5px 2px 2px 0px;margin-top:-7px;">
                            <div class="color-palette-set">
                              <div class="bg-success color-palette">
                                <div class="custom-control custom-checkbox">
                                  <input class="custom-control-input" type="checkbox" id="REC_MAP" checked onclick="showLayer($(this).prop('checked'),covidREC);">
                                  <label for="REC_MAP" class="custom-control-label" style="cursor:pointer;">RECOVERED</label>
                                </div>
                              </div>
                              <div class="bg-dark color-palette"><span><center><h1 class="text-white"><b><?= $getStatusCount[3]["count"] ?></b></h1></center></span></div>
                            </div>
                          </div>
                          <div class="col-6" style="padding: 5px 2px 2px 0px;margin-top:-7px;">
                            <div class="color-palette-set">
                              <div class="bg-primary color-palette">
                                <div class="custom-control custom-checkbox">
                                  <input class="custom-control-input" type="checkbox" id="SUS_MAP" checked onclick="showLayer($(this).prop('checked'),covidSUS);">
                                  <label for="SUS_MAP" class="custom-control-label" style="cursor:pointer;">SUSPECTED</label>
                                </div>
                              </div>
                              <div class="bg-dark color-palette"><span><center><h1 class="text-white"><b><?= $getStatusCount[0]["count"] ?></b></h1></center></span></div>
                            </div>
                          </div>
                          <div class="col-6" style="padding: 5px 2px 2px 0px;margin-top:-7px;">
                            <div class="color-palette-set">
                              <div class="bg-purple color-palette">
                                <div class="custom-control custom-checkbox">
                                  <input class="custom-control-input" type="checkbox" id="PRO_MAP" checked onclick="showLayer($(this).prop('checked'),covidPRO);">
                                  <label for="PRO_MAP" class="custom-control-label" style="cursor:pointer;">PROBABLE</label>
                                </div>
                              </div>
                              <div class="bg-dark color-palette"><span><center><h1 class="text-white"><b><?= $getStatusCount[1]["count"] ?></b></h1></center></span></div>
                            </div>
                          </div>
                          <div class="col-6" style="padding: 5px 2px 2px 0px;margin-top:-7px;">
                            <div class="color-palette-set">
                              <div class="bg-info color-palette">
                                <div class="custom-control custom-checkbox">
                                  <input class="custom-control-input" type="checkbox" id="PUM_MAP" checked onclick="showLayer($(this).prop('checked'),covidPUM);">
                                  <label for="PUM_MAP" class="custom-control-label" style="cursor:pointer;">PUM</label>
                                </div>
                              </div>
                              <div class="bg-dark color-palette"><span><center><h1 class="text-white"><b><?= $getStatusCount[7]["count"] ?></b></h1></center></span></div>
                            </div>
                          </div>
                          <div class="col-6" style="padding: 5px 2px 2px 0px;margin-top:-7px;">
                            <div class="color-palette-set">
                              <div class="bg-warning color-palette">
                                <div class="custom-control custom-checkbox">
                                  <input class="custom-control-input" type="checkbox" id="CLEARED_MAP" checked onclick="showLayer($(this).prop('checked'),covidCLEARED);">
                                  <label for="CLEARED_MAP" class="custom-control-label" style="cursor:pointer;">CLEARED</label>
                                </div>
                              </div>
                              <div class="bg-dark color-palette"><span><center><h1 class="text-white"><b><?= $getStatusCount[6]["count"] ?></b></h1></center></span></div>
                            </div>
                          </div>
                          <!-- <div class="col-12" style="padding: 2px 2px 2px 0px">
                            <div class="color-palette-set">
                              <div class="bg-warning color-palette"><span><center><i class="fa fa-vial"></i> <b style="font-size:13px;">TESTS CONDUCTED</b></center></span></div>
                              <div class="bg-dark color-palette"><span><center><h1 class="text-white"><b><?= $getStatusCount[4]["count"]+$getStatusCount[5]["count"] ?></b></h1></center></span></div>
                            </div>
                          </div> -->
                        </div>
                      </div>
                      <!-- /.card-body -->
                      <div class="card-footer bg-dark" style="padding:5px 10px 5px 10px;">
                        <button class="btn btn-default btn-xs btn-block" data-toggle="modal" data-target="#graphAnalytics"><b><i class="fa fa-chart-bar"></i> GRAPHICAL PRESENTATION</b></button>
                      </div>
                    </div>
                </li>

                <li class="nav-item" style="width:80%;margin-left:20%">
                    <div class="card card-dark color-palette-box">
                      <div class="card-header" style="padding:5px 10px 5px 10px;">
                        <h2 class="card-title text-warning" style="white-space: nowrap;"><b>NATIONAL DATA</b><br/>
                        </h2>
                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                          </button>
                        </div>
                        <!-- <a href="https://ncovtracker.doh.gov.ph/" target="_blank" style="font-size:9px;">https://ncovtracker.doh.gov.ph/</a> -->
                      </div>
                      <div class="card-body bg-dark" style="padding: 0px 10px 0px 10px">
                        <div class="row">
                          <div class="col-12" style="padding: 2px 2px 2px 0px">
                            <div class="color-palette-set">
                              <div class="bg-orange color-palette"><span><center class="text-white"><i class="fa fa-virus"></i> <b>CONFIRMED CASE</b></center></span></div>
                              <div class="bg-dark color-palette"><span><center><h4 class="text-white"><b><?= $getNational['con']; ?></h4></b></center></span></div>
                            </div>
                          </div>
                          <div class="col-6" style="padding: 5px 2px 2px 0px;margin-top:-7px;">
                            <div class="color-palette-set">
                              <div class="bg-red color-palette"><span><center><i class="fa fa-skull"></i> <b style="font-size:11px;">DEATHS</b></center></span></div>
                              <div class="bg-dark color-palette"><span><center><h4 class="text-white"><b><?= $getNational['dts']; ?></b></h4></center></span></div>
                            </div>
                          </div>
                          <div class="col-6" style="padding: 5px 2px 2px 0px;margin-top:-7px;">
                            <div class="color-palette-set">
                              <div class="bg-success color-palette"><span><center><i class="fa fa-child"></i> <b style="font-size:11px;">RECOVERED</b></center></span></div>
                              <div class="bg-dark color-palette"><span><center><h4 class="text-white"><b><?= $getNational['rcv']; ?></b></h4></center></span></div>
                            </div>
                          </div>
                          <div class="col-6" style="padding: 5px 2px 2px 0px;margin-top:-7px;">
                            <div class="color-palette-set">
                              <div class="bg-primary color-palette"><span><center><i class="fa fa-procedures"></i> <b>PUIs</b></center></span></div>
                              <div class="bg-dark color-palette"><span><center><h4 class="text-white"><b><?= $getNational['pui']; ?></b></h4></center></span></div>
                            </div>
                          </div>
                          <div class="col-6" style="padding: 5px 2px 2px 0px;margin-top:-7px;">
                            <div class="color-palette-set">
                              <div class="bg-purple color-palette"><span><center><i class="fa fa-portrait"></i> <b>PUMs</b></center></span></div>
                              <div class="bg-dark color-palette"><span><center><h4 class="text-white"><b><?= $getNational['pum']; ?></b></h4></center></span></div>
                            </div>
                          </div>
                          <div class="col-12" style="padding: 2px 2px 2px 0px">
                            <div class="color-palette-set">
                              <div class="bg-warning color-palette"><span><center><i class="fa fa-check"></i> <b style="font-size:13px;">CLEARED PUMs</b></center></span></div>
                              <div class="bg-dark color-palette"><span><center><h4 class="text-white"><b><?= $getNational['tst']; ?></b></h4></center></span></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /.card-body -->
                    </div>
                </li>
                <!-- <li class="nav-item">
                    <div class="card card-lightblue" style="width:50%;margin-left: 50%;">
                      <div class="card-header" style="padding:10px;">
                        <center><h3 class="card-title" data-card-widget="collapse" data-toggle="tooltip" style="white-space: nowrap;font-size:14px; cursor:pointer;"><i class="fa fa-layer-group"></i> Map Layers </h3></center>
                      </div>
                      <div class="card-body" style="padding:10px;margin-bottom:-12px;">
                        <form role="form">
                          <div class="row">
                            <div class="col-sm-12">
                              <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                  <input class="custom-control-input" type="checkbox" id="PUI_MAP" checked onclick="showLayer($(this).prop('checked'),covidPUI);">
                                  <label for="PUI_MAP" class="custom-control-label" title="PERSON UNDER INVESTIGATION" style="color:#fd7e14;">PUI</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                  <input class="custom-control-input" type="checkbox" id="PUM_MAP" checked onclick="showLayer($(this).prop('checked'),covidPUM);">
                                  <label for="PUM_MAP" class="custom-control-label" title="PERSON UNDER MONITORING" style="color:#28a745;">PUM</label>
                                </div>
                              </div>
                            </div> 
                          </div>
                        </form>
                      </div>
                    </div>
                </li> -->
                <!-- <li class="nav-item">
                  <a href="<?= base_url() ?>login" class="nav-link">
                    <i class="nav-icon fas fa-sign-in-alt"></i>
                    <p>
                      Sign In
                    </p>
                  </a>
                </li> -->
              </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

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
            <div class="card card-primary card-outline card-outline-tabs bg-dark">
                <div class="card-header p-0 border-bottom-0">
                  <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="custom-tabs-three-chart5-tab" data-toggle="pill" href="#custom-tabs-three-chart5" role="tab" aria-controls="custom-tabs-three-chart1" aria-selected="true">CLOSE CONTACT</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-three-chart1-tab" data-toggle="pill" href="#custom-tabs-three-chart1" role="tab" aria-controls="custom-tabs-three-chart1" aria-selected="true">COVID 19 CASE</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-three-chart2-tab" data-toggle="pill" href="#custom-tabs-three-chart2" role="tab" aria-controls="custom-tabs-three-chart2" aria-selected="false">BARANGAY</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-three-chart3-tab" data-toggle="pill" href="#custom-tabs-three-chart3" role="tab" aria-controls="custom-tabs-three-chart3" aria-selected="false">GENDER</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-three-chart4-tab" data-toggle="pill" href="#custom-tabs-three-chart4" role="tab" aria-controls="custom-tabs-three-chart4" aria-selected="false">AGE</a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade active show" id="custom-tabs-three-chart5" role="tabpanel" aria-labelledby="custom-tabs-three-chart5-tab">
                      <div id="chart5" style="min-width: 100%; height: auto;margin:-15px;"></div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-three-chart1" role="tabpanel" aria-labelledby="custom-tabs-three-chart1-tab">
                      <div id="chart1" style="min-width: 100%; height: 400px;margin:-15px;"></div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-three-chart2" role="tabpanel" aria-labelledby="custom-tabs-three-chart2-tab">
                      <div id="chart2" style="min-width: 100%; height: 500px;margin:-15px;"></div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-three-chart3" role="tabpanel" aria-labelledby="custom-tabs-three-chart3-tab">
                      <div id="chart3" style="min-width: 100%; height: 600px;margin:-15px;"></div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-three-chart4" role="tabpanel" aria-labelledby="custom-tabs-three-chart4-tab">
                      <div id="chart4" style="min-width: 100%; height: 500px;margin:-15px;"></div>
                    </div>
                  </div>
                </div>
                <!-- /.card -->
            </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
      <!-- /.modal -->
<!-- /.modal -->

<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->

<!-- <script src="src/ol3/ol.js"></script> -->
<script src="<?= base_url() ?>assets/plugins/ol3/ol.js"></script>
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- DataTables -->
<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="<?= base_url() ?>assets/plugins/select2/js/select2.full.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url() ?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?= base_url() ?>assets/plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.form.min.js"></script>
<!-- Highcharts -->
<script src="<?= base_url() ?>assets/plugins/Highcharts-8.0.4/code/highcharts.js"></script>
<script src="<?= base_url() ?>assets/plugins/Highcharts-8.0.4/code/modules/sankey.js"></script>
<script src="<?= base_url() ?>assets/plugins/Highcharts-8.0.4/code/modules/organization.js"></script>
<script src="<?= base_url() ?>assets/plugins/Highcharts-8.0.4/code/modules/exporting.js"></script>
<script src="<?= base_url() ?>assets/plugins/Highcharts-8.0.4/code/modules/accessibility.js"></script>
<script src="<?= base_url() ?>assets/plugins/Highcharts-8.0.4/code/modules/export-data.js"></script>
<script src="<?= base_url() ?>assets/plugins/Highcharts-8.0.4/code/modules/drilldown.js"></script>
<!-- <script src="<?= base_url() ?>assets/plugins/Highcharts-8.0.4/code/themes/dark-unica.js"></script> -->
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.form.min.js"></script>
<?php $this->load->view('interface/system/layout/Charts')?>
<?php $this->load->view('interface/system/layout/Script')?>
</body>
</html>