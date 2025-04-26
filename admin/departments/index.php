<?php
// Inclusión segura desde cualquier subcarpeta
require_once($_SERVER['DOCUMENT_ROOT'] . '/Repositoriotesis/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Repositoriotesis/admin/inc/header.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Repositoriotesis/admin/inc/navigation.php');

// Consulta a la base de datos
$qry = $conn->query("SELECT d.*, d.date_created as dc 
                     FROM department_list d 
                     ORDER BY UNIX_TIMESTAMP(d.date_created) DESC");
?>

  <div class="content-header">
    <div class="container-fluid">
      <h1 class="m-0">Lista de Facultades</h1>
      <hr>
      <div class="text-right mb-2">
        <button class="btn btn-primary btn-sm rounded-0" id="create_new">
          <i class="fa fa-plus"></i> Nuevo
        </button>
      </div>
      <div class="card card-outline card-primary">
        <div class="card-body">
          <table class="table table-bordered table-hover text-sm table-striped">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th>Fecha de creación</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th class="text-center">Acción</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; while($row = $qry->fetch_assoc()): ?>
                <tr>
                  <td class="text-center"><?php echo $i++; ?></td>
                  <td><?php echo date("Y-m-d H:i", strtotime($row['dc'])) ?></td>
                  <td><?php echo htmlspecialchars($row['name']) ?></td>
                  <td><?php echo htmlspecialchars($row['description']) ?></td>
                  <td class="text-center">
                    <?php if($row['status'] == 1): ?>
                      <span class="badge badge-success rounded-pill">Activo</span>
                    <?php else: ?>
                      <span class="badge badge-danger rounded-pill">Inactivo</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <div class="dropdown">
                      <button class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Acción</button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?= $row['id'] ?>">Editar</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item delete_data text-danger" href="javascript:void(0)" data-id="<?= $row['id'] ?>">Eliminar</a>
                      </div>
                    </div>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

<script>
  $(document).ready(function(){
    $('#create_new').click(function(){
      uni_modal("Nueva Facultad", "departments/manage.php", "mid-large");
    });

    $('.edit_data').click(function(){
      uni_modal("Editar Facultad", "departments/manage.php?id=" + $(this).attr('data-id'), "mid-large");
    });

    $('.delete_data').click(function(){
      _conf("¿Estás seguro de eliminar esta facultad?", "delete_department", [$(this).attr('data-id')]);
    });

    $('.table').dataTable();
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
        alert_toast("Ocurrió un error", "error");
        end_loader();
      },
      success: function(resp){
        if(resp.status === 'success'){
          location.reload();
        } else {
          alert_toast("Ocurrió un error", "error");
          end_loader();
        }
      }
    });
  }
</script>

