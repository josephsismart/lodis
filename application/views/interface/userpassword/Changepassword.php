<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Butuan COVID-19 Monitoring | Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" type="image/png" href="<?= $system_logo ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
</head>
<body ng-app="loginApp" class="hold-transition login-page">
  <div class="card" style="opacity: .95;font-family:Arial;">
    <div class="card-body login-card-body">
        <div class="login-logo p-1" style="background-color:#f8f9fa;">
            <small><b style="color:white;font-size:26px;color:#3c8dbc;"> COVID-19 <i class="fa fa-virus fa-2x"></i> Monitoring</b></small>
        </div>
        <?php if ($this->input->get("change_attempt") == md5(0)): ?>
            <p class='text-danger text-center text-sm'><i class="fa fa-exclamation-triangle"></i> Please try again.</p>
        <?php endif ?>

        <?php if ($this->input->get("change_attempt") == md5(1)): ?>
            <p class='text-danger text-center text-sm'><i class="fa fa-exclamation-triangle"></i> Current Password Mismatched. Please try again.</p>
        <?php endif ?>

        <?php if ($this->input->get("change_attempt") == md5(2)): ?>
            <p class='text-danger text-center text-sm'><i class="fa fa-exclamation-triangle"></i> New Password at least 8 Characters. Please try again.</p>
        <?php endif ?>

        <?php if ($this->input->get("change_attempt") == md5(2)): ?>
            <p class='text-danger text-center text-sm'><i class="fa fa-exclamation-triangle"></i> New Password Mismatched. Please try again.</p>
        <?php endif ?>

      <form action="<?= base_url() ?>updatePassword" method="post" id="form_update_password">
        
        <div class="input-group mb-3">
          <input type="password" name="current" class="form-control <?php if ($this->input->get("login_attempt") == md5(0)): ?> is-invalid <?php endif ?>" placeholder="Current Password" autofocus autocomplete="off" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-key"></span>
            </div>
          </div>
        </div>
        
        <p class='text-center text-sm mb-1'>New Password at least <b>8</b> Characters.</p>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control <?php if ($this->input->get("login_attempt") == md5(0)): ?> is-invalid <?php endif ?>" placeholder="New Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-key"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="confirm" class="form-control <?php if ($this->input->get("login_attempt") == md5(0)): ?> is-invalid <?php endif ?>" placeholder="Confirm Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-key"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-default btn-block submitBtn"><i class="fa fa-check"></i> Change Password</button>
          </div>
        </div>
      </form>

    </div>
  </div>

<!-- jQuery -->
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.form.min.js"></script>

<script type="text/javascript">
    function validate_form(form_id) {
        $("#"+form_id).find("input").each(function() {
            var name = $(this).attr("name");
            if(!$(this).val()){
                validatorC=0;
                $(this).focus().addClass("is-invalid");
            } else{
                validatorC=1;
                $(this).removeClass("is-invalid");
            }
        });
    }

</script>

</body>
</html>
