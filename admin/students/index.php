<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Repositoriotesis/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Repositoriotesis/admin/inc/header.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Repositoriotesis/admin/inc/navigation.php');
?>


  <div class="content-header">
    <div class="container-fluid">
      <h1 class="m-0">Lista de Estudiantes</h1>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <?php
        $qry = $conn->query("SELECT * FROM student_list ORDER BY lastname ASC, firstname ASC");
        if (!$qry) {
          echo "<div class='alert alert-danger'>Error al consultar student_list: " . $conn->error . "</div>";
        }
      ?>
      <style>
        .img-avatar {
          width: 45px;
          height: 45px;
          object-fit: cover;
          object-position: center center;
          border-radius: 100%;
          display: inline-block;
        }
      </style>
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Avatar</th>
              <th>Nombre</th>
              <th>Correo</th>
              <th>Estado</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($qry): $i = 1; while($row = $qry->fetch_assoc()): ?>
              <tr>
                <td><?= $i++ ?></td>
                <td>
                  <img src="<?= validate_image($row['avatar'] ?? '') ?>" alt="Avatar" class="img-avatar"
                    onerror="this.src='<?= base_url ?>dist/img/default-avatar.png'">
                </td>
                <td><?= $row['lastname'] ?>, <?= $row['firstname'] ?></td>
                <td><?= $row['email'] ?></td>
                <td class="text-center">
                  <?php
                    if ($row['status'] == 1)
                      echo '<span class="badge badge-success">Activo</span>';
                    else
                      echo '<span class="badge badge-secondary">Inactivo</span>';
                  ?>
                </td>
                <td class="text-center">
                  <button class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></button>
                  <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                </td>
              </tr>
            <?php endwhile; endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>

<?php include('../inc/footer.php'); ?>


