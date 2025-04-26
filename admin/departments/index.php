<?php
require_once('../../config.php');
require_once('../inc/header.php');
require_once('../inc/navigation.php');
?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1 class="m-0">Lista de Facultades</h1>
      <a href="javascript:void(0)" id="create_new" class="btn btn-primary btn-sm">
        <i class="fa fa-plus"></i> Nuevo
      </a>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <?php
        $qry = $conn->query("SELECT * FROM department_list ORDER BY name ASC");
        if (!$qry) {
          echo "<div class='alert alert-danger'>Error al consultar department_list: " . $conn->error . "</div>";
        }
      ?>
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Fecha de creación</th>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Estado</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($qry): $i = 1; while($row = $qry->fetch_assoc()): ?>
              <tr>
                <td><?= $i++ ?></td>
                <td><?= date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td class="text-center">
                  <?php
                    if ($row['status'] == 1)
                      echo '<span class="badge badge-success">Activo</span>';
                    else
                      echo '<span class="badge badge-secondary">Inactivo</span>';
                  ?>
                </td>
                <td class="text-center">
                  <button class="btn btn-sm btn-primary edit_data" data-id="<?= $row['id'] ?>"><i class="fa fa-edit"></i></button>
                  <button class="btn btn-sm btn-danger delete_data" data-id="<?= $row['id'] ?>"><i class="fa fa-trash"></i></button>
                </td>
              </tr>
            <?php endwhile; endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<script>
$(document).ready(function(){
  $('#create_new').click(function(){
    uni_modal("Nueva Facultad", "departments/manage_department.php");
  });

  $('.edit_data').click(function(){
    uni_modal("Editar Facultad", "departments/manage_department.php?id=" + $(this).attr('data-id'));
  });

  $('.delete_data').click(function(){
    _conf("¿Estás seguro de eliminar esta facultad?", "delete_department", [$(this).attr('data-id')]);
  });

  $('.table').DataTable({
    columnDefs: [{ orderable: false, targets: [5] }]
  });
});

function delete_department(id){
  start_loader();
  $.ajax({
    url: _base_url_ + "classes/Master.php?f=delete_department",
    method: "POST",
    data: { id: id },
    dataType: "json",
    error: err => {
      console.error(err);
      alert_toast("Ocurrió un error.", 'error');
      end_loader();
    },
    success: function(resp){
      if (resp.status == 'success'){
        location.reload();
      } else {
        alert_toast("Ocurrió un error.", 'error');
        end_loader();
      }
    }
  });
}
</script>

<?php include('../inc/footer.php'); ?>
