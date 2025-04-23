<?php
// Verificar si se ha proporcionado un ID
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM curriculum_list WHERE `status` = 1 AND id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            // Validar si la clave no es numérica para evitar valores no deseados en el arreglo
            if (!is_numeric($k)) {
                $curriculum[$k] = $v;
            }
        }
    } else {
        echo "<script> alert('ID de materia desconocido'); location.replace('./') </script>";
        exit; // Salir del script después de redireccionar
    }
} else {
    echo "<script> alert('Se requiere ID de la materia'); location.replace('./') </script>";
    exit; // Salir del script después de redireccionar
}
?>
<div class="content py-2">
    <div class="col-12">
        <div class="card">
            <div class="card-body rounded-0">
                <h2>Archivos de <?= isset($curriculum['name']) ? $curriculum['name'] : "" ?></h2>
                <p><small><?= isset($curriculum['description']) ? $curriculum['description'] : "" ?></small></p>
                <hr class="">
                <?php
                // Definir el ID y la paginación
                $id = isset($_GET['id']) ? $_GET['id'] : '';
                $limit = 10;
                $page = isset($_GET['p']) ? $_GET['p'] : 1;
                $offset = 10 * ($page - 1);
                $paginate = " LIMIT {$limit} OFFSET {$offset}";
                $wherecid = " AND curriculum_id = '{$id}' ";

                // Consultar la lista de estudiantes
                $students = $conn->query("SELECT * FROM `student_list` WHERE id IN (SELECT student_id FROM archive_list WHERE `status` = 1 {$wherecid})");
                $student_arr = array_column($students->fetch_all(MYSQLI_ASSOC), 'email', 'id');

                // Contar la cantidad total de archivos
                $count_all = $conn->query("SELECT * FROM archive_list WHERE `status` = 1 {$wherecid}")->num_rows;
                $pages = ceil($count_all / $limit);

                // Consultar los archivos con paginación
                $archives = $conn->query("SELECT * FROM archive_list WHERE `status` = 1 {$wherecid} ORDER BY UNIX_TIMESTAMP(date_created) DESC {$paginate}");
                ?>
                <div class="list-group">
                    <?php while ($row = $archives->fetch_assoc()) : ?>
                        <?php
                        // Eliminar etiquetas HTML y decodificar entidades HTML en el resumen del archivo
                        $row['abstract'] = strip_tags(html_entity_decode($row['abstract']));
                        ?>
                        <a href="./?page=view_archive&id=<?= $row['id'] ?>" class="text-decoration-none text-dark list-group-item list-group-item-action">
                            <div class="row">
                                <div class="col-lg-4 col-md-5 col-sm-12 text-center">
                                    <img src="<?= validate_image($row['banner_path']) ?>" class="banner-img img-fluid" alt="Banner Image">
                                </div>
                                <div class="col-lg-8 col-md-7 col-sm-12">
                                    <h3 class="text-blue"><b><?= $row['title'] ?></b></h3>
                                    <small class="text-muted">Por <b class="text-info"><?= isset($student_arr[$row['student_id']]) ? $student_arr[$row['student_id']] : "N/A" ?></b></small>
                                    <p class="truncate-5"><?= $row['abstract'] ?></p>
                                </div>
                            </div>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>
            <div class="card-footer clearfix rounded-0">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6"><span class="text-muted">Mostrando: <?= $archives->num_rows ?></span></div>
                        <div class="col-md-6">
                            <ul class="pagination pagination-sm m-0 float-right">
                                <li class="page-item"><a class="page-link" href="./?page=projects_per_curriculum&id=<?= $id ?>&p=<?= $page - 1 ?>" <?= $page == 1 ? 'disabled' : '' ?>>«</a></li>
                                <?php for ($i = 1; $i <= $pages; $i++) : ?>
                                    <li class="page-item"><a class="page-link <?= $page == $i ? 'active' : '' ?>" href="./?page=projects_per_curriculum&id=<?= $id ?>&p=<?= $i ?>"><?= $i ?></a></li>
                                <?php endfor; ?>
                                <li class="page-item"><a class="page-link" href="./?page=projects_per_curriculum&id=<?= $id ?>&p=<?= $page + 1 ?>" <?= $page == $pages || $pages <= 1 ? 'disabled' : '' ?>>»</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
