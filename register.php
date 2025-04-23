<?php 
// Incluir el archivo de configuración
require_once('./config.php');

// Incluir el encabezado
require_once('inc/header.php');
?>

<body class="hold-transition">

  <script>
    start_loader();
  </script>

  <style>
    html,
    body {
      height: calc(100%) !important;
      width: calc(100%) !important;
    }

    body {
      background-image: url("<?= validate_image($_settings->info('cover')) ?>");
      background-size: cover;
      background-repeat: no-repeat;
    }

    .login-title {
      text-shadow: 2px 2px black;
    }

    #login {
      direction: rtl;
    }

    #login>* {
      direction: ltr;
    }

    #logo-img {
      height: 150px;
      width: 150px;
      object-fit: scale-down;
      object-position: center center;
      border-radius: 100%;
    }
  </style>

  <div class="h-100 d-flex  align-items-center w-100" id="login">
    <div class="col-7 h-100 d-flex align-items-center justify-content-center">
      <div class="w-100">
        <center><img src="<?= validate_image($_settings->info('logo')) ?>" alt="" id="logo-img"></center>
        <h1 class="text-center py-5 login-title"><b><?= $_settings->info('name') ?> - Admin</b></h1>
      </div>
    </div>
    <div class="col-5 h-100 bg-gradient bg-primary">
      <div class="w-100 d-flex justify-content-center align-items-center h-100 text-navy">
        <div class="card card-outline card-primary rounded-0 shadow col-lg-10 col-md-10 col-sm-5">
          <div class="card-header">
            <h5 class="card-title text-center text-dark"><b>Registro</b></h5>
          </div>
          <div class="card-body">
            <form action="" id="registration-form">
              <input type="hidden" name="id">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <input type="text" name="firstname" id="firstname" autofocus placeholder="Nombre" class="form-control form-control-border" required>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <input type="text" name="middlename" id="middlename" placeholder="Segundo Nombre (opcional)" class="form-control form-control-border">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <input type="text" name="lastname" id="lastname" placeholder="Apellido" class="form-control form-control-border" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-auto">
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="genderMale" name="gender" value="Male" required checked>
                    <label for="genderMale" class="custom-control-label">Masculino</label>
                  </div>
                </div>
                <div class="form-group col-auto">
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="genderFemale" name="gender" value="Female">
                    <label for="genderFemale" class="custom-control-label">Femenino</label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <span class="text-navy"><small>Facultad</small></span>
                    <select name="department_id" id="department_id" class="form-control form-control-border select2" data-placeholder="Seleccionar el departamento" required>
                      <option value="" disabled></option>
                      <?php 
                      // Consultar la lista de facultades
                      $department = $conn->query("SELECT * FROM `department_list` where status = 1 order by `name` asc");
                      while($row = $department->fetch_assoc()):
                      ?>
                      <option value="<?= $row['id'] ?>"><?= ucwords($row['name']) ?></option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="```php
<div class="form-group">
                    <span class="text-navy"><small>Carrera</small></span>
                    <select name="curriculum_id" id="curriculum_id" class="form-control form-control-border select2" data-placeholder="Seleccionar materia" required>
                      <option value="" disabled selected>Primero seleccionar facultad</option>
                      <?php 
                      // Consultar la lista de planes de estudio
                      $curriculum = $conn->query("SELECT * FROM `curriculum_list` where status = 1 order by `name` asc");
                      $cur_arr = [];
                      while($row = $curriculum->fetch_assoc()){
                          $row['name'] = ucwords($row['name']);
                          $cur_arr[$row['department_id']][] = $row;
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <input type="email" name="email" id="email" placeholder="Correo" class="form-control form-control-border" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <input type="password" name="password" id="password" placeholder="Contraseña" class="form-control form-control-border" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <input type="password" id="cpassword" placeholder="Confirmar contraseña" class="form-control form-control-border" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group text-right">
                    <button class="btn btn-default bg-navy btn-flat"> Registrarse</button>
                  </div>
                </div>
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
  <!-- Select2 -->
  <script src="<?php echo base_url ?>plugins/select2/js/select2.full.min.js"></script>

  <script>
    var cur_arr = <?= json_encode($cur_arr) ?>;
    $(document).ready(function () {
      end_loader();
      $('.select2').select2({
        width: "100%"
      });
      $('#department_id').change(function () {
        var did = $(this).val();
        $('#curriculum_id').html("");
        if (!!cur_arr[did]) {
          Object.keys(cur_arr[did]).map(k => {
            var opt = $("<option>");
            opt.attr('value', cur_arr[did][k].id);
            opt.text(cur_arr[did][k].name);
            $('#curriculum_id').append(opt);
          });
        }
        $('#curriculum_id').trigger("change");
      });

      // Registro del formulario de registro
      $('#registration-form').submit(function (e) {
        e.preventDefault();
        var _this = $(this);
        $(".pop-msg").remove();
        $('#password, #cpassword').removeClass("is-invalid");
        var el = $("<div>");
        el.addClass("alert pop-msg my-2");
        el.hide();
        if ($("#password").val() != $("#cpassword").val()) {
          el.addClass("alert-danger");
          el.text("La contraseña no coincide.");
          $('#password, #cpassword').addClass("is-invalid");
          $('#cpassword').after(el);
          el.show('slow');
          return false;
        }
        start_loader();
        $.ajax({
          url: _base_url_ + "classes/Users.php?f=save_student",
          method: 'POST',
          data: _this.serialize(),
          dataType: 'json',
          error: function (err) {
            console.log(err);
            el.text("Ocurrió un error al guardar los datos");
            el.addClass("alert-danger");
            _this.prepend(el);
            el.show('slow');
            end_loader();
          },
          success: function (resp) {
            if (resp.status == 'success') {
              location.href = "./login.php";
            } else if (!!resp.msg) {
              el.text(resp.msg);
              el.addClass("alert-danger");
              _this.prepend(el);
              el.show('show');
            } else {
              el.text("Ocurrió un error al guardar los datos");
              el.addClass("alert-danger");
              _this.prepend(el);
              el.show('show');
            }
            end_loader();
            $('html, body').animate({ scrollTop: 0 }, 'fast');
          }
        });
      });
    });
  </script>
</body>
</html>
