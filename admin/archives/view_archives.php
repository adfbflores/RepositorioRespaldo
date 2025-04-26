<?php
require_once('../../config.php');
require_once('../inc/header.php');
require_once('../inc/navigation.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<h4>No se especificó ninguna tesis.</h4>";
    exit;
}

$id = $_GET['id'];
$qry = $conn->query("SELECT a.*, c.name AS curriculum_name FROM archive_list a INNER JOIN curriculum_list c ON a.curriculum_id = c.id WHERE a.id = '{$id}'");

if ($qry->num_rows <= 0) {
    echo "<h4>Tesis no encontrada.</h4>";
    exit;
}

$archive = $qry->fetch_assoc();
?>

<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid py-4">
      <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h3 class="card-title">Detalles del Proyecto</h3>
          <a href="<?= base_url ?>admin/archives/index.php" class="btn btn-sm btn-secondary">
            <i class="fa fa-arrow-left"></i> Regresar
          </a>
        </div>
        <div class="card-body">
          <dl class="row">
            <dt class="col-sm-4">Código de Archivo:</dt>
            <dd class="col-sm-8"><?= htmlspecialchars($archive['archive_code']) ?></dd>

            <dt class="col-sm-4">Título:</dt>
            <dd class="col-sm-8"><?= htmlspecialchars($archive['title']) ?></dd>

            <dt class="col-sm-4">Integrantes (Autores):</dt>
            <dd class="col-sm-8"><?= htmlspecialchars($archive['members']) ?></dd>

            <dt class="col-sm-4">Carrera:</dt>
            <dd class="col-sm-8"><?= htmlspecialchars($archive['curriculum_name']) ?></dd>

            <dt class="col-sm-4">Año:</dt>
            <dd class="col-sm-8"><?= htmlspecialchars($archive['year']) ?></dd>

            <dt class="col-sm-4">Resumen:</dt>
            <dd class="col-sm-8">
              <p><?= nl2br(htmlspecialchars($archive['abstract'])) ?></p>
            </dd>

            <dt class="col-sm-4">Archivo de la Tesis:</dt>
            <dd class="col-sm-8">
              <?php if (!empty($archive['file_path']) && file_exists(base_app . $archive['file_path'])): ?>
                <a href="<?= base_url . $archive['file_path'] ?>" target="_blank" class="btn btn-sm btn-primary">
                  <i class="fa fa-file-pdf"></i> Ver/Descargar Tesis
                </a>
              <?php else: ?>
                <span class="text-danger">Archivo no disponible</span>
              <?php endif; ?>
            </dd>
          </dl>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include('../inc/footer.php'); ?>
