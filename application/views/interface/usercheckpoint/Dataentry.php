<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.form.min.js"></script>
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
        <h1><i class="nav-icon fas fa-qrcode"></i> QR Code Scanner</h1>
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
      <div class="col-12 form_save_dataScanQR">
        <div class="row">
          <div class="col-12">
            <form id="form_save_dataScanQR">
              <input type="" id="qr" hidden>
              <div class="card card-navy">
                <div class="card-header">
                  <h3 class="card-title"><i class="fa fa-qrcode"></i> QR Code Scanner</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-xs btn-info openreader-multi3" id="openreader-multi3" 
                      data-qrr-multiple="false" 
                      data-qrr-target="#multiple" 
                      data-qrr-skip-duplicates="false"
                      onclick="$('.openreader-multi3').hide();$('.qrr-close').show();"
                      style="display:none;">
                      <i class="fa fa-qrcode"></i> Read QR Code
                    </button>
                    <button 
                      type="button" 
                      class="btn btn-xs btn-default qrr-close" 
                      onclick="$('#qrr-close').trigger('click');$('.openreader-multi3').show();$('.qrr-close').hide();">
                      <i class="fa fa-times"></i> Close QR Code Reader
                    </button>
                    <button 
                      type="button" 
                      class="btn btn-tool" 
                      data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button> -->
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-2" style="overflow: auto;">
                  <div class="row">
                    <!-- <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">
                            <i class="fas fa-image"></i>
                            Image
                          </h3>
                        </div>
                        <div class="card-body">
                          <div class="position-relative text-center">
                            <img src="../assets/dist/img/icons/icon.png" alt="Photo 1" width="200" class="img-fluid">
                          </div>
                        </div>
                      </div>
                    </div> -->
                    <!-- ./col -->
                    <!-- <div class="col-lg-10 col-md-8 col-sm-8 col-xs-12"> -->
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">
                            <i class="fas fa-user"></i>
                            Peron Details
                          </h3>

                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button> -->
                          </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body text-center">
                          <dl>
                            <div class="position-relative text-center">
                              <img src="../assets/dist/img/icons/icon.png" alt="Photo 1" width="150" class="img-fluid">
                            </div>
                            <dt style="font-size: 5.1rem;" id="name">-</dt>
                            <dd style="font-size: 4rem;" id="type">-</dd>
                          </dl>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                    </div>
                    <!-- ./col -->
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </form>
          </div>
          
        </div>
      </div>

      <div class="col-12 form_save_dataScannedQR">
        <div class="row">
          <div class="col-12">
            <div class="card card-navy">
              <div class="card-header">
                <h3 class="card-title"><i class="fa fa-list"></i> List of Scanned QR Code as of <b><?= date("l jS \of F Y");/*date("l jS \of F Y h:i:s A")*/ ?></b></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button> -->
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-2" style="overflow: auto;">
                <div class="table-responsive mailbox-messages">
                  <form>
                    <table id="tblScannedQR" style="width:100%;" class="table table-bordered table-hover table-data-checkbox">
                      <thead>
                      <tr>
                        <th width="1">#</th>
                        <th width="80"><i class='fa fa-angle-double-down'></i> Type</th>
                        <th width="100"><i class='fa fa-clock'></i> Time</th>
                        <th><i class='fa fa-user'></i> Person Details</th>
                      </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </form>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>

      <div class="col-md-6">
          <div class="table-responsive">
          </div>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<script type="text/javascript">
  $("document").ready(function() {
      setTimeout(function() {
        $("#openreader-multi3").trigger("click");
      },1000);
  });

  setInterval(() => {
    !$("#qr").val()?
    console.log(10)
    :getQRPerson({v:$("#qr").val()},"ScanQR");
  }, 1000)

  $(function(){

    // getTable("ScanQR");
    getTable("ScannedQR");

    // saveForm("ScanQR",["ScanQR"],null);
    // saveForm("ScannedQR",["ScannedQR"],null);
  });
</script>