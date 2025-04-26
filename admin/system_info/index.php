<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Repositoriotesis/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Repositoriotesis/admin/inc/header.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Repositoriotesis/admin/inc/navigation.php');
?>

<!-- Contenido dentro del wrapper -->
<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid py-3">
      <div class="card card-outline card-primary">
        <div class="card-header">
          <h3 class="card-title">Ajustes del Sistema</h3>
        </div>
        <div class="card-body">
          <form action="" id="system-frm">
            <input type="hidden" name="id" value="<?= $_settings->info('id') ?>">
            <div class="form-group">
              <label for="name">Nombre del sistema</label>
              <input type="text" name="name" id="name" value="<?= $_settings->info('name') ?>" class="form-control form-control-sm" required>
            </div>
            <div class="form-group">
              <label for="short_name">Nombre corto</label>
              <input type="text" name="short_name" id="short_name" value="<?= $_settings->info('short_name') ?>" class="form-control form-control-sm" required>
            </div>
            <div class="form-group">
              <label for="title">Título del sitio</label>
              <input type="text" name="title" id="title" value="<?= $_settings->info('title') ?>" class="form-control form-control-sm" required>
            </div>
            <div class="form-group">
              <label for="logo">Logo del sistema</label>
              <input type="file" name="img" id="img" class="form-control-sm">
            </div>
            <div class="form-group d-flex justify-content-end">
              <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
$(document).ready(function(){
  $('#system-frm').submit(function(e){
    e.preventDefault();
    start_loader();
    $.ajax({
      url: _base_url_ + "classes/SystemSettings.php?f=update_settings",
      method: "POST",
      data: new FormData($(this)[0]),
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      error: function(err){
        console.error(err);
        alert_toast("Ocurrió un error.", "error");
        end_loader();
      },
      success: function(resp){
        if(resp.status == 'success'){
          alert_toast("Ajustes guardados exitosamente.", "success");
          setTimeout(() => location.reload(), 2000);
        } else {
          alert_toast("No se pudo guardar.", "error");
        }
        end_loader();
      }
    });
  });
});
</script>

<?php include(base_app . 'admin/inc/footer.php'); ?>

