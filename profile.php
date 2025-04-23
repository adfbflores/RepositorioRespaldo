<?php
// Consulta para obtener la información del estudiante
$userQuery = $conn->query("SELECT s.*, d.name as department, c.name as curriculum, CONCAT(lastname, ', ', firstname, ' ', middlename) as fullname FROM student_list s INNER JOIN department_list d ON s.department_id = d.id INNER JOIN curriculum_list c ON s.curriculum_id = c.id WHERE s.id ='{$_settings->userdata('id')}'");

// Obtener el resultado de la consulta como un array asociativo
$userData = $userQuery->fetch_assoc();

// Asignar cada valor del array a una variable con su respectiva clave
foreach ($userData as $key => $value) {
    $$key = $value;
}
?>

<style>
    .student-img {
        object-fit: scale-down;
        object-position: center center;
        height: 200px;
        width: 200px;
    }
</style>

<div class="content py-4">
    <div class="card card-outline card-primary shadow rounded-0">
        <div class="card-header rounded-0">
            <h5 class="card-title">Tu información:</h5>
            <div class="card-tools">
                <a href="./?page=my_archives" class="btn btn-default bg-primary btn-flat"><i class="fa fa-archive"></i> Mis archivos</a>
                <a href="./?page=manage_account" class="btn btn-default bg-navy btn-flat"><i class="fa fa-edit"></i> Actualizar cuenta</a>
            </div>
        </div>
        <div class="card-body rounded-0">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-lg-4 col-sm-12">
                            <center>
                                <img src="<?= validate_image($avatar) ?>" alt="Student Image" class="img-fluid student-img bg-gradient-dark border">
                            </center>
                        </div>
                        <div class="col-lg-8 col-sm-12">
                            <dl>
                                <dt class="text-navy">Nombre del estudiante:</dt>
                                <dd class="pl-4"><?= ucwords($fullname) ?></dd>
                                <dt class="text-navy">Sexo:</dt>
                                <dd class="pl-4"><?= ucwords($gender) ?></dd>
                                <dt class="text-navy">Correo:</dt>
                                <dd class="pl-4"><?= $email ?></dd>
                                <dt class="text-navy">Facultad:</dt>
                                <dd class="pl-4"><?= ucwords($department) ?></dd>
                                <dt class="text-navy">Carrera:</dt>
                                <dd class="pl-4"><?= ucwords($curriculum) ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
