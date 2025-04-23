<?php
require_once('../../config.php');

// Verificar si el parámetro 'id' está presente en la solicitud GET
if (isset($_GET['id'])) {
    // Usar consultas preparadas para evitar inyección SQL
    $stmt = $conn->prepare("SELECT * FROM `department_list` WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró algún resultado
    if ($result->num_rows > 0) {
        // Obtener los resultados como un array asociativo
        $res = $result->fetch_assoc();
        foreach ($res as $k => $v) {
            // Asignar variables dinámicas
            if (!is_numeric($k)) {
                $$k = $v;
            }
        }
    }
    $stmt->close();
}
?>
<style>
    /* Estilo para ocultar el pie de página del modal */
    #uni_modal .modal-footer {
        display: none !important;
    }
</style>

<div class="container-fluid">
    <dl>
        <dt class="text-muted">Nombre</dt>
        <dd class='pl-4 fs-4 fw-bold'><?= isset($name) ? htmlspecialchars($name) : '' ?></dd>
        <dt class="text-muted">Descripción</dt>
        <dd class='pl-4'>
            <p class=""><small><?= isset($description) ? htmlspecialchars($description) : '' ?></small></p>
        </dd>
        <dt class="text-muted">Estado</dt>
        <dd class='pl-4'>
            <?php if (isset($status)): ?>
                <?php switch ($status):
                    case '1': ?>
                        <span class='badge badge-success badge-pill'>Activo</span>
                        <?php break; ?>
                    <?php case '0': ?>
                        <span class='badge badge-secondary badge-pill'>Inactivo</span>
                        <?php break; ?>
                <?php endswitch; ?>
            <?php endif; ?>
        </dd>
    </dl>
    <div class="col-12 text-right">
        <button class="btn btn-flat btn-sm btn-dark" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
    </div>
</div>
