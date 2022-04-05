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
    // Data gathered from http://populationpyramid.net/germany/2015/

    // Age categories
    // var categories = [
    //     '10', '9', '8', '7'
    // ];

    // Highcharts.chart('container1', {
    //     chart: {
    //         type: 'bar'
    //     },
    //     title: {
    //         text: 'Male & Female per Grade Level'
    //     },
    //     subtitle: {
    //         text: 'School Year 2021-2022 as of March 30, 2022'
    //     },
    //     accessibility: {
    //         point: {
    //             valueDescriptionFormat: '{index}. Grade lvl {xDescription}, {value}%.'
    //         }
    //     },
    //     xAxis: [{
    //         categories: categories,
    //         reversed: false,
    //         labels: {
    //             step: 1
    //         },
    //         accessibility: {
    //             description: 'Grade lvl (male)'
    //         }
    //     }, { // mirror axis on right side
    //         opposite: true,
    //         reversed: false,
    //         categories: categories,
    //         linkedTo: 0,
    //         labels: {
    //             step: 1
    //         },
    //         accessibility: {
    //             description: 'Grade lvl (female)'
    //         }
    //     }],
    //     yAxis: {
    //         title: {
    //             text: null
    //         },
    //         labels: {
    //             formatter: function() {
    //                 // return Math.abs(this.value) + '%';
    //                 return Math.abs(this.value);
    //             }
    //         },
    //         accessibility: {
    //             description: 'Percentage population',
    //             rangeDescription: 'Range: 0 to 5%'
    //         }
    //     },

    //     plotOptions: {
    //         series: {
    //             stacking: 'normal'
    //         }
    //     },


    //     tooltip: {
    //         formatter: function() {
    //             return '<b>' + this.series.name + ', Grade lvl ' + this.point.category + '</b><br/>' +
    //                 'Population: ' + this.point.y;//Highcharts.numberFormat(Math.abs(this.point.y), 1) + '%';
    //         }
    //     },

    //     series: [{
    //         name: 'Male',
    //         color: "#007bff",
    //         data: [
    //             -276, -255, -268, -210
    //         ]
    //     }, {
    //         name: 'Female',
    //         color: "#dc3545",
    //         data: [
    //             294, 268, 275, 235
    //         ]
    //     }]
    // });

    $.post("<?= base_url($uri . '/dashboard/getMFGradelvl') ?>",
        function(data) {
            var result = JSON.parse(data);
            console.log(result)
            // (sel == 0 || e == 0) ? $("#form_save_data" + formId + " .select" + getList).append("<option value=''>SELECT</option>"): "";
            // for (var i = 0; i < result["data"].length; i++) {
            //     $("#form_save_data" + formId + " .select" + getList).append("<option value='" + result["data"][i]['id'] + "'>" + result["data"][i]['item'] + "</option>");
            // }
        }
    ).then(function() {
        // s2 == 1 ? $("#form_save_data" + formId + " .select" + getList).select2() : "";
    });

    Highcharts.chart('container1', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Male & Female per Grade Level'
        },
        subtitle: {
            text: 'School Year 2021-2022 as of March 30, 2022'
        },
        xAxis: {
            categories: [
                'Grade 7',
                'Grade 8',
                'Grade 9',
                'Grade 10',
            ],
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
                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
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
        series: [{
            name: 'Male',
            color: "#007bff",
            data: [49.9, 71.5, 106.4, 129.2]

        }, {
            name: 'Female',
            color: "#dc3545",
            data: [83.6, 78.8, 98.5, 93.4]

        }]
    });
</script>