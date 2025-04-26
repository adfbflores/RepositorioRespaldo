<style>
  /* Estilos para la imagen del usuario */
  .user-img {
    position: absolute;
    height: 27px;
    width: 27px;
    object-fit: cover;
    left: -7%;
    top: -12%;
  }

  /* Estilos para botones con bordes redondeados */
  .btn-rounded {
    border-radius: 50px;
  }
</style>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-primary border border-dark border-top-0 border-left-0 border-right-0 navbar-light text-sm shadow-sm text-danger">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <!-- Botón hamburguesa funcional -->
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars"></i>
      </a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?= base_url ?>" class="nav-link">
        <b><?= (!isMobileDevice()) ? $_settings->info('name') : $_settings->info('short_name'); ?></b>
      </a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- User Dropdown Menu -->
    <li class="nav-item">
      <div class="btn-group nav-link">
        <button type="button" class="btn btn-rounded badge badge-light dropdown-toggle dropdown-icon" data-toggle="dropdown">
          <span>
            <img src="<?= validate_image($_settings->userdata('avatar')) ?>" class="img-circle elevation-2 user-img" alt="User Image">
          </span>
          <span class="ml-3"><?= ucwords($_settings->userdata('firstname') . ' ' . $_settings->userdata('lastname')) ?></span>
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu" role="menu">
          <a class="dropdown-item" href="<?= base_url . 'admin/?page=user' ?>">
            <span class="fa fa-user"></span> Mi cuenta
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?= base_url . '/classes/Login.php?f=logout' ?>">
            <span class="fas fa-sign-out-alt"></span> Cerrar Sesión
          </a>
        </div>
      </div>
    </li>
  </ul>
</nav>
<!-- /.navbar -->

