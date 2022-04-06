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
<script src="<?= base_url() ?>plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="<?= base_url() ?>plugins/datatables/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>plugins/datatables/extensions/responsive/js/dataTables.responsive.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url() ?>plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?= base_url() ?>plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>dist/js/adminlte.min.js"></script>

<script src="<?= base_url() ?>plugins/highcharts/highcharts.js"></script>
<script src="<?= base_url() ?>plugins/highcharts/highcharts-3d.js"></script>
<script src="<?= base_url() ?>plugins/highcharts/highcharts-more.js"></script>
<!-- <script src="<?= base_url() ?>plugins/highcharts/modules/organization.js"></script>
<script src="<?= base_url() ?>plugins/highcharts/modules/exporting.js"></script>
<script src="<?= base_url() ?>plugins/highcharts/modules/accessibility.js"></script>
<script src="<?= base_url() ?>plugins/highcharts/modules/export-data.js"></script>
<script src="<?= base_url() ?>plugins/highcharts/modules/drilldown.js"></script> -->

<script type="text/javascript">

    $.post("<?= base_url($uri . '/dashboard/getMFGradelvl') ?>",
        function(data) {
            var result = JSON.parse(data);
            // console.log(result)
            console.log(data)

    Highcharts.chart('container1', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Male & Female per Grade Level'
        },
        subtitle: {
            text: 'School Year <?= $getOnLoad["sy"]; ?> as of <?= Date("M d, Y"); ?>'
        },
        xAxis: {
            categories: result["categories"],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Male/Female Count'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: result["series"]
    });
        }
    ).then(function() {
    });


    $.post("<?= base_url($uri . '/dashboard/getMFAgebracket') ?>",
        function(data) {
            var result = JSON.parse(data);
            // console.log(result)
            console.log(data)

    Highcharts.chart('container2', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Male & Female per Age Bracket'
        },
        subtitle: {
            text: 'School Year <?= $getOnLoad["sy"]; ?> as of <?= Date("M d, Y"); ?>'
        },
        xAxis: {
            categories: result["categories"],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Male/Female Count'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: result["series"]
    });
        }
    ).then(function() {
    });
</script>