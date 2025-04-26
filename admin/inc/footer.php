<!-- Main Footer -->
<footer class="main-footer text-sm">
  <strong>Copyright &copy; <?= date('Y') ?> <a href="#"><?= $_settings->info('short_name') ?></a>.</strong>
  Todos los derechos reservados.
  <div class="float-right d-none d-sm-inline-block">
    <b>Versión</b> 1.0
  </div>
</footer>

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?= base_url ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url ?>dist/js/adminlte.js"></script>
<!-- Opcionales: si tuvieras más scripts propios -->
<?php if (isset($custom_js)) echo $custom_js; ?>

