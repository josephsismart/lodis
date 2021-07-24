<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.form.min.js"></script>
<?php 
    if (!$this->session->schoolmis_login_level) {
        redirect(base_url('login'));
    }
    $uri = $this->session->schoolmis_login_uri;
 ?>
<!-- <div class="modal fade show" id="modal-default" aria-modal="true" style="padding-right: 16px; display: block;"> -->
<div class="modal fade" id="modalPurchaseOrder">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#6f42c1;color:#fff;">
                <h4 class="modal-title">Purchase Order entry form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open(base_url($uri.'/Dataentry/savePurchaseOrder'), 'id=form_save_dataPurchaseOrder'); ?>
                <div class="modal-body">
                    <input name="poId" hidden/>
                    <input name="inventoryId" hidden/>
                    <div class="card-body p-2" style="overflow: auto;">
                        <div class="row">
                            <div class="col-12">
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
                                <div class="row">
                                    <div class="col-sm-4 invoice-col">
                                        <b>Total Items:</b><p class="totalCount">-</p>
                                    </div>
                                    <div class="col-sm-4 invoice-col">
                                        <b>Total Weight:</b><p class="totalWeight">-</p>
                                    </div>
                                    <div class="col-sm-4 invoice-col">
                                        <b>Total Sacks:</b><p class="totalSacks">-</p>
                                    </div>
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table">
                                    <tr>
                                        <th style="width:50%">Purchase Date:</th>
                                        
                                        <td><input class="form-control form-control-sm" type="date" name="purchaseDate" value="<?= Date('Y-m-d') ?>"></td>
                                    </tr>
                                    <tr>
                                        <th>Total Deduction:</th>
                                        <td><input class="form-control form-control-sm" type="number" name="totalDeduct" placeholder="Total Deduction"/></td>
                                    </tr>
                                    <tr>
                                        <th>Total Kilo:</th>
                                        <td><input class="form-control form-control-sm" type="number" name="totalKilo" placeholder="Total Kilo"/></td>
                                    </tr>
                                    <tr>
                                        <th>Price:</th>
                                        <td><input class="form-control form-control-sm" type="number" name="price" placeholder="Price"/></td>
                                    </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-info submitBtnPrimary">Save Data</button>
                    <button type="button" class="btn btn-default" onclick="clear_form('form_save_dataPurchaseOrder')" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <!-- <button type="button" class="btn btn-default float-right" ><i class="fa fa-times"></i> Cancel</button> -->
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!-- <div class="modal fade show" id="modal-default" aria-modal="true" style="padding-right: 16px; display: block;"> -->
<div class="modal fade" id="modalStock">
    <div class="modal-dialog">
        <div class="modal-content">
            <?= form_open(base_url($uri.'/Dataentry/saveStock'), 'id=form_save_dataStock'); ?>
                <div class="modal-header" style="background-color:#ffc107;">
                    <h4 class="modal-title">Stock entry form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input name="poId" hidden/>
                    <input name="stockId" hidden/>
                    <div class="card-body p-2" style="overflow: auto;">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <label>PO Code: </label> <span class='badge bg-purple mb-2' title='Purchase Order Code'><lable class="purchaseOrderCode"></label></span>
                                    </div>
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
                                <div class="row">
                                    <div class="col-sm-4 invoice-col">
                                        <b>Total Items:</b><p class="totalCount">-</p>
                                    </div>
                                    <div class="col-sm-4 invoice-col">
                                        <b>Total Weight:</b><p class="totalWeight">-</p>
                                    </div>
                                    <div class="col-sm-4 invoice-col">
                                        <b>Total Sacks:</b><p class="totalSacks">-</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3 invoice-col">
                                        <b>Purchase Date:</b><p class="purchaseDate">-</p>
                                    </div>
                                    <div class="col-sm-3 invoice-col">
                                        <b>Total Deduction:</b><p class="totalDeduct">-</p>
                                    </div>
                                    <div class="col-sm-3 invoice-col">
                                        <b>Total Kilo:</b><p class="totalKilo">-</p>
                                    </div>
                                    <div class="col-sm-3 invoice-col">
                                        <b>Price:</b><p class="price">-</p>
                                    </div>
                                    <div class="col-12">
                                        <label>StockCode: </label> <span class='badge bg-yellow mb-2' title='Stock Code'><lable class="stockCode"></label></span>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                    <tr>
                                        <th style="width:50%">Stock Date:</th>
                                        
                                        <td><input class="form-control form-control-sm" type="date" name="stockDate" value="<?= Date('Y-m-d') ?>"></td>
                                    </tr>
                                    <tr>
                                        <th>Number of Sacks:</th>
                                        <td><input class="form-control form-control-sm" type="number" name="noOfSacks" placeholder="Total Deduction"/></td>
                                    </tr>
                                    <tr>
                                        <th>Total Kilo:</th>
                                        <td><input class="form-control form-control-sm" type="number" name="noOfKilo" placeholder="Total Kilo"/></td>
                                    </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-info submitBtnPrimary">Save Data</button>
                    <button type="button" class="btn btn-default" onclick="clear_form('form_save_dataStock')" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <!-- <button type="button" class="btn btn-default float-right" ><i class="fa fa-times"></i> Cancel</button> -->
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!-- <div class="modal fade show" id="modal-default" aria-modal="true" style="padding-right: 16px; display: block;"> -->
<div class="modal fade" id="modalPurchaseRequest">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <?= form_open(base_url($uri.'/Dataentry/savePurchaseRequest'), 'id=form_save_dataPurchaseRequest'); ?>
                <div class="modal-header" style="background-color:#20c997;">
                    <h4 class="modal-title">Purchase Request entry form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <input name="prId" hidden/>
                    <input name="stockId" hidden/>
                    <div class="card-body p-2" style="overflow: auto;">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-header p-2">
                                        <h5 class="card-title">
                                            <label>PO Code: </label> <span class='badge bg-purple mb-2' title='Purchase Order Code'><lable class="purchaseOrderCode"></label></span>
                                        </h5>
                                    </div>
                                    <div class="card-body p-1">
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
                                        <div class="row">
                                            <div class="col-sm-4 invoice-col">
                                                <b>Total Items:</b><p class="totalCount">-</p>
                                            </div>
                                            <div class="col-sm-4 invoice-col">
                                                <b>Total Weight:</b><p class="totalWeight">-</p>
                                            </div>
                                            <div class="col-sm-4 invoice-col">
                                                <b>Total Sacks:</b><p class="totalSacks">-</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3 invoice-col">
                                                <b>Purchase Date:</b><p class="purchaseDate">-</p>
                                            </div>
                                            <div class="col-sm-3 invoice-col">
                                                <b>Total Deduction:</b><p class="totalDeduct">-</p>
                                            </div>
                                            <div class="col-sm-3 invoice-col">
                                                <b>Total Kilo:</b><p class="totalKilo">-</p>
                                            </div>
                                            <div class="col-sm-3 invoice-col">
                                                <b>Price:</b><p class="price">-</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <div class="card">
                                    <div class="card-header p-2">
                                        <h5 class="card-title">
                                            <label>Stock Code: </label> <span class='badge bg-yellow mb-2' title='Stock Code'><lable class="stockCode"></label></span>
                                        </h5>
                                    </div>
                                    <div class="card-body p-1">
                                        <div class="row">
                                            <div class="col-sm-4 invoice-col">
                                                <b>Stock Date:</b><p class="stockDate">-</p>
                                            </div>
                                            <div class="col-sm-4 invoice-col">
                                                <b>Number of Sacks:</b><p class="noOfSacks">-</p>
                                            </div>
                                            <div class="col-sm-4 invoice-col">
                                                <b>Total Kilo:</b><p class="noOfKilo">-</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="card card-teal">
                                    <div class="card-header p-2">
                                        <h5 class="card-title">
                                            Purchase Request details
                                            <!-- <label>PR Code: </label> <span class='badge bg-teal mb-2' title='Stock Code'><lable class="prCode"></label></span> -->
                                        </h5>
                                    </div>
                                    <div class="card-body p-1">
                                        <div class="table-responsive">
                                            <table class="table">
                                            <tr>
                                                <th style="width:50%">Purchase Date:</th>
                                                <td><input class="form-control form-control-sm" type="date" name="purchaseDate" value="<?= Date('Y-m-d') ?>"></td>
                                            </tr>
                                            <tr>
                                                <th>Sold To:</th>
                                                <td><select class="form-control selectMemberUserList" type="select" name="soldToPerson" style="width:100%"></select></td>
                                            </tr>
                                            <tr>
                                                <th>Classification:</th>
                                                <td><select class="form-control selectVarietyCategoryList" type="select" name="classification" style="width:100%"></select></td>
                                            </tr>
                                            <tr>
                                                <th>Subclassification:</th>
                                                <td><select class="form-control selectVarietySubCategoryList" type="select" name="subclass" style="width:100%"></select></td>
                                            </tr>
                                            <tr>
                                                <th>Number of Kilos:</th>
                                                <td><input class="form-control form-control-sm" type="number" name="numKilos" placeholder="Number of Kilos"/></td>
                                            </tr>
                                            <tr>
                                                <th>Price:</th>
                                                <td><input class="form-control form-control-sm" type="number" name="prPrice" placeholder="Price"/></td>
                                            </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-info submitBtnPrimary">Save Data</button>
                    <button type="button" class="btn btn-default" onclick="clear_form('form_save_dataPurchaseRequest')" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <!-- <button type="button" class="btn btn-default float-right" ><i class="fa fa-times"></i> Cancel</button> -->
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->