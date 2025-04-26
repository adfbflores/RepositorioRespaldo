<?php
require_once('../config.php');
require_once('inc/header.php');
require_once('inc/navigation.php');
require_once('inc/topBarNav.php');
?>

<div class="wrapper">
  <div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
      <div class="container-fluid">
        <h1 class="m-0">Panel de Control</h1>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <?php
          $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
          $file = $page . '.php';

          if (file_exists($file)) {
              include $file;
          } else if ($page === 'dashboard') {
              // Mostrar resumen si no hay ?page (dashboard)
              ?>
              <div class="row">
                <!-- Facultades -->
                <div class="col-lg-3 col-6">
                  <div class="small-box bg-primary">
                    <div class="inner">
                      <h3>
                      <?php
                        $q1 = $conn->query("SELECT COUNT(*) as total FROM department_list");
                        echo $q1->fetch_assoc()['total'];
                      ?>
                      </h3>
                      <p>Lista de Facultades</p>
                    </div>
                    <div class="icon"><i class="fas fa-th-list"></i></div>
                    <a href="?page=departments/index" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>

                <!-- Carreras -->
                <div class="col-lg-3 col-6">
                  <div class="small-box bg-info">
                    <div class="inner">
                      <h3>
                      <?php
                        $q2 = $conn->query("SELECT COUNT(*) as total FROM curriculum_list");
                        echo $q2->fetch_assoc()['total'];
                      ?>
                      </h3>
                      <p>Lista de Carreras</p>
                    </div>
                    <div class="icon"><i class="fas fa-scroll"></i></div>
                    <a href="?page=curriculum/index" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>

                <!-- Verificados -->
                <div class="col-lg-3 col-6">
                  <div class="small-box bg-success">
                    <div class="inner">
                      <h3>
                      <?php
                        $q3 = $conn->query("SELECT COUNT(*) as total FROM archive_list WHERE status = 1");
                        echo $q3->fetch_assoc()['total'];
                      ?>
                      </h3>
                      <p>Archivos verificados</p>
                    </div>
                    <div class="icon"><i class="fas fa-check-circle"></i></div>
                    <a href="?page=archives/index" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>

                <!-- No verificados -->
                <div class="col-lg-3 col-6">
                  <div class="small-box bg-danger">
                    <div class="inner">
                      <h3>
                      <?php
                        $q4 = $conn->query("SELECT COUNT(*) as total FROM archive_list WHERE status = 0");
                        echo $q4->fetch_assoc()['total'];
                      ?>
                      </h3>
                      <p>Archivos no verificados</p>
                    </div>
                    <div class="icon"><i class="fas fa-times-circle"></i></div>
                    <a href="?page=archives/index" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>

                <!-- Estudiantes Verificados -->
                <div class="col-lg-3 col-6">
                  <div class="small-box bg-success">
                    <div class="inner">
                      <h3>
                      <?php
                        $q3 = $conn->query("SELECT COUNT(*) as total FROM student_list WHERE status = 1");
                        echo $q3->fetch_assoc()['total'];
                      ?>
                      </h3>
                      <p>Estudiantes verificados</p>
                    </div>
                    <div class="icon"><i class="fas fa-check-circle"></i></div>
                    <a href="?page=students/index" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>

                <!-- Estudiantes No verificados -->
                <div class="col-lg-3 col-6">
                  <div class="small-box bg-danger">
                    <div class="inner">
                      <h3>
                      <?php
                        $q4 = $conn->query("SELECT COUNT(*) as total FROM student_list WHERE status = 0");
                        echo $q4->fetch_assoc()['total'];
                      ?>
                      </h3>
                      <p>Estudiantes no verificados</p>
                    </div>
                    <div class="icon"><i class="fas fa-times-circle"></i></div>
                    <a href="?page=students/index" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>

                <!-- Transparencia -->
                <div class="col-lg-3 col-6">
                  <div class="small-box bg-secondary">
                    <div class="inner">
                      <h3>
                      <?php
                        $q5 = $conn->query("SELECT COUNT(*) as total FROM transparency_docs");
                        echo $q5->fetch_assoc()['total'];
                      ?>
                      </h3>
                      <p>Documentos de Transparencia</p>
                    </div>
                    <div class="icon"><i class="fas fa-file-alt"></i></div>
                    <a href="transparency_manage.php" class="small-box-footer">Gestionar <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>
              </div>
              <?php
          } else {
              echo "<h4>Página no encontrada: <code>{$page}</code></h4>";
          }
        ?>
      </div>
    </section>
  </div>
</div>

<?php include('inc/footer.php'); ?>

