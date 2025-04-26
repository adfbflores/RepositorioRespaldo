<?php
require_once('../config.php');
require_once('inc/header.php');

$id = $_GET['id'] ?? 0;
$q = $conn->prepare("SELECT * FROM transparency_docs WHERE id = ?");
$q->bind_param('i', $id);
$q->execute();
$doc = $q->get_result()->fetch_assoc();

$categories = [/* mismas 7 categorías */];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $newname = $_POST['filename'];
  $newcat = $_POST['category'];
  $stmt = $conn->prepare("UPDATE transparency_docs SET filename = ?, category = ? WHERE id = ?");
  $stmt->bind_param("ssi", $newname, $newcat, $id);
  $stmt->execute();
  $_SESSION['flashdata']['success'] = 'Documento actualizado.';
  redirect('transparency_manage.php');
}
?>

<div class="container mt-4">
  <h4>Editar Documento</h4>
  <form method="POST">
    <div class="form-group">
      <label>Nombre del Archivo:</label>
      <input type="text" name="filename" value="<?= htmlspecialchars($doc['filename']) ?>" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Categoría:</label>
      <select name="category" class="form-control">
        <?php foreach ($categories as $cat): ?>
          <option <?= $cat === $doc['category'] ? 'selected' : '' ?>><?= $cat ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <button class="btn btn-primary">Guardar Cambios</button>
    <a href="transparency_manage.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
