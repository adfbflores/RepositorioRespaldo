<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Repositoriotesis/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Repositoriotesis/admin/inc/header.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Repositoriotesis/admin/inc/navigation.php');
?>

<div class="content-wrapper">
  <?php if($_settings->chk_flashdata('success')): ?>
    <script>
      alert_toast("<?= $_settings->flashdata('success') ?>", 'success');
    </script>
  <?php endif; ?>

  <style>
    .img-avatar {
      width: 45px;
      height: 45px;
      object-fit: cover;
      object-position: center center;
      border-radius: 100%;
    }
  </style>

  <div class="card card-outline card-primary">
    <div class="card-header">
      <h3 class="card-title">Lista de Usuarios</h3>
      <div class="card-tools">
        <a href="<?= base_url ?>admin/?page=user/manage_user" class="btn btn-flat btn-primary">
          <span class="fas fa-plus"></span> Nuevo
        </a>
      </div>
    </div>
    <div class="card-body">
      <div class="container-fluid">
        <table class="table table-hover table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Avatar</th>
              <th>Nombre</th>
              <th>Nombre de usuario</th>
              <th>Tipo de usuario</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $i = 1;
              $qry = $conn->query("SELECT *, CONCAT(firstname, ' ', lastname) AS name FROM `users` WHERE id != 1 ORDER BY name ASC");
              while($row = $qry->fetch_assoc()):
            ?>
              <tr>
                <td class="text-center"><?= $i++; ?></td>
                <td class="text-center">
                  <img src="<?= validate_image($row['avatar']) ?>" class="img-avatar img-thumbnail p-0 border-2" alt="user_avatar">
                </td>
                <td><?= ucwords($row['name']) ?></td>
                <td><p class="m-0 truncate-1"><?= $row['username'] ?></p></td>
                <td><p class="m-0"><?= $row['type'] == 1 ? "Administrador" : "Usuario" ?></p></td>
                <td class="text-center">
                  <div class="btn-group">
                    <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                      Acción
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a class="dropdown-item" href="<?= base_url ?>admin/?page=user/manage_user&id=<?= $row['id'] ?>">
                        <span class="fa fa-edit text-primary"></span> Editar
                      </a>
                      <div class="dropdown-divider"></div>
                      <?php if($row['status'] != 1): ?>
                        <a class="dropdown-item verify_user" href="javascript:void(0)" data-id="<?= $row['id'] ?>" data-name="<?= $row['username'] ?>">
                          <span class="fa fa-check text-primary"></span> Verificar
                        </a>
                        <div class="dropdown-divider"></div>
                      <?php endif; ?>
                      <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?= $row['id'] ?>">
                        <span class="fa fa-trash text-danger"></span> Eliminar
                      </a>
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
    $('.delete_data').click(function(){
      _conf("¿Está seguro de eliminar este usuario de forma permanente?", "delete_user", [$(this).attr('data-id')]);
    });

    $('.verify_user').click(function(){
      _conf("¿Estás seguro de verificar a " + $(this).data('name') + "?", "verify_user", [$(this).data('id')]);
    });

    $('.table td, .table th').addClass('py-1 px-2 align-middle');

    $('.table').dataTable({
      columnDefs: [
        { orderable: false, targets: 5 }
      ]
    });
  });

  function delete_user(id){
    start_loader();
    $.ajax({
      url: _base_url_ + "classes/Users.php?f=delete",
      method: "POST",
      data: { id: id },
      dataType: "json",
      error: function(err){
        console.log(err);
        alert_toast("Ocurrió un error.", 'error');
        end_loader();
      },
      success: function(resp){
        if (resp.status == 'success') {
          location.reload();
        } else {
          alert_toast("Ocurrió un error.", 'error');
          end_loader();
        }
      }
    });
  }

  function verify_user(id){
    start_loader();
    $.ajax({
      url: _base_url_ + "classes/Users.php?f=verify_user",
      method: "POST",
      data: { id: id },
      dataType: "json",
      error: function(err){
        console.log(err);
        alert_toast("Ocurrió un error.", 'error');
        end_loader();
      },
      success: function(resp){
        if (resp.status == 'success') {
          location.reload();
        } else {
          alert_toast("Ocurrió un error.", 'error');
          end_loader();
        }
      }
    });
  }
</script>

<?php include(base_app . 'admin/inc/footer.php'); ?>

