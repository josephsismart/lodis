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
      <div class="col-12 form_save_dataInventoryItem">
        <div class="row">

          <div class="col-12 tblInventoryItem">
            <?= form_open(base_url($uri.'/Dataentry/saveInventoryItem'), 'id=form_save_dataInventoryItem'); ?>
              <input type="" name="inventId" hidden>
              <div class="card card-lightblue">
                <div class="card-header">
                  <h3 class="card-title"><i class="fa fa-cubes"></i> Inventory List</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button> -->
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-2" style="overflow: auto;">
                  <div class="row">
                    <div class="col-lg-5 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Member</label>
                        <select class="form-control selectMemberUserList" type="select" name="personId" style="width:100%"></select>
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Variety</label>
                        <select class="form-control selectVarietyCategoryList" type="select" name="varietyId" style="width:100%"></select>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Transaction Date</label>
                          <input type="date" value="<?= Date('Y-m-d') ?>" class="form-control" name="transactDate">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-info submitBtnPrimary">Save Data</button>
                  <button type="button" class="btn btn-default float-right" onclick="clear_form('form_save_dataInventoryItem')"><i class="fa fa-times"></i> Cancel</button>
                </div>
              </div>
              <!-- /.card -->
            </form>
          </div>

          <!-- add item -->
          <div class="col-12 tblInventoryAddItem" style='display:none;'>
            <?= form_open(base_url($uri.'/Dataentry/saveInventoryItemList'), 'id=form_save_dataInventoryItemList'); ?>
              <input type="" name="inventoryId" hidden>
              <div class="card card-pink">
                <div class="card-header">
                  <h3 class="card-title"><i class="fa fa-cube"></i> Add Inventory Item</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" id="btnInventoryItemAdd" onclick="slide('form_save_dataInventoryItem','tblInventoryAddItem','tblInventoryItem')">Back to list</button>
                    <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button> -->
                  </div>
                </div>
                <div class="card-body p-2" style="overflow: auto;">
                  
                  <div class="row">
                    <div class="col-sm-4 invoice-col">
                        <b>Member:</b><p class="fullName">-</p>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <b>Variety:</b><p class="variety">-</p>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <b>Transaction Date:</b><p class="transDate">-</p>
                    </div>
                  </div>
                    
                  <div class="table-responsive mailbox-messages">
                    <table id="tblInventoryItemAdd" style="width:100%;" class="table table-bordered table-hover table-data-checkbox">
                      <thead>
                      <tr>
                        <th width="1">
                          <span style='cursor:pointer' title='Add Inventory Items' class='badge badge bg-success' onclick='addItem()'><i class='fa fa-plus'></i></span>
                        </th>
                        <th width="50%"><i class='fa fa-balance-scale'></i> Weight</th>
                        <th width="50%"><i class='fa fa-shopping-bag'></i> Sack</th>
                      </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn bg-pink submitBtnPrimary">Save Data</button>
                  <button type="button" class="btn btn-default float-right"  onclick="slide('form_save_dataInventoryItem','tblInventoryAddItem','tblInventoryItem');"><i class="fa fa-times"></i> Back to list</button>
                </div>
              </div>
            </form>
          </div>

          <!-- list inventory -->
          <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <div class="card card-lightblue">
              <div class="card-header">
                <h3 class="card-title"><i class="fa fa-list"></i> Inventory & Purchase Order List</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button> -->
                </div>
              </div>
              <div class="card-body p-2" style="overflow: auto;">
                <div class="table-responsive mailbox-messages">
                  <form>
                    <table id="tblInventoryItem" style="width:100%;" class="table table-bordered table-hover table-data-checkbox">
                      <thead>
                      <tr>
                        <th width="1">#</th>
                        <th><i class='fa fa-cube'></i> Inventory details</th>
                        <th><i class='fa fa-shopping-cart'></i> Purchase Order</th>
                      </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- list inventory -->
          <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <div class="card card-navy">
              <div class="card-header">
                <h3 class="card-title"><i class="fa fa-list"></i> Stocks & Purchase Requests List</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button> -->
                </div>
              </div>
              <div class="card-body p-2" style="overflow: auto;">
                <div class="table-responsive mailbox-messages">
                  <form>
                    <table id="tblStockPurchaseRequest" style="width:100%;" class="table table-bordered table-hover table-data-checkbox">
                      <thead>
                      <tr>
                        <th width="1">#</th>
                        <th><i class='fa fa-cubes'></i> Stocks detail</th>
                        <th><i class='fa fa-store-alt'></i> Purchase Request</th>
                      </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </form>
                </div>
              </div>
            </div>
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
  $(function(){
    getTable("InventoryItem");
    getTable("StockPurchaseRequest");


    saveForm("InventoryItem",["InventoryItem"],null);
    saveForm("InventoryItemList",["InventoryItem"],"InventoryItemAdd");
    saveForm("PurchaseOrder",["InventoryItem"],null);
    saveForm("Stock",["InventoryItem","StockPurchaseRequest"],null);
    saveForm("PurchaseRequest",["StockPurchaseRequest"],null);
    // form_save_dataPurchaseOrder

    getFetchList("form_save_dataInventoryItem","VarietyCategoryList",null,{v:1});
    getFetchList("form_save_dataInventoryItem","MemberUserList",null,{v:2});
    getFetchList("form_save_dataPurchaseRequest","VarietyCategoryList",null,{v:2});
    getFetchList("form_save_dataPurchaseRequest","VarietySubCategoryList","VarietyCategoryList",{v:3});
    getFetchList("form_save_dataPurchaseRequest","MemberUserList",null,{v:2});

    addItem();
  });

  function createInvent(a){
    getDetails("InventoryItemList",a,null);
    slide("form_save_dataInventoryItem","tblInventoryItem","tblInventoryAddItem");
  }

  function addItem(){
    addItemList("tblInventoryItemAdd","invent",
                "<td><input type='number' class='form-control' name='weight[]' placeholder='WEIGHT' min='1'></td>"+
                "<td><input type='number' class='form-control' name='sack[]' placeholder='SACK' min='1'></td>");
  }
</script>