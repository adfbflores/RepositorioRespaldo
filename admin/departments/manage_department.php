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

<div class="container-fluid">
    <form action="" id="department-form">
        <input type="hidden" name="id" value="<?= isset($id) ? htmlspecialchars($id) : '' ?>">
        <div class="form-group">
            <label for="name" class="control-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control form-control-border" placeholder="Escriba el nombre" value="<?= isset($name) ? htmlspecialchars($name) : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="description" class="control-label">Descripción</label>
            <textarea rows="3" name="description" id="description" class="form-control form-control-border" placeholder="Escriba la descripción." required><?= isset($description) ? htmlspecialchars($description) : '' ?></textarea>
        </div>
        <div class="form-group">
            <label for="status" class="control-label">Estado</label>
            <select name="status" id="status" class="form-control form-control-border" required>
                <option value="1" <?= isset($status) && $status == 1 ? "selected" : "" ?>>Activo</option>
                <option value="0" <?= isset($status) && $status == 0 ? "selected" : "" ?>>Inactivo</option>
            </select>
        </div>
    </form>
</div>
<script>
    $(function() {
        // Manejar la presentación del formulario
        $('#uni_modal #department-form').submit(function(e) {
            e.preventDefault(); // Prevenir el comportamiento por defecto del formulario
            var _this = $(this);
            $('.pop-msg').remove(); // Eliminar mensajes anteriores
            var el = $('<div>').addClass("pop-msg alert").hide();

            start_loader(); // Iniciar cargador

            // Realizar la solicitud AJAX
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_department",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                dataType: 'json',
                error: function(err) {
                    console.log(err);
                    alert_toast("Ocurrió un error", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (resp.status === 'success') {
                        location.reload();
                    } else if (resp.msg) {
                        el.addClass("alert-danger").text(resp.msg);
                        _this.prepend(el);
                    } else {
                        el.addClass("alert-danger").text("Ocurrió un error debido a una razón desconocida.");
                        _this.prepend(el);
                    }
                    el.show('slow');
                    end_loader();
                }
            });
        });
    });
</script>
