<?php
require_once('../config.php');

$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT filepath FROM transparency_docs WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();

if ($res) {
  $path = '../uploads/transparencia/' . $res['filepath'];
  if (file_exists($path)) unlink($path);
  $conn->query("DELETE FROM transparency_docs WHERE id = $id");
  $_SESSION['flashdata']['success'] = 'Documento eliminado.';
}

redirect('transparency_manage.php');
