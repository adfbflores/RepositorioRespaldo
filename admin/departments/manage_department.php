<?php
require_once('../../config.php');

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$faculty = ['name' => '', 'description' => '', 'status' => 1];

if ($id > 0) {
    $query = $conn->prepare("SELECT * FROM department_list WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        $faculty = $result->fetch_assoc();
    }
}
?>

<div class="container-fluid">
    <form id="faculty-form">
        <input type="hidden" name="id" value="<?= $id ?>">
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" required class="form-control form-control-sm" value="<?= htmlspecialchars($faculty['name']) ?>">
        </div>
        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea name="description" rows="3" class="form-control form-control-sm"><?= htmlspecialchars($faculty['description']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="status">Estado</label>
            <select name="status" class="form-control form-control-sm">
                <option value="1" <?= $faculty['status'] == 1 ? 'selected' : '' ?>>Activo</option>
                <option value="0" <?= $faculty['status'] == 0 ? 'selected' : '' ?>>Inactivo</option>
            </select>
        </div>
    </form>
</div>

<script>
$(function(){
    $('#faculty-form').submit(function(e){
        e.preventDefault();
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=save_department",
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            error: err => {
                console.error(err);
                alert_toast("Ocurrió un error", 'error');
                end_loader();
            },
            success: function(resp){
                if(resp.status === 'success'){
                    alert_toast("Guardado correctamente", 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    alert_toast("No se pudo guardar", 'error');
                    end_loader();
                }
            }
        });
    });
});
</script>

<div class="text-right px-2">
    <button class="btn btn-primary btn-sm" type="submit" form="faculty-form">Guardar</button>
    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancelar</button>
</div>
