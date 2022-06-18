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
<!-- Popper -->
<script src="<?= base_url() ?>plugins/popper/popper.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url() ?>plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?= base_url() ?>plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>dist/js/adminlte.min.js"></script>

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
    var rssaid = 0;
    var logsHS = 0;
    var adviser = 0;
    var bTmp = 0;
    var cTmp = 0;
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
        let a = "";
        var saveData = {
            clearForm: false,
            resetForm: false,
            beforeSubmit: function(e) {
                validate("form_save_data" + formId);
                if (valid != 0) {
                    fillIn();
                    return false;
                }
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
                    if (formId != "GradesList") {
                        clear_form("form_save_data" + formId);
                        $("#modal" + formId).modal('hide');
                    }
                    if (formId == "GradesList") {
                        getGradesListFN();
                    }
                    if (tblId.length > 1) {
                        for (var i = 0; i < tblId.length; i++) {
                            getTable(tblId[i], dtd, pl);
                        }
                    }
                    tbl ? removeAllItemList("tbl" + tbl) : null;
                    tbl ? $("#btn" + tbl).trigger("click") : null;

                    if (formId == 'EnrollmentInfo') {
                        $('#modalEnrollment').modal('hide');
                    }
                } else if (d.exist == true) {
                    existAlert("Person already exist!<br/>You can search and add TEST RESULT");
                } else if (d.existCode == true) {
                    existAlert("Code already taken!<br/>by: " + d.existPerson);
                } else if (d.message) {
                    failAlert(d.message);
                } else {
                    failAlert("Something went wrong!");
                }
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

            searching: tableId == 'GradesList' ? false : true,
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
                    $("#modal" + tableId + " .content").show();
                    $("#modal" + tableId + " .overlay").hide();
                    $('[data-toggle="tooltip"]').tooltip()
                }
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

    function getLearnersListFN(tableId, a, b, c) {
        rsid = a;
        rssaid = b;
        adviser = c;
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
        $.get("<?= base_url($uri . "/Getdata/getViewAllGrades") ?>", {
                a: rsid
            },
            function(data) {
                var d = JSON.parse(data);
                $("#modalAllGrades .viewAllGrades").html(d);
                $("#modalAllGrades .overlay").hide();
            }).done(function() {});
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

    function maxInput(a) {
        var b = $("#" + a).val();
        if (b > 100 || b == 0) {
            $("#" + a).val("");
        } else {

        }
    }

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
        accompWindow.document.write('<style> @page { size: ' + c + ' ' + orientation + ';' + margin + '} .square {height: 100px;width: 100px;border:1px solid black; } </style>');
        accompWindow.document.write('<body>' + $("#print" + a).html() + '</body>');
        accompWindow.document.write('</html>');
        setTimeout(function() {
            accompWindow.print();
            accompWindow.close();
        }, 1000);
    }

    //reports
    function reportsConsoGrades() {
        // $("printConsoGrades")
        // alert(rssaid)
        // alert('z')

        // a = $(".submitBtnMFGradelvl").text();
        // $(".submitBtnMFGradelvl").attr("disabled", true);
        // $(".submitBtnMFGradelvl").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
        // var pl = 1;
        // $("#tblReportConsoGrades").DataTable().destroy();
        // var table, table_data = $("#tblReportConsoGrades").DataTable({
        //     ajax: {
        //         url: "<?= base_url($uri . '/reports/getReportConsoGrades') ?>",
        //         type: "POST",
        //         data: function(d) {
        //             d.rsid = rsid;
        //         }
        //     },
        //     fnInitComplete: function(oSettings, json) {

        //         $("#tblReportConsoGrades").DataTable().destroy();
        //         $("#modalReportConsoGrades").modal("show");

        //         // $(".submitBtnReportConsoGrades").attr("disabled", false);
        //         // $(".submitBtnReportConsoGrades").html(a);
        //     }
        // });
        // alert(rsid)

        $("#tblReportConsoGrades tbody").empty();
        $.post("<?= base_url($uri . '/reports/getReportConsoGrades') ?>", {
                rsid: rsid
            },
            function(data) {
                // console.log(data)
                var result = JSON.parse(data);
                console.log(result);
                $("#tblReportConsoGrades tbody").append("<tr>" + result["thead"] + "</tr>");
                $("#tblReportConsoGrades tbody").append("<tr>" + result["tbody"] + "</tr>");
            }
        ).then(function() {
            // s2 == 1 ? $("#form_save_data" + formId + " .select" + getList).select2() : "";
        });
        $("#modalReportConsoGrades").modal("show");




    }
</script>