<?php
require_once('../../config.php');

if (!isset($_GET['id']) || !isset($_GET['status'])) {
    echo "<div class='alert alert-danger'>Faltan parámetros requeridos.</div>";
    exit;
}

$id = (int) $_GET['id'];
$status = (int) $_GET['status'];
$valid_status = [0, 1];

if (!in_array($status, $valid_status)) {
    echo "<div class='alert alert-danger'>Estado inválido.</div>";
    exit;
}

$q = $conn->prepare("SELECT * FROM archive_list WHERE id = ?");
$q->bind_param("i", $id);
$q->execute();
$result = $q->get_result();

if ($result->num_rows < 1) {
    echo "<div class='alert alert-warning'>No se encontró el archivo.</div>";
    exit;
}

$data = $result->fetch_assoc();
?>

<div class="container-fluid">
    <form action="" id="update-status-form">
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="hidden" name="status" value="<?= $status ?>">
        <p>¿Está seguro que desea <strong><?= $status == 1 ? 'PUBLICAR' : 'DESPUBLICAR' ?></strong> el archivo <strong><?= htmlspecialchars($data['title']) ?></strong>?</p>
    </form>
</div>

<script>
    $(function(){
        $('#update-status-form').submit(function(e){
            e.preventDefault();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=update_archive_status",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                error: err => {
                    console.error(err);
                    alert_toast("Ocurrió un error", 'error');
                    end_loader();
                },
                success: function(resp){
                    if(resp.status == 'success'){
                        alert_toast("Estado actualizado", 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        alert_toast("No se pudo actualizar", 'error');
                    }
                    end_loader();
                }
            });
        });
    });
</script>
