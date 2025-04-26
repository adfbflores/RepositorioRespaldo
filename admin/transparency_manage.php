<?php
require_once('../config.php');
require_once('inc/header.php');

$categories = [
  'Aranceles y Matrículas',
  'Escala de Remuneraciones',
  'Estados Financieros Auditados',
  'Plan Estratégico 2021–2026',
  'Plan Estratégico 2016–2021',
  'Presupuesto Anual',
  'Rendición de Cuentas'
];

// Guardar archivos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $category = $_POST['category'] ?? '';
  if (!in_array($category, $categories)) {
    $_SESSION['flashdata']['error'] = 'Categoría inválida.';
  } elseif (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['pdf'];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    if (strtolower($ext) !== 'pdf') {
      $_SESSION['flashdata']['error'] = 'Solo se permiten archivos PDF.';
    } else {
      $upload_dir = '../uploads/transparencia/';
      if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
      $newname = uniqid() . '_' . basename($file['name']);
      $destination = $upload_dir . $newname;
      if (move_uploaded_file($file['tmp_name'], $destination)) {
        $stmt = $conn->prepare("INSERT INTO transparency_docs (category, filename, filepath) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $category, $file['name'], $newname);
        $stmt->execute();
        $_SESSION['flashdata']['success'] = 'Archivo subido exitosamente.';
      } else {
        $_SESSION['flashdata']['error'] = 'Error al mover el archivo.';
      }
    }
  } else {
    $_SESSION['flashdata']['error'] = 'No se seleccionó un archivo.';
  }
  redirect('admin/transparency_manage.php');
}
?>

<div class="container-fluid">
  <h4 class="mt-4">Gestión de Documentos de Transparencia</h4>

  <?php if (isset($_SESSION['flashdata']['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['flashdata']['success']; unset($_SESSION['flashdata']['success']); ?></div>
  <?php elseif (isset($_SESSION['flashdata']['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['flashdata']['error']; unset($_SESSION['flashdata']['error']); ?></div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data" class="mb-4">
    <div class="form-group">
      <label for="category">Categoría:</label>
      <select name="category" class="form-control" required>
        <option value="">Seleccione...</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= $cat ?>"><?= $cat ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label for="pdf">Archivo PDF:</label>
      <input type="file" name="pdf" accept="application/pdf" class="form-control-file" required>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Subir Documento</button>
  </form>

  <hr>

  <h5>Documentos Subidos</h5>
<table class="table table-bordered table-sm">
  <thead>
    <tr>
      <th>#</th>
      <th>Categoría</th>
      <th>Nombre del Archivo</th>
      <th>Fecha</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $res = $conn->query("SELECT * FROM transparency_docs ORDER BY uploaded_at DESC");
      $i = 1;
      while ($row = $res->fetch_assoc()):
    ?>
    <tr>
      <td><?= $i++ ?></td>
      <td><?= htmlspecialchars($row['category']) ?></td>
      <td><?= htmlspecialchars($row['filename']) ?></td>
      <td><?= date('d/m/Y', strtotime($row['uploaded_at'])) ?></td>
      <td>
        <a href="<?= base_url ?>uploads/transparencia/<?= $row['filepath'] ?>" target="_blank" class="btn btn-sm btn-primary">Ver</a>
        <a href="transparency_edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
        <a href="transparency_delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este archivo?')">Eliminar</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>
</div>
