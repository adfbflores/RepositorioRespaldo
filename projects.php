<?php
// Determinar la paginación
$limit = 10;
$page = isset($_GET['p']) ? $_GET['p'] : 1;
$offset = 10 * ($page - 1);
$paginate = " LIMIT {$limit} OFFSET {$offset}";

// Verificar si hay una búsqueda
$isSearch = isset($_GET['q']) ? "&q={$_GET['q']}" : "";
$search = "";

// Si hay búsqueda, construir la cláusula WHERE correspondiente
if (isset($_GET['q'])) {
    $keyword = $conn->real_escape_string($_GET['q']);
    $search = " AND (title LIKE '%{$keyword}%' OR abstract LIKE '%{$keyword}%' OR members LIKE '%{$keyword}%' OR curriculum_id IN (SELECT id FROM curriculum_list WHERE name LIKE '%{$keyword}%' OR description LIKE '%{$keyword}%') OR curriculum_id IN (SELECT id FROM curriculum_list WHERE department_id IN (SELECT id FROM department_list WHERE name LIKE '%{$keyword}%' OR description LIKE '%{$keyword}%'))) ";
}

// Consultar la cantidad total de registros
$countAllQuery = $conn->query("SELECT * FROM archive_list WHERE `status` = 1 {$search}");
$countAll = $countAllQuery->num_rows;
$pages = ceil($countAll / $limit);

// Consultar los archivos con paginación y búsqueda
$archivesQuery = $conn->query("SELECT * FROM archive_list WHERE `status` = 1 {$search} ORDER BY UNIX_TIMESTAMP(date_created) DESC {$paginate}");

?>

<div class="content py-2">
    <div class="col-12">
        <div class="card">
            <div class="card-body rounded-0">
                <h2>Documentos</h2>
                <hr class="">
                <?php if (!empty($isSearch)) : ?>
                    <h3 class="text-center"><b>Resultados de búsqueda para "<?= $keyword ?>"</b></h3>
                <?php endif ?>
                <div class="list-group">
                    <?php while ($row = $archivesQuery->fetch_assoc()) : ?>
                        <?php
                        // Eliminar etiquetas HTML y decodificar entidades HTML en el resumen del archivo
                        $row['abstract'] = strip_tags(html_entity_decode($row['abstract']));
                        ?>
                        <a href="./?page=view_archive&id=<?= $row['id'] ?>" class="text-decoration-none text-dark list-group-item list-group-item-action">
                            <div class="row">
                                <div class="col-lg-4 col-md-5 col-sm-12 text-center">
                                    <img src="<?= validate_image($row['banner_path']) ?>" class="banner-img img-fluid " alt="Banner Image">
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
                        <div class="col-md-6"><span class="text-muted">Mostrando <?= $archivesQuery->num_rows ?></span></div>
                        <div class="col-md-6">
                            <ul class="pagination pagination-sm m-0 float-right">
                                <li class="page-item"><a class="page-link" href="./?page=projects<?= $isSearch ?>&p=<?= $page - 1 ?>" <?= $page == 1 ? 'disabled' : '' ?>>«</a></li>
                                <?php for ($i = 1; $i <= $pages; $i++) : ?>
                                    <li class="page-item"><a class="page-link <?= $page == $i ? 'active' : '' ?>" href="./?page=projects<?= $isSearch ?>&p=<?= $i ?>"><?= $i ?></a></li>
                                <?php endfor; ?>
                                <li class="page-item"><a class="page-link" href="./?page=projects<?= $isSearch ?>&p=<?= $page + 1 ?>" <?= $page == $pages ? 'disabled' : '' ?>>»</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
