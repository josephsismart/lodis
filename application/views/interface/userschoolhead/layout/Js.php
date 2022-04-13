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
<script type="text/javascript">
    $(".submitBtnMFGradelvl").click(function(){
        a = $(".submitBtnMFGradelvl").text();
        $(".submitBtnMFGradelvl").attr("disabled", true);
        $(".submitBtnMFGradelvl").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
        // $.post("<?= base_url($uri . '/reports/getMFGradelvl') ?>",
        // function(data) {
        //     var result = JSON.parse(data);
        //     console.log(result);

        // });
            $(".submitBtnMFGradelvl").attr("disabled", false);
            $(".submitBtnMFGradelvl").html(a);
        var pl = 1;
            $("#tblMFGradelvl").DataTable().destroy();
            var table, table_data = $("#tblMFGradelvl").DataTable({
                // "order": [
                //     [0, "asc"]
                // ],
                dom: 'Bfrtip',
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
                    url: "<?= base_url($uri . '/reports/getMFGradelvl') ?>",
                    type: "POST",
                    data: function(d) {}
                }
            });

            $("#tblMFGradelvl").on('draw.dt', function() {
                $("#tblMFGradelvl").DataTable().destroy();
                $("#modalMFGradelvl").modal("show");
                // $(".collapse" + tableId).trigger('click');
            });
    });

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
</script>