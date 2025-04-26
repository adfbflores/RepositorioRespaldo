<?php
require_once('config.php');
include_once('inc/header.php');

$categories = [
  'Aranceles y Matrículas',
  'Escala de Remuneraciones',
  'Estados Financieros Auditados',
  'Plan Estratégico 2021–2026',
  'Plan Estratégico 2016–2021',
  'Presupuesto Anual',
  'Rendición de Cuentas'
];

// Determina la categoría seleccionada por GET
$current = $_GET['categoria'] ?? $categories[0];

// Consulta documentos de la categoría seleccionada
$qry = $conn->prepare("SELECT * FROM transparency_docs WHERE category = ? ORDER BY uploaded_at DESC");
$qry->bind_param("s", $current);
$qry->execute();
$result = $qry->get_result();
$docs = $result->fetch_all(MYSQLI_ASSOC);
?>

<style>
  .transparency-layout {
    display: flex;
    flex-direction: row;
    gap: 2rem;
  }

  .doc-list {
    flex: 2;
  }

  .category-menu {
    flex: 1;
    border-left: 4px solid #28a745;
    padding-left: 1rem;
  }

  .category-menu a {
    display: block;
    padding: 0.8rem 1rem;
    border: 1px solid #dee2e6;
    text-decoration: none;
    color: #333;
    background: #f8f9fa;
    margin-bottom: 5px;
  }

  .category-menu a.active {
    background: #fff;
    font-weight: bold;
    border-left: 5px solid #28a745;
  }

  .doc-item {
    display: flex;
    align-items: center;
    padding: 0.6rem 0;
  }

  .doc-item i {
    font-size: 1.3rem;
    color: #007bff;
    margin-right: 0.8rem;
  }

  .highlight-box {
    background: #fff;
    border-radius: 8px;
    padding: 1rem;
    box-shadow: 0 1px 4px rgba(0,0,0,0.1);
    margin-bottom: 1rem;
  }

  .highlight-box h5 {
    margin: 0;
    font-weight: bold;
    color: #007bff;
  }

  .highlight-box span {
    display: block;
    color: #555;
    margin-top: 5px;
  }
</style>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Transparencia</h4>
    <a href="<?= base_url ?>index.php" class="btn btn-secondary">
      <i class="fa fa-arrow-left"></i> Regresar al inicio
    </a>
  </div>
  <div class="transparency-layout">

    <!-- Lista de documentos -->
    <div class="doc-list">
      <div class="highlight-box">
        <h5><?= htmlspecialchars($current) ?></h5>
        <span>Ver PDF</span>
      </div>

      <?php if (count($docs) > 0): ?>
        <?php foreach ($docs as $doc): ?>
          <div class="doc-item">
            <i class="fa fa-download"></i>
            <a href="<?= base_url ?>uploads/transparencia/<?= $doc['filepath'] ?>" target="_blank">
              <?= htmlspecialchars($doc['filename']) ?>
            </a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No hay documentos disponibles en esta categoría.</p>
      <?php endif; ?>
    </div>

    <!-- Menú de categorías -->
    <div class="category-menu">
      <?php foreach ($categories as $cat): ?>
        <a href="transparency.php?categoria=<?= urlencode($cat) ?>"
           class="<?= $cat == $current ? 'active' : '' ?>">
          <?= $cat ?>
        </a>
      <?php endforeach; ?>
    </div>

  </div>
</div>

<?php include_once('inc/footer.php'); ?>
