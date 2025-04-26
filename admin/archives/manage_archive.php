<?php
require_once('../../config.php');
require_once('../inc/header.php');
require_once('../inc/navigation.php');

$id = $_GET['id'] ?? '';
$archive = [];

if (!empty($id)) {
    $qry = $conn->query("SELECT * FROM archive_list WHERE id = '{$id}'");
    if($qry->num_rows > 0) {
        $archive = $qry->fetch_assoc();
    }
}

$curriculums = $conn->query("SELECT * FROM curriculum_list ORDER BY name ASC")->fetch_all(MYSQLI_ASSOC);
?>

<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid py-4">
      <div class="card card-outline card-primary">
        <div class="card-header">
          <h3 class="card-title"><?= empty($id) ? 'Registrar Nueva Tesis' : 'Editar Tesis' ?></h3>
        </div>
        <div class="card-body">
          <form action="" id="archive-frm" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $archive['id'] ?? '' ?>">

            <div class="form-group">
              <label for="archive_code">Código de Archivo</label>
              <input type="text" name="archive_code" id="archive_code" class="form-control form-control-sm" value="<?= htmlspecialchars($archive['archive_code'] ?? '') ?>">
            </div>

            <div class="form-group">
              <label for="title">Título del Proyecto</label>
              <input type="text" name="title" id="title" class="form-control form-control-sm" required value="<?= htmlspecialchars($archive['title'] ?? '') ?>">
            </div>

            <div class="form-group">
              <label for="members">Integrantes (Autores)</label>
              <input type="text" name="members" id="members" class="form-control form-control-sm" value="<?= htmlspecialchars($archive['members'] ?? '') ?>">
            </div>

            <div class="form-group">
              <label for="curriculum_id">Carrera</label>
              <select name="curriculum_id" id="curriculum_id" class="form-control form-control-sm" required>
                <option value="" disabled>Seleccione una carrera</option>
                <?php foreach($curriculums as $curriculum): ?>
                  <option value="<?= $curriculum['id'] ?>" <?= isset($archive['curriculum_id']) && $archive['curriculum_id'] == $curriculum['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($curriculum['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="year">Año</label>
              <input type="number" name="year" id="year" class="form-control form-control-sm" required value="<?= htmlspecialchars($archive['year'] ?? '') ?>">
            </div>

            <div class="form-group">
              <label for="abstract">Resumen</label>
              <textarea name="abstract" id="abstract" class="form-control form-control-sm" rows="4"><?= htmlspecialchars($archive['abstract'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
              <label for="file">Archivo de la Tesis (PDF)</label>
              <input type="file" name="file" id="file" class="form-control form-control-sm" accept="application/pdf">
              <?php if (!empty($archive['file_path'])): ?>
                <small class="text-muted">Archivo actual: 
                  <a href="<?= base_url . $archive['file_path'] ?>" target="_blank">Ver Documento</a>
                </small>
              <?php endif; ?>
            </div>

            <div class="form-group d-flex justify-content-end">
              <button class="btn btn-primary btn-sm" type="submit">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
$(document).ready(function(){
  $('#archive-frm').submit(function(e){
    e.preventDefault();
    start_loader();

    var formData = new FormData(this);

    $.ajax({
      url: _base_url_ + "classes/Master.php?f=save_archive_admin",
      method: "POST",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      error: function(err){
        console.log(err);
        alert_toast("Ocurrió un error.", 'error');
        end_loader();
      },
      success: function(resp){
        if (resp.status == 'success') {
          location.href = _base_url_ + "admin/archives/index.php";
        } else {
          alert_toast(resp.msg || "Ocurrió un error.", 'error');
          end_loader();
        }
      }
    });
  });
});
</script>

<?php include('../inc/footer.php'); ?>



