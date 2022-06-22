<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="<?= base_url() ?>plugins/jquery/jquery.form.min.js"></script>
<?php 
    if (!$this->session->schoolmis_login_level) {
        redirect(base_url('login'));
    }
    $uri = $this->session->schoolmis_login_uri;
 ?>
<style>
    @media (min-width: 992px) {
        .modal-xxl {
            max-width: 90%;
        }
    }
</style>

<!-- <div class="modal fade show" id="modal-default" aria-modal="true" style="padding-right: 16px; display: block;"> -->
<div class="modal fade" id="modalReportConsoGrades" data-backdrop="static">
    <div class="modal-dialog modal-xxl">
        <div class="modal-content">
            <div class="modal-header no-print">
                <h4 class="modal-title">Consolidated Grades <?= $getOnLoad["sy"]; ?></h4>
                <div  class='radioBtn btn-group pull-right'>
                    <button type="submit" onclick="printForm('ConsoGrades','l','Legal','Inventory details & Purchase Order');" class="btn btn-info submitBtnPrimary btn-xs content"><i class="fa fa-print"></i> Print</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="modal-body p-0 content" id="printConsoGrades">
                <div class="table-responsive col-md-12 text-center">
                    <table width="100%" border="1" id="tblReportConsoGrades">
                        <!-- <thead>
                            <tr style="text-align:center;border:1px solid white;">
                                <td colspan="13"><?php $this->load->view('interface/'.$uri.'/layout/Report_header')?></td>
                            </tr>
                            <tr style="text-align:center;border:1px solid white;border-bottom: 1px solid gray;">
                                <td colspan="13"><br/><h5 id="headerReportConsoGrades"></h5></td>
                            </tr>
                            <tr align="center">
                                <th>#</th>
                                <th>INV Code</th>
                                <th>Date</th>
                            </tr>
                        </thead> -->
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer justify-content-between content">
                <button type="submit" onclick="printForm('ConsoGrades','l','Legal','Inventory details & Purchase Order');" class="btn btn-info submitBtnPrimary"><i class="fa fa-print"></i> Print</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
            <div class="overlay">
                <i class="fas fa-spin text-white fa-3x fa-circle-notch"></i>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>