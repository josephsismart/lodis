<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>User Logs</h1>
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
    <!-- SELECT2 EXAMPLE -->

    <div class="row">
      <div class="col-md-12">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Personnel Activity List
            </h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>
          <!-- /.card-body -->

          <div class="card-body" style="overflow: auto;margin-right: 20px;white-space:nowrap;">
            <table id="tbl_person_user_logs" style="width:100%;" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th width="1">#</th>
                <th width="1">Date & Time</th>
                <th width="1">User</th>
                <th>Action</th>
                <th width="1">IP Address</th>
              </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>

  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->


<script type="text/javascript">
  $(function(){
    var tbl_person_user_logs, tbl_personCovid19_data;
        tbl_person_user_logs = $("#tbl_person_user_logs").DataTable({
                            "oLanguage": { "sSearch": "" },
                            language: {
                                searchPlaceholder: "Search...",
                            },
                            "paging": true,
                            "pageLength": 10,
                            "lengthChange": false,
                            "searching": true,
                            "ordering": true,
                            "info": true,
                            "autoWidth": false,
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                            ajax: {
                                url: "<?= base_url('useradmin/Userlogs/getPersonLogs') ?>",
                                type: "POST",
                                data:
                                function(d) {
                                  return tbl_personCovid19_data;
                                }
                            }
                        });
    $("#tbl_person_user_account_filter").addClass("row");
    $("#tbl_person_user_account_filter label").css("width","100%").css("padding-right","15px");
    $("#tbl_person_user_account_filter .form-control-sm").css("width","100%");
  });
</script>