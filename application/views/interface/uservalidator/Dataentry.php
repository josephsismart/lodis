<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Entry</h1>
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
      <div class="col-md-6">

        <?= form_open(base_url('uservalidator/Dataentry/savelocal'), 'id=form_save_local'); ?>
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Local Data
              <small>[ Visit <a href="https://ncovtracker.doh.gov.ph/" target="_blank">https://ncovtracker.doh.gov.ph/</a> for COVID 19 national data. ]</small>
              </h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body" style="overflow: auto;">
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                  </div>
                  <input type="date" value="<?= Date('Y-m-d') ?>" class="form-control" name="localDate">
                </div>
              </div>
              <!-- /.form-group -->
              <table id="tbl_entry" style="width:100%;" class="table table-hover table-striped table-bordered">
              <thead>
                <tr>
                  <th width="1"><a class="btn btn-xs btn-success" title="Add" onclick="addEntry()"><i class="fa fa-plus text-white"></i></a></th>
                  <th width="200">Barangay</th>
                  <th width="100">Status</th>
                  <th width="100">Gender</th>
                  <th width="70">Age</th>
                  <th width="70">Count</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot id="tbl_entry_foot" style="display:none;">
                <tr>
                  <th width="1"><a class="btn btn-xs btn-success" title="Add" onclick="addEntry()"><i class="fa fa-plus text-white"></i></a></th>
                  <th width="200">Barangay</th>
                  <th width="100">Status</th>
                  <th width="100">Gender</th>
                  <th width="70">Age</th>
                  <th width="70">Count</th>
                </tr>
              </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-info submitBtnLocal"><i class="fa fa-check"></i> Save Data</button>
            </div>
          </div>
          <!-- /.card -->
        </form>
      </div>


      <div class="col-md-6">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Local Data List
            </h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
            </div>
          </div>
          <!-- /.card-body -->

          <div class="card-body" style="overflow: auto;">
            <table id="tbl_local" style="width:100%;" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>Date</th>
                <th>Barangay</th>
                <th>Status</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Count</th>
                <th>Post</th>
              </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
            <!-- /.card-body -->
          <!-- <div class="card-footer">
            <button type="submit" class="btn btn-info submitBtnLocal"><i class="fa fa-check"></i> Save Data</button>
          </div> -->
        </div>
        <!-- /.card -->
      </div>
    </div>

  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->


<script type="text/javascript">
  var entryId=0;
  $(function(){
    addEntry();
    var tbl_local, tbl_local_data;
        tbl_local = $("#tbl_local").DataTable({
                            "order": [[0, "asc" ]],
                            "columnDefs": [ {
                              "orderable": false,
                            }],
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
                                url: "<?= base_url('uservalidator/Dataentry/getlocal') ?>",
                                type: "POST",
                                data:
                                function(d) {
                                  return tbl_local_data;
                                }
                            }
                        });
    $("#tbl_local_filter").addClass("row");
    $("#tbl_local_filter label").css("width","100%").css("padding-right","15px");
    $("#tbl_local_filter .form-control-sm").css("width","100%");

    var save_local = {
        clearForm: false,
        resetForm: false,
        beforeSubmit: function() {
            validate_form("form_save_local");
            $(".submitBtnLocal").attr("disabled", true);
            $(".submitBtnLocal").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
        },
        success: function(data) {
            var d = JSON.parse(data);
            if(d.success == true) {
                successAlert();
                clear_form("form_save_local");
                removeAllEntry();
            } else {
                failAlert();
            }
            $(".submitBtnLocal").attr("disabled", false);
            $(".submitBtnLocal").html("Save");
            $(".submitBtnLocal").html("<span class=\"fa fa-check\"></span> Save Data");
            $('#tbl_local').DataTable().ajax.reload();
        }
    };
    $("#form_save_local").ajaxForm(save_local);
  });

  function addEntry(){
        entryId=entryId+1;
        $('#tbl_entry tbody').append("<tr id='entry"+entryId+"'>"+
            "<td align='center'><a style='margin-top:5px;' class='btn btn-xs btn-danger' onclick='removeEntry(\""+entryId+"\")'><span class='fa fa-times text-white'></span></a></td>"+
            "<td><select type='text' class='form-control select2' name='dataBarangay[]' id='dataBarangay"+entryId+"'  style='width:100%;'>"+
                    "<option value=''></option>"+
                    "<?php foreach ($getBarangay['data1'] as $key => $value): ?>"+
                        "<option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>"+
                    "<?php endforeach ?>"+
                "</select></td>"+
            "<td><select type='text' class='form-control' name='dataStatus[]' id='dataStatus"+entryId+"'>"+
                    "<?php foreach ($getBarangay['data2'] as $key => $value): ?>"+
                        "<option value='<?= $value['id'] ?>'><?= $value['text'] ?></option>"+
                    "<?php endforeach ?>"+
                "</select></td>"+
            "<td><select name='dataGender[]' id='dataGender"+entryId+"' class='form-control' style='width:100%;'><option value='1'>MALE</option><option value='0'>FEMALE</option></select></td>"+
            "<td><input type='number' class='form-control' autocomplete='off' name='dataAge[]' style='width:100%;' min='0' id='dataAge"+entryId+"' value='0' placeholder='AGE'></td>"+
            "<td><input type='number' class='form-control' autocomplete='off' name='dataCount[]' style='width:100%;' min='1' id='dataCount"+entryId+"' value='1' placeholder='COUNT'></td>"+
        "</tr>");
        select();
        tfoot();
    }

    function select(){
        $('.select2').select2({
            placeholder: "SELECT BARANGAY"
        });
    }

    function removeEntry(b){
        if($('#tbl_entry tbody tr').length==1){
        }else{
            $('#tbl_entry tbody tr').each(function() {
            var id = this.id;
                if(id=="entry"+b){
                    "entry"+this.remove();
                    //sumMe();
                    tfoot();
                }
            });
        }
    }

    function removeAllEntry(){
        entryId=0;
        $('#tbl_entry tbody').empty();
        addEntry();
    }

    function tfoot(){
      if($('#tbl_entry tr').length>6){
        $('#tbl_entry_foot').show();
      }else{
        $('#tbl_entry_foot').hide();
      }
    }
</script>