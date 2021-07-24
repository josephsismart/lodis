<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php 
    if (!$this->session->schoolmis_login_level) {
        redirect(base_url('login'));
    }
    $uri = $this->session->schoolmis_login_uri;
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view('interface/'.$uri.'/layout/Css'); ?>            
    <!-- <script src="<?= base_url() ?>assets/bower_components/jquery/dist/jquery.min.js"></script> -->
    <script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
</head>
<body class="hold-transition layout-fixed layout-navbar-fixed sidebar-collapse layout-top-nav text-sm">
    <div class="wrapper">
        <?php $this->load->view('interface/'.$uri.'/layout/Header')?>
        <div class="content-wrapper" >
            <?php foreach ($content as $data): ?>
                <?= $data ?>    
            <?php endforeach ?> 
        </div>
        <?php $this->load->view('interface/'.$uri.'/layout/Footer')?>
       <!-- Control Sidebar -->
       <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
       </aside>
       <!-- /.control-sidebar -->
        <?php $this->load->view('interface/'.$uri.'/layout/Modal')?>
    </div>

    <?php $this->load->view('interface/'.$uri.'/layout/Js'); ?>
    <script type="text/javascript">
        $(".<?= $current_location ?>").addClass("active");
    </script>
</body>
</html>