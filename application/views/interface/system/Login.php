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
<!-- <body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><img src="<?= $system_logo ?>" width="40"> <small style="font-size:22px;"> COVID-19 <i class="fa fa-viruses fa-2x"></i> Monitoring</small></a>
  </div>

  <div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <?php if ($this->input->get("login_attempt") == md5(0) || $this->input->get("login_attempt") == md5(1)): ?>
            <p class='text-danger text-center text-sm'><i class="fa fa-exclamation-triangle"></i> Invalid Username or Password. Please try again.</p>
        <?php endif ?>

      <form action="<?= base_url() ?>requestlogin" method="post">
        
        <div class="input-group mb-3">
          <input type="username" name="username" class="form-control <?php if ($this->input->get("login_attempt") == md5(0)): ?> is-invalid <?php endif ?>" placeholder="Email" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control <?php if ($this->input->get("login_attempt") == md5(0)): ?> is-invalid <?php endif ?>" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-user"></i> Sign In</button>
          </div>
        </div>
      </form>

    </div>
  </div>
</div> -->
<!-- /.login-box -->
<body ng-app="loginApp" class="hold-transition login-page" style="background-image : url(<?= $system_logo ?>);background-repeat: no-repeat; background-size: 45%;background-position: center center;overflow:hidden;" >
  <div class="card" style="opacity: .95;font-family:Arial;">
    <div class="card-body login-card-body">
        <div class="login-logo p-1" style="background-color:#3c8dbc;">
            <small><b style="color:white;font-size:26px;"> COVID-19 <i class="fa fa-virus fa-2x"></i> Monitoring</b></small>
        </div>
        <?php if ($this->input->get("login_attempt") == md5(0) || $this->input->get("login_attempt") == md5(1)): ?>
            <p class='text-danger text-center text-sm'><i class="fa fa-exclamation-triangle"></i> Invalid Username or Password. Please try again.</p>
        <?php endif ?>

      <form action="<?= base_url() ?>requestlogin" method="post">
        
        <div class="input-group mb-3">
          <input type="username" name="username" class="form-control <?php if ($this->input->get("login_attempt") == md5(0)): ?> is-invalid <?php endif ?>" placeholder="Username" autofocus autocomplete="off">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control <?php if ($this->input->get("login_attempt") == md5(0)): ?> is-invalid <?php endif ?>" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-user"></i> Sign In</button>
          </div>
          <div class="col-6">
            <button type="reset" class="btn btn-default btn-block">Clear</button>
          </div>
        </div>
      </form>

    </div>
  </div>
    <!-- /.login-box -->



<!-- jQuery -->
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>

</body>
</html>
