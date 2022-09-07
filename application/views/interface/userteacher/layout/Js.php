<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
if (!$this->session->schoolmis_login_level) {
    redirect(base_url('login'));
}
$uri = $this->session->schoolmis_login_uri;
?>
<!-- Bootstrap 4 -->

<script src="<?= base_url() ?>plugins/ol3/ol.js"></script>
<script src="<?= base_url() ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="<?= base_url() ?>plugins/select2/js/select2.full.min.js"></script>
<!-- DataTables -->
<script src="<?= base_url() ?>plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="<?= base_url() ?>plugins/datatables/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>plugins/datatables/extensions/buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>plugins/datatables/extensions/buttons/js/jszip.min.js"></script>
<script src="<?= base_url() ?>plugins/datatables/extensions/buttons/js/buttons.flash.min.js"></script>
<script src="<?= base_url() ?>plugins/datatables/extensions/buttons/js/buttons.html5.min.js"></script>
<!-- <script src="<?= base_url() ?>plugins/datatables/extensions/buttons/js/pdfmake.min.js"></script> -->
<!-- <script src="<?= base_url() ?>plugins/inputmask/jquery.inputmask.min.js"></script> -->
<script src="<?= base_url() ?>plugins/datatables/extensions/buttons/js/vfs_fonts.js"></script>
<script src="<?= base_url() ?>plugins/datatables/extensions/responsive/js/dataTables.responsive.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url() ?>plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?= base_url() ?>plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>dist/js/adminlte.min.js"></script>
<!-- ExportExcel -->
<script src="<?= base_url() ?>plugins/tablexcel/src/jquery.table2excel.js"></script>
<!-- ImportExcel -->
<script src="<?= base_url() ?>plugins/jquery/xlsx.full.min.js"></script>
<script src="<?= base_url() ?>plugins/jquery/jszip.js"></script>

<!-- <script src="<?= base_url() ?>plugins/tablexport/FileSaver.min.js"></script>
<script src="<?= base_url() ?>plugins/tablexport/Blob.min.js"></script>
<script src="<?= base_url() ?>plugins/tablexport/xls.core.min.js"></script>
<script src="<?= base_url() ?>plugins/tablexport/tableexport.js"></script> -->

<script type="text/javascript">
    setInterval(function() {
        $.post("<?= base_url('Main/allow') ?>");
    }, 3000)
    var confirmP = "";
    var rmvP = "";
    var refrmvP = "";
    var stq = "";
    var pwd = "";
    var entryId = 0;
    var addItemId = 0;
    var validatorC = 0;
    var valid = 0;
    var grdlvl = 0;
    var rmid = 0;
    var rsid = 0;
    var sec_name = "";
    var rssaid = 0;
    var logsHS = 0;
    var adviser = 0;
    var bTmp = 0;
    var cTmp = 0;
    var filename = "";

    var vars = {};
    $(function() {
        $('.select2').select2()
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
    });

    function check_all(a) {
        if ($("#" + a).prop('checked') == true) {
            $("#tblLearnersList").find("input[type='checkbox']").each(function() {
                $("." + a).prop("checked", true);
            });
        } else {
            $("#tblLearnersList").find("input[type='checkbox']").each(function() {
                $("." + a).prop("checked", false);
            });
        }
    }

    function clear_form1() {
        clear_form("form_save_dataEnrollmentInfo");
        $("#form_save_dataEnrollmentInfo #ersid").val(rsid)
    }

    function clear_form(form_id) {
        $("#" + form_id)[0].reset();
        $("#" + form_id).find("input[type='hidden']").each(function() {
            $(this).val("");
        });
        $("#" + form_id).find("input[type='checkbox']").each(function() {
            $(this).attr("checked", false);
        });
        $("#" + form_id).find("select").each(function() {
            $(this).trigger("change");
        });

        $("#" + form_id + " .submitBtnPrimary").attr("disabled", false);
        $("#" + form_id + " .submitBtnPrimary").html("Save Data");
    }

    function getDetails(a, b, c, d) {
        $.each(b, function(k, v) {
            $(d + "form_save_data" + a).each(function() {
                $("[name='" + k + "']").val(v);
                $("[class='" + k + "']").html(v);
                $("[name='" + k + "']").trigger("change");
            });
        });
    }

    function unenroll() {
        validate("form_save_dataUnenrollConfirm");
        if (valid != 0) {
            fillIn();
            return false;
        }
        // a = $("#form_save_dataUnenrollConfirm .submitBtnPrimary").text();
        // $("#form_save_dataUnenrollConfirm .submitBtnPrimary").attr("disabled", true);
        // $("#form_save_dataUnenrollConfirm .submitBtnPrimary").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
        s = $("#form_save_dataUnenrollConfirm").serialize();
        $.post("<?= base_url($uri . '/Dataentry/learnerUnenroll') ?>", s,
            function(data) {
                var result = JSON.parse(data);
                if (result.success == true) {
                    successAlert(result.message);
                    // getTable("LearnersList", 0, -1);
                    $("#modalLearnersUnenroll").modal('hide');
                    // getTable("LearnersList", 0, -1);
                    getTable("AssignedSectionList", 0, -1);
                    // setTimeout(function() {
                    //     $(".form_save_dataSectionList #slctRmRadio" + rsid + rssaid).attr("checked", true).trigger("click");
                    // }, 1500);
                } else if (result.success == false) {
                    failAlert(result.message);
                    // getTable("LearnersList", 0, -1);
                }
            }
        ).then(function() {
            // s2 == 1 ? $("#form_save_data" + formId + " .select" + getList).select2() : "";
        });
    }

    function validate(form_id) {
        let invalid = 0;
        $($("#" + form_id).find("select").get().reverse()).each(function() {
            var name = $(this).attr("name");
            var j = clean($(this).attr("name"));
            var nr = $(this).attr("nr");
            var multiple = $(this).attr("multiple");

            if (nr != 1) {
                if (!$(this).val() || $(this).val() == 'null') {
                    $(this).focus().addClass("is-invalid");
                    $("#" + form_id + " select[name='" + name + "']").focus().next().find('.select2-selection').addClass('has-error');
                    $("#" + form_id + " ." + j).addClass('border-danger');
                    invalid++;
                } else {
                    $(this).removeClass("is-invalid");
                    $("#" + form_id + " select[name='" + name + "']").focus().next().find('.select2-selection').removeClass('has-error');
                    $("#" + form_id + " ." + j).removeClass('border-danger');
                }
            }
        });

        $($("#" + form_id).find("input").get().reverse()).each(function() {
            if ($("#" + form_id + ' input[type="search"]')) {
                // return 0;
            }
            if ($("#" + form_id + ' input[type="text"]')) {
                var name = clean($(this).attr("name"));
                var nr = $(this).attr("nr");

                if (name == null) {} else if (nr != 1) {
                    if (!$(this).val()) {
                        $(this).focus().addClass("is-invalid");
                        $("#" + form_id + " ." + name).addClass('border-danger');
                        invalid++;
                    } else {
                        $(this).removeClass("is-invalid");
                        $("#" + form_id + " ." + name).removeClass('border-danger');
                    }
                }
            }
        });
        valid = invalid;
    }

    function reportForm(formId) {
        $("#form_report_data" + formId + " .submitBtnPrimary").attr("disabled", true);
        $("#form_report_data" + formId + " .submitBtnPrimary").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
        var table, table_data = $("#tblReport" + formId).DataTable({
            "iDisplayLength": -1,
            ajax: {
                url: "<?= base_url($uri . '/report/report') ?>" + formId,
                icon: "POST",
                data: function(d) {
                    d.a = $("#form_report_data" + formId).serialize();
                    return table_data;
                }
            },
            "initComplete": function(settings, json) {
                json.data.length == 0 ? failAlert("No Data found!") : $("#modalReport" + formId).modal("show");
                $("#tblReport" + formId).DataTable().destroy();
                $("#form_report_data" + formId + " .submitBtnPrimary").attr("disabled", false);
                $("#form_report_data" + formId + " .submitBtnPrimary").html("Go!");
                if (formId == "InvPO") {
                    $("#headerReport" + formId).text("Inventory & Purchase Order as of " + $("[name='filterInvPOfromDate'").val() + " - " + $("[name='filterInvPOtoDate'").val());
                }
                if (formId == "StckPR") {
                    $("#headerReport" + formId).text("Stocks & Purchase Request as of " + $("[name='filterStckPRfromDate'").val() + " - " + $("[name='filterStckPRtoDate'").val());
                }
            }
        });
    }

    function saveForm(formId, tblId, tbl, dtd, pl) {
        var saveData = {
            clearForm: false,
            resetForm: false,
            beforeSubmit: function(e) {
                validate("form_save_data" + formId);
                if (valid != 0) {
                    fillIn();
                    return false;
                }
                // $("#modal" + formId + " .tab-content").hide();
                // $("#modal" + formId + " .overlay").show();
                a = $("#form_save_data" + formId + " .submitBtnPrimary").text();
                // if (formId != "GradesList") {
                //     $("#form_save_data" + formId + " .submitBtnPrimary").attr("disabled", true);
                //     $("#form_save_data" + formId + " .submitBtnPrimary").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
                // }
            },
            success: function(data) {
                var d = JSON.parse(data);
                if (d.success == true) {
                    successAlert("Successfully Saved!");
                    if ((formId == "GradesList") || (formId == "GradesPSList")) {} else {
                        $("#modal" + formId).modal('hide');
                        clear_form("form_save_data" + formId);
                    }

                    if (formId == "GradesList") {
                        getGradesListFN();
                    }

                    if (formId == "GradesPSList") {
                        getGradesPSListFN();
                    }

                    if (tblId.length > 1) {
                        for (var i = 0; i < tblId.length; i++) {
                            getTable(tblId[i], dtd, pl);
                        }
                    }
                    tbl ? removeAllItemList("tbl" + tbl) : null;
                    tbl ? $("#btn" + tbl).trigger("click") : null;

                    // if (formId == 'EnrollmentInfo') {
                    //     $('#modalEnrollment').modal('hide');
                    // }
                } else if (d.exist == true) {
                    existAlert("Person already exist!<br/>You can search and add TEST RESULT");
                } else if (d.existCode == true) {
                    existAlert("Code already taken!<br/>by: " + d.existPerson);
                } else if (d.message) {
                    failAlert(d.message);
                } else {
                    failAlert("Something went wrong!");
                }
                // $("#modal" + formId + " .overlay").hide();
                $("#modal" + formId + " .tab-content").show();
                $("#form_save_data" + formId + " .submitBtnPrimary").attr("disabled", false);
                $("#form_save_data" + formId + " .submitBtnPrimary").html(a);
                // getTable("LearnersList", 0, -1);
                getTable("AssignedSectionList", 0, -1);
                // setTimeout(function() {
                // $(".form_save_dataSectionList #slctRmRadio" + rsid + rssaid).attr("checked", true).trigger("click");
                // }, 1500);

            }
        };
        $("#form_save_data" + formId).ajaxForm(saveData);
    }

    function getTable(tableId, dtd, pl, search) {
        $("#modal" + tableId + " .content").hide();
        $("#modal" + tableId + " .overlay").show();
        setTimeout(() => {
            $("#tbl" + tableId).DataTable().destroy();
            var table, table_data = $("#tbl" + tableId).DataTable({
                // "order": [
                //     [0, "asc"]
                // ],
                dom: 'Bfrtip',
                buttons: tableId == 'SearchEnrollLearnersList' ? [{
                        text: "<i class='fa fa-check text-success'></i> Enroll",
                        action: function(e, dt, node, config) {
                            validateTable(tableId);
                        }
                    }] : [] &&
                    tableId == 'LearnersList' ? [{
                        text: "<i class='fa fa-cog'></i> Account",
                        action: function(e, dt, node, config) {
                            validateTable(tableId);
                        }
                    }, {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> Print',
                        header: "_excel"

                    }] : [] &&
                    tableId == 'AllStudentLogs' ? [{
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> Print',
                        header: "_excel"

                    }, {
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel"></i> Export Excel',
                        header: "_excel"

                    }] : [],

                searching: ((tableId == "GradesList" || tableId == "GradesPSList") ? false : true),
                // scrollX: true,
                // scrollY: "500px",
                // scrollY: tableId == 'GradesList' ? "500px" : null,
                // scrollCollapse: true,
                "search": {
                    "search": search ?? "",
                },
                "info": pl == -1 ? false : true,
                "paging": pl == -1 ? false : true,
                "ordering": pl == -1 ? false : true,
                "oLanguage": {
                    "sSearch": ""
                },
                language: {
                    searchPlaceholder: "Search...",
                },
                pageLength: pl,
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],

                ajax: {
                    url: "<?= base_url($uri . '/getdata/get') ?>" + tableId,
                    type: "POST",
                    cache: true,
                    data: function(d) {
                        d.rsid = rsid;
                        d.rssaid = rssaid;
                        d.by = $("#searchby").val();
                        d.key = $("#keyword").val();
                    }
                },

                fnInitComplete: function(oSettings, json) {
                    if (tableId == "Honors") {
                        $('[data-toggle="tooltip"]').tooltip();
                    }
                    if (tableId == "AssignedSectionList") {
                        if (rssaid != 0) {
                            $(".form_save_dataSectionList #slctRmRadio" + rsid + rssaid).attr("checked", true).trigger("click");
                        } else {
                            $(".form_save_dataSectionList .slctdRadioAdvisory").attr("checked", true).trigger("click");
                        }
                    }

                    if (tableId == "GradesList") {
                        $("#modal" + tableId + " .q1c").empty();
                        $("#modal" + tableId + " .q2c").empty();
                        $("#modal" + tableId + " .q3c").empty();
                        $("#modal" + tableId + " .q4c").empty();
                        if (json && json["details"]) {
                            if (json["details"]["q1c"]) {
                                $("#modal" + tableId + " .q1c").html(json["details"]["q1c"])
                            }
                            if (json["details"]["q2c"]) {
                                $("#modal" + tableId + " .q2c").html(json["details"]["q2c"])
                            }
                            if (json["details"]["q3c"]) {
                                $("#modal" + tableId + " .q3c").html(json["details"]["q3c"])
                            }
                            if (json["details"]["q4c"]) {
                                $("#modal" + tableId + " .q4c").html(json["details"]["q4c"])
                            }
                        }
                        $('[data-toggle="tooltip"]').tooltip()
                    }

                    if (tableId == "GradesPSList") {
                        $('[data-toggle="tooltip"]').tooltip()
                    }

                    if (tableId == "GradesSMEAList") {
                        // $("#modalDLLearnerGradesSP").modal("show");
                        downloadExcel('tbl' + tableId, filename);

                        $(".downloadform").attr("disabled", false);
                        $(".downloadform").html("<span class=\"fa fa-download\"></span> Download form");
                    }
                    $("#modal" + tableId + " .content").show();
                    $("#modal" + tableId + " .overlay").hide();
                }
            });

            $("#tbl" + tableId).on('draw.dt', function() {
                $(".searchBtn").attr("disabled", false);
                $(".searchBtn").html("<span class=\"fa fa-search\"></span>");
                dtd == 1 ? $("#tbl" + tableId).DataTable().destroy() : "";
                $(".collapse" + tableId).trigger('click');
            });
            $("#tbl" + tableId + "_filter").addClass("row");
            $("#tbl" + tableId + "_filter label").css("width", "99.3%");
            $("#tbl" + tableId + "_filter .form-control-sm").css("width", "99.3%");
        }, 100);
    }

    function validateTable(table_id) {
        var c = $("#tbl" + table_id + ' input:checkbox:checked').length;
        if (c < 1) {
            existAlert("Please Select Person!");
        } else {
            if (table_id == 'SearchEnrollLearnersList') {
                searchBatchEnroll(table_id);
            } else if (table_id == 'LearnersList') {
                $("#modal" + table_id).modal('show');
            }
        }
    }

    function batchUpdateAccount(a) {
        var b = $("#form" + a).serialize();
        var d = $("[name='accountSettings']").val();
        $.post("<?= base_url($uri . "/Dataentry/saveBatchUpdateAccount") ?>", {
                c: b,
                e: d,
            },
            function(data) {
                logsHideShow()
                var d = JSON.parse(data);
                if (d.success == true) {
                    successAlert(d.message);
                    tblReload(a);
                    $("#modalLearnersList").modal('hide');
                    setTimeout(function() {
                        logsHideShow()
                        $("#learnerCheckBox").prop("checked", false);
                    }, 1500);
                    // tblReload('LearnersList');
                    // // tblReload('AssignedSectionList');
                    // // getTable("LearnersList", 0, -1);
                    // getTable("AssignedSectionList", 0, -1);
                    // setTimeout(function() {
                    //     $(".form_save_dataSectionList #slctRmRadio" + rsid + rssaid).attr("checked", true).trigger("click");
                    // }, 1500);
                } else {
                    failAlert(d.message);
                }
            }).done(function() {});
    }

    function searchBatchEnroll(a) {
        var b = $("#form" + a).serialize();
        $.post("<?= base_url($uri . "/Dataentry/saveSearchBatchEnroll") ?>", {
                c: b,
                d: rsid,
            },
            function(data) {
                var d = JSON.parse(data);
                if (d.success == true) {
                    successAlert("Successfully Saved!");
                    tblReload(a);
                    tblReload('LearnersList');
                    // tblReload('AssignedSectionList');
                    // getTable("LearnersList", 0, -1);
                    getTable("AssignedSectionList", 0, -1);
                    setTimeout(function() {
                        $(".form_save_dataSectionList #slctRmRadio" + rsid + rssaid).attr("checked", true).trigger("click");
                    }, 1500);
                } else {
                    failAlert("Something went wrong!");
                }
            }).done(function() {});
    }



    function tblReload(tableId) {
        $("#tbl" + tableId).DataTable().ajax.reload(function() {
            $("." + tableId).hide();
        });
    }

    function getSbjctAssPrsnnlFN(tableId, a, b) {
        grdlvl = a;
        rmid = b;
        tblReload(tableId);
    }

    function getLearnersListFN(tableId, a, b, c, d) {
        rsid = a;
        rssaid = b;
        adviser = c;
        sec_name = d;
        $("." + tableId).show();
        $("#tbl" + tableId + " tbody").empty();
        $("#form_save_dataEnrollmentInfo #ersid").val(a)
        resetHide(tableId);
        tblReload(tableId, c);

        if (adviser == "t") {
            getTable("Honors", 0, -1);
            $(".header1").show();
            $(".header2").removeClass("col-lg-12");
            $(".header2").addClass("col-lg-4");
        } else {
            $(".header1").hide();
            $(".header2").removeClass("col-lg-4");
            $(".header2").addClass("col-lg-12");
        }
        tblDT = $('#tbl' + tableId).DataTable();
        if (adviser === "t") {
            getTable("LearnersList", 0, -1);
        } else if (tblDT.button().length == 1) {
            tblDT.button(0).destroy();
        }
    }

    function getGradesListFN() {
        $("#form_save_dataGradesList .submitBtnPrimary").attr("disabled", false);
        $("#form_save_dataGradesList .submitBtnPrimary").html("Save Grades");
        getTable("GradesList", 0, -1);
    }

    function getGradesPSListFN() {
        $("#form_save_dataGradesPSList .submitBtnPrimary").attr("disabled", false);
        $("#form_save_dataGradesPSList .submitBtnPrimary").html("Save Grades");
        getTable("GradesPSList", 0, -1);
    }

    function getSbjctAssPrsnnl(tableId) {
        var table, table_data = $("#tbl" + tableId).DataTable({
            "order": [
                [0, "asc"]
            ],
            dom: 'Bfrtip',
            buttons: [
                'pageLength',

            ],
            "oLanguage": {
                "sSearch": ""
            },
            language: {
                searchPlaceholder: "Search...",
            },
            pageLength: -1,
            lengthMenu: [
                [-1],
                ["Show all rows"]
            ],
            ajax: {
                url: "<?= base_url($uri . '/getdata/get') ?>" + tableId,
                type: "POST",
                data: function(d) {
                    d.grdlvl = grdlvl;
                    d.rmid = rmid;
                }
            }
        });
        $("#tbl" + tableId).on('draw.dt', function() {
            $("#form_save_data" + tableId + " .select" + tableId).select2();
            grdlvl != 0 ? $("#modal" + tableId).modal('show') : "";
        });
    }

    function allStudentLogs(a) {
        search = a ?? "";
        getTable("AllStudentLogs", 0, 10, search);
        $("#modalAllStudentLogs").modal("show");
    }

    function logsHideShow() {
        $("#tblLearnersList .logs_account").toggle("slow", function() {
            if ($("#tblLearnersList .logs_account").is(":visible")) {
                logsHS = 1
            } else {
                $("#tblLearnersList .normal_view").is(":visible")
                logsHS = 0
            }
        });
        $("#tblLearnersList .normal_view").toggle("slow", function() {
            if ($("#tblLearnersList .normal_view").is(":visible")) {} else {
                $("#tblLearnersList .logs_account").is(":visible")
            }
        });
    }

    function resetHide(t) {
        if (logsHS == 1) {
            logsHideShow();
        }
    }

    function learnerAccnt(a, b) {
        $.post("<?= base_url($uri . '/Dataentry/learnerAccount') ?>", {
                a: a,
                b: b,
            },
            function(data) {
                var result = JSON.parse(data);
                if (result.success == true) {
                    successAlert("Successfully Saved!");
                    getTable("LearnersList", 0, -1);
                    setTimeout(function() {
                        logsHideShow()
                    }, 1500);
                }
            }
        ).then(function() {
            // s2 == 1 ? $("#form_save_data" + formId + " .select" + getList).select2() : "";
        });
    }

    function getLocation(a, b, c) {
        clearLoc(b, c);
        let form = 'form_save_data' + c;
        let d = $('#' + form + ' .select' + a).val();
        let ab = d == '' || d == null ? 0 : d;
        getFetchList(c, b, null, 1, {
            v: ab
        });
    }

    function clearLoc(a, b) {
        let form = 'form_save_data' + b;
        $("#" + form + " .select" + a).empty();
    }

    function getFetchList(formId, getList, getQ, s2, where, sel, e) {
        var q = getQ ? getQ : getList;
        $("#form_save_data" + formId + " .select" + getList).empty();
        $.post("<?= base_url($uri . '/getdata/get') ?>" + q, where,
            function(data) {
                var result = JSON.parse(data);
                (sel == 0 || e == 0) ? $("#form_save_data" + formId + " .select" + getList).append("<option value=''>SELECT</option>"): "";
                for (var i = 0; i < result["data"].length; i++) {
                    $("#form_save_data" + formId + " .select" + getList).append("<option value='" + result["data"][i]['id'] + "'>" + result["data"][i]['item'] + "</option>");
                }
            }
        ).then(function() {
            s2 == 1 ? $("#form_save_data" + formId + " .select" + getList).select2() : "";
        });
    }

    $('#import_form').on('submit', function(event) {

        let formData = new FormData(this);
        formData.append('rsid', rsid);

        event.preventDefault();
        // $(".submitBtnUpload").attr("disabled", true);
        $.ajax({
            url: "<?= base_url($uri . '/Dataentry/saveImportEnrollmentInfo'); ?>",
            // method:"POST",
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                // getTable("LearnersList", 0, -1);
                getTable("AssignedSectionList", 0, -1);
                // setTimeout(function() {
                //     $(".form_save_dataSectionList #slctRmRadio" + rsid + rssaid).attr("checked", true).trigger("click");
                // }, 1500);
                $('#file').val('');
                successAlert("Successfully Saved!");
            },
            error: function(data) {}
        })
    });

    function customTabViewAllGrades() {
        $("#modalAllGrades .overlay").show();
        $("#modalAllGrades .viewAllGrades").empty();
        if (vars['viewAllGrades' + rsid] != undefined) {
            $("#modalAllGrades .viewAllGrades").html(vars['viewAllGrades' + rsid]);
            $("#modalAllGrades .overlay").hide();
        } else {
            $.get("<?= base_url($uri . "/Getdata/getViewAllGrades") ?>", {
                    a: rsid
                },
                function(data) {
                    var d = JSON.parse(data);
                    vars['viewAllGrades' + rsid] = d;
                    $("#modalAllGrades .viewAllGrades").html(d);
                    $("#modalAllGrades .overlay").hide();
                }).done(function() {});
        }
    }

    function preSbmitGrades(a, b, c) {
        bTmp = b;
        cTmp = c;
        $("#modalLearnersSubmitGrades #qrssa").val(a);
        $("#modalLearnersSubmitGrades").modal("show");
    }

    function submitGrades() {
        validate("form_save_dataSubmitGradesConfirm");
        if (valid != 0) {
            fillIn();
            return false;
        }
        var s = $("#form_save_dataSubmitGradesConfirm").serialize();
        $.post("<?= base_url($uri . '/Dataentry/submitGrades') ?>", {
                c: s,
                e: rssaid
            },
            function(data) {
                var result = JSON.parse(data);
                if (result.success == true) {
                    successAlert(result.message);
                    var rm = $("#modalLearnersSubmitGrades .remarks").val();
                    $("#modalGradesList .q" + bTmp + "c").html('<span ' +
                        " class='badge w-100 text-sm bg-navy' data-toggle='tooltip' data-placement='bottom' data-html='true' title='<em>Message:</em> <b>" + rm + "</b>'>" +
                        "<b>FOR APPROVAL Q" + bTmp + " - " + cTmp + "%</b>" +
                        (rm ? '<i class="fa fa-envelope float-right text-yellow"></i>' : '') +
                        "</span>");
                    $("#modalLearnersSubmitGrades").modal('hide');
                    $("#modalLearnersSubmitGrades .remarks").val("");
                    $('[data-toggle="tooltip"]').tooltip();
                } else if (result.success == false) {
                    failAlert(result.message);
                }
            }
        ).then(function() {});
    }

    function maxInput(a, c) {
        var b = $("#" + a).val();
        if (b > 100 || b == 0) {
            $("#" + a).val("");
        } else {

        }
    }

    // function autoavg(a) {
    //     console.log('a')
    //     $(this).text("zz")
    // }

    $("[type='number']").keydown(function(e) {
        e = e || window.event;
        d = e.keyCode;
        if (d == '38' || d == '40' || d == '189' || d == '187' || d == '69') {
            e.preventDefault();
        }
    });

    function showTableHonors(a) {
        let i;
        let cc = 1;
        $("#tblHonorsList tbody").empty();
        if (a.length > 0) {
            for (i = 0; i < a.length; i++) {
                $("#tblHonorsList tbody").append('<tr>' +
                    '<td>' + cc++ + '.   ' + a[i]["l"] + '</td>' +
                    '<td><center>' + a[i]["g"] + '</center></td>' +
                    '</tr>');
            }
        }
    }


    var invalidChars = [
        "-",
        "+",
        "e",
    ];

    function clean(a) {
        var str = a;
        return str.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
    }

    function cleanInt(a) {
        var str = a;
        return str.replace(/\D/g, '');
    }

    const Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
    });

    function successAlert(a) {
        Toast.fire({
            icon: 'success',
            title: '  ' + a
        })
    }

    function failAlert(a) {
        Toast.fire({
            icon: 'error',
            title: '  ' + a
        })
    }

    function fillIn() {
        Toast.fire({
            icon: 'error',
            title: '  Please fill in all the required fields.'
        })
    }

    function existAlert(a) {
        Toast.fire({
            icon: 'warning',
            title: '  ' + a
        })
    }

    function noData(a) {
        Toast.fire({
            icon: 'warning',
            title: '  ' + a,
        })
    }

    function printForm(a, b, c, d) {
        var orientation = (b == 'p' ? 'portrait' : 'landscape');
        var margin = (c == 'Legal' ? 'margin:5mm 5mm 5mm 5mm;' : 'margin:5mm 5mm 5mm 5mm;');
        var windowUrl = 'Print Form';
        var uniqueName = new Date();
        var windowName = 'emailSection' + uniqueName.getTime();
        var accompWindow = window.open('height=1500,width=2000');
        accompWindow.document.write('<html>');
        accompWindow.document.write('<head>');
        accompWindow.document.title = d;
        accompWindow.document.write('<link rel="stylesheet" href="<?= base_url() ?>plugins/fontawesome-free/css/all.min.css">' +
            '<link rel="stylesheet" href="<?= base_url() ?>dist/css/adminlte.min.css">');
        accompWindow.document.write('</head>');
        accompWindow.document.write('<style> @page { size: ' + c + ' ' + orientation + ';' + margin + '} </style>');
        accompWindow.document.write('<body>' + $("#print" + a).html() + '</body>');
        accompWindow.document.write('</html>');
        setTimeout(function() {
            accompWindow.print();
            accompWindow.close();
        }, 1000);
    }

    function downloadExcel(a, b) {
        // var preserveColors = (table.hasClass('table2excel_with_colors') ? true : false);
        $('#' + a).table2excel({
            //exclude: ".noExl",
            name: b,
            filename: b + new Date().toISOString().replace(/[\-\:\.]/g, ""),
            fileext: ".xls",
            exclude_img: false,
            exclude_links: false,
            exclude_inputs: false,
            preserveColors: true
        });
    }

    function generatePDF() {
        // var docDefinition = {
        //     content: [{
        //         table: {
        //             // headers are automatically repeated if the table spans over multiple pages
        //             // you can declare how many rows should be treated as headers
        //             headerRows: 1,
        //             widths: ['*', 'auto', 100, '*'],

        //             body: $("#tblLearnersList tbody").html()
        //         }
        //     }]
        // };
        // open the PDF in a new window
        // pdfMake.createPdf(docDefinition).open();

        // // print the PDF
        // pdfMake.createPdf(docDefinition).print();

        // download the PDF
        // pdfMake.createPdf(docDefinition).download('optionalName.pdf');
    }

    //ranking

    function changeArr(input, N) {
        // Copy input array into newArray
        var newArray = JSON.parse(JSON.stringify(input));

        // Sort newArray[] in ascending order
        newArray.sort((a, b) => a - b);

        var i;

        // Map to store the rank of
        // the array element
        var ranks = new Map();

        var rank = 1;

        for (var index = 0; index < N; index++) {

            var element = newArray[index];

            // Update rank of element
            if (!ranks.has(element)) {
                ranks.set(element, rank);
                rank++;
            }
        }

        // Assign ranks to elements
        for (var index = 0; index < N; index++) {
            var element = input[index];
            input[index] = ranks.get(input[index]);
        }
        return input;
    }


    //reports
    function reportsConsoGrades() {
        mdl = 'modalReportConsoGrades';
        $("#" + mdl + " .content").hide();
        $("#" + mdl + " .overlay").show();
        $("#tblReportConsoGrades tbody").empty();
        $.post("<?= base_url($uri . '/reports/getReportConsoGrades') ?>", {
                rsid: rsid
            },
            function(data) {
                var result = JSON.parse(data);
                $("#tblReportConsoGrades tbody").append("<tr>" + result["thead"] + "</tr>");
                $("#tblReportConsoGrades tbody").append("<tr>" + result["thead2"] + "</tr>");
                $("#tblReportConsoGrades tbody").append("<tr>" + result["tbody"] + "</tr>");
                $("#tblReportConsoGrades tbody").append("<tr width='100%'>" + result["signatory1"] + "</tr>");
                $("#tblReportConsoGrades tbody").append("<tr width='100%'>" + result["signatory2"] + "</tr>");
                $("#tblReportConsoGrades tbody").append("<tr width='100%'>" + result["signatory3"] + "</tr>");
            }
        ).then(function() {
            var arr1 = [],
                arr2 = [],
                arr3 = [],
                arr4 = [],
                avg = [];
            $("#tblReportConsoGrades .q1TBRank").each(function() {
                arr1.push((parseInt($(this).html())) * -1);
            });

            $("#tblReportConsoGrades .q2TBRank").each(function() {
                arr2.push((parseInt($(this).html())) * -1);
            });

            $("#tblReportConsoGrades .q3TBRank").each(function() {
                arr3.push((parseInt($(this).html())) * -1);
            });

            $("#tblReportConsoGrades .q4TBRank").each(function() {
                arr4.push((parseInt($(this).html())) * -1);
            });

            $("#tblReportConsoGrades .avgTBRank").each(function() {
                avg.push((parseInt($(this).html())) * -1);
            });

            var N1 = arr1.length,
                N2 = arr2.length,
                N3 = arr3.length,
                N4 = arr4.length,
                N5 = arr4.length;
            arr1 = changeArr(arr1, N1);
            arr2 = changeArr(arr2, N2);
            arr3 = changeArr(arr3, N3);
            arr4 = changeArr(arr4, N4);
            avg = changeArr(avg, N5);
            var i1 = 0,
                i2 = 0,
                i3 = 0,
                i4 = 0,
                i5 = 0;
            $("#tblReportConsoGrades .q1Rank").each(function() {
                $(this).html(arr1[i1++]);
            });
            $("#tblReportConsoGrades .q2Rank").each(function() {
                $(this).html(arr2[i2++]);
            });
            $("#tblReportConsoGrades .q3Rank").each(function() {
                $(this).html(arr3[i3++]);
            });
            $("#tblReportConsoGrades .q4Rank").each(function() {
                $(this).html(arr4[i4++]);
            });
            $("#tblReportConsoGrades .avgRank").each(function() {
                $(this).html(avg[i5++]);
            });

            $("#" + mdl + " .content").show();
            $("#" + mdl + " .overlay").hide();


            // $('#tblReportConsoGrades').DataTable({
            //     dom: 'Bfrtip',
            //     buttons: [{
            //         extend: 'pdfHtml5',
            //         orientation: 'landscape',
            //         pageSize: 'LEGAL'
            //     }]
            // });
        });
        $("#" + mdl).modal("show");
    }


    function uploadFile(a, b, c) {
        //Reference the FileUpload element.
        var fileUpload = $("#" + a + " #" + b)[0];

        //Validate whether File is valid Excel file.
        var regex = /(.xls|.xlsx)$/;
        // console.log(fileUpload)
        // console.log(regex.test(fileUpload.value.toLowerCase()))
        if (regex.test(fileUpload.value.toLowerCase())) {
            if (typeof(FileReader) != "undefined") {
                var reader = new FileReader();

                //For Browsers other than IE.
                if (reader.readAsBinaryString) {
                    reader.onload = function(e) {
                        ProcessExcel(e.target.result, c);
                    };
                    reader.readAsBinaryString(fileUpload.files[0]);
                } else {
                    //For IE Browser.
                    reader.onload = function(e) {
                        var data = "";
                        var bytes = new Uint8Array(e.target.result);
                        for (var i = 1; i < bytes.byteLength; i++) {
                            data += String.fromCharCode(bytes[i]);
                        }
                        ProcessExcel(data, c);
                    };
                    reader.readAsText(fileUpload.files[0]);
                }
            } else {
                alert("This browser does not support HTML5.");
            }
        } else {
            alert("Please upload a valid Excel file.");
        }
        // console.log($("#" + c).html())

        // $('#' + c + ' #gradeLearner1320261403231').val(1)
        // $('#' + c + ' #gradeLearner1320231300522').val(1)


        // var tb = $('#' + c + ':eq(0) tbody');
        // var size = tb.find("tr").length;
        // console.log("Number of rows : " + size);
        // tb.find("tr").each(function(index, element) {
        //     var colSize = $(element).find('td').length;
        //     console.log("  Number of cols in row " + (index + 1) + " : " + colSize);
        //     $(element).find('td center input').each(function(index, element) {
        //         var colVal = $(element).text();
        //         // console.log(element.val())
        //         console.log(element)
        //         console.log(element.value = 1)
        //         // console.log("    Value in col " + (index + 1) + " : " + colVal.trim());
        //     });
        // });
        fileUpload = null;
        $("#" + a + " #" + b).val("");
        $("#" + a + " ." + b).text("Choose file");
        customFile
    }

    function ProcessExcel(data, c) {
        //Read the Excel File data.
        var workbook = XLSX.read(data, {
            type: 'binary'
        });


        // //Fetch the name of First Sheet.
        var firstSheet = workbook.SheetNames[0];
        // //Read all rows from First Sheet into an JSON array.
        var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);
        // //Create a HTML Table element.
        // var table = $("<table />");
        // table[0].border = "1";

        // //Add the header row.
        // var row = $(table[0].insertRow(-1));

        // //Add the header cells.
        // var headerCell = $("<th />");
        // headerCell.html("No");
        // row.append(headerCell);

        // var headerCell = $("<th />");
        // headerCell.html("LRN");
        // row.append(headerCell);

        // var headerCell = $("<th />");
        // headerCell.html("Name");
        // row.append(headerCell);

        // var headerCell = $("<th />");
        // headerCell.html("Q1");
        // row.append(headerCell);

        // var headerCell = $("<th />");
        // headerCell.html("Q2");
        // row.append(headerCell);

        // var headerCell = $("<th />");
        // headerCell.html("Q3");
        // row.append(headerCell);

        // var headerCell = $("<th />");
        // headerCell.html("Q4");
        // row.append(headerCell);

        //Add the data rows from Excel file.
        // console.log('zzzz')
        // console.log(excelRows)
        // console.log(excelRows.length)
        for (var i = 1; i < excelRows.length; i++) {
            //Add the data row.
            // var row = $(table[0].insertRow(-1));

            //Add the data cells.
            // var cell = $("<td />");
            // cell.html(excelRows[i].No);
            // row.append(cell);

            // cell = $("<td />");
            // cell.html(excelRows[i].Lrn);
            // row.append(cell);

            // cell = $("<td />");
            // cell.html(excelRows[i].Name);
            // row.append(cell);

            // cell = $("<td />");
            // cell.html(excelRows[i].Q1);
            // row.append(cell);

            // cell = $("<td />");
            // cell.html(excelRows[i].Q2);
            // row.append(cell);

            // cell = $("<td />");
            // cell.html(excelRows[i].Q3);
            // row.append(cell);

            // cell = $("<td />");
            // cell.html(excelRows[i].Q4);
            // row.append(cell);

            // __EMPTY: "No"
            // __EMPTY_1: "Lrn"
            // __EMPTY_2: "Name"
            // __EMPTY_3: "Q1"
            // __EMPTY_4: "Q2"
            // __EMPTY_5: "Q3"
            // __EMPTY_6: "Q4"
            // __EMPTY_7: "|"
            // __EMPTY_8: " Q1 "
            // __EMPTY_9: " Q2 "
            // __EMPTY_10: " Q3 "
            // __EMPTY_11: " Q4 "

            // console.log(excelRows[i].Lrn)
            var lrn = cleanInt(excelRows[i].Lrn);
            $('#tblGradesList #gradeLearner' + lrn + '1').val(excelRows[i].Grades_Entry_Data)
            $('#tblGradesList #gradeLearner' + lrn + '2').val(excelRows[i].__EMPTY)
            $('#tblGradesList #gradeLearner' + lrn + '3').val(excelRows[i].__EMPTY_1)
            $('#tblGradesList #gradeLearner' + lrn + '4').val(excelRows[i].__EMPTY_2)

            $('#tblGradesPSList #gradeLearner' + lrn + '1').val(excelRows[i].Percentage_Score_Data)
            $('#tblGradesPSList #gradeLearner' + lrn + '2').val(excelRows[i].__EMPTY_3)
            $('#tblGradesPSList #gradeLearner' + lrn + '3').val(excelRows[i].__EMPTY_4)
            $('#tblGradesPSList #gradeLearner' + lrn + '4').val(excelRows[i].__EMPTY_5)
        }

        // var dvExcel = $("#dvExcel");
        // dvExcel.html("");
        // dvExcel.append(table);
    };
</script>