<?php require_once('../config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('inc/header.php'); ?>
<body class="hold-transition">
  <script>
    start_loader(); // Inicia el loader cuando se carga la página
  </script>
  <style>
    html, body{
      height: 100%; /* Se establece la altura del cuerpo y el html al 100% */
      width: 100%; /* Se establece el ancho del cuerpo y el html al 100% */
    }
    body{
      background-image: url("<?php echo htmlspecialchars(validate_image($_settings->info('cover')), ENT_QUOTES, 'UTF-8'); ?>"); /* Se muestra la imagen de fondo */
      background-size: cover; /* Se ajusta el tamaño de la imagen de fondo */
      background-repeat: no-repeat; /* Se establece la repetición de la imagen de fondo */
    }
    .login-title{
      text-shadow: 2px 2px black; /* Se agrega un efecto de sombra al texto */
    }
    #login{
      flex-direction: column !important; /* Se establece la dirección de la caja flexible a columna */
    }
    #logo-img{
        height: 150px;
        width: 150px;
        object-fit: scale-down;
        object-position: center center;
        border-radius: 100%; /* Se establece un borde circular para la imagen */
    }
    #login .col-7, #login .col-5{
      width: 100% !important;
      max-width: unset !important; /* Se establece el ancho de las columnas */
    }
  </style>
  <div class="h-100 d-flex align-items-center w-100" id="login">
    <div class="col-7 h-100 d-flex align-items-center justify-content-center">
      <div class="w-100">
        <center><img src="<?= htmlspecialchars(validate_image($_settings->info('logo')), ENT_QUOTES, 'UTF-8'); ?>" alt="" id="logo-img"></center> <!-- Se muestra el logotipo -->
        <h1 class="text-center py-5 login-title"><b><?php echo htmlspecialchars($_settings->info('name'), ENT_QUOTES, 'UTF-8'); ?></b></h1> <!-- Se muestra el nombre -->
      </div>
    </div>
    <div class="col-5 h-100 bg-gradient">
      <div class="d-flex w-100 h-100 justify-content-center align-items-center">
        <div class="card col-sm-12 col-md-6 col-lg-3 card-outline card-primary">
          <div class="card-header">
            <h4 class="text-purle text-center"><b>Iniciar Sesión</b></h4>
          </div>
          <div class="card-body">
            <form id="login-frm" action="" method="post">
              <div class="input-group mb-3">
                <input type="text" class="form-control" autofocus name="username" placeholder="Nombre de usuario">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input type="password" class="form-control" name="password" placeholder="Contraseña">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <a href="<?php echo htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8'); ?>">ir al inicio</a> <!-- Se muestra el enlace al inicio -->
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" class="btn btn-primary btn-block">Ingresa</button> <!-- Se muestra el botón de ingreso -->
                </div>
                <!-- /.col -->
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<script>
  $(document).ready(function(){
    end_loader(); // Finaliza el loader cuando el documento está listo
  });
</script>
</body>
</html>
