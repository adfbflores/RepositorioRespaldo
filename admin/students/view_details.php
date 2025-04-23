<?php 
require_once('../../config.php');

// Verificar si se ha proporcionado un ID válido
if(isset($_GET['id']) && $_GET['id'] > 0){
    // Obtener los datos del estudiante
    $user_query = $conn->query("SELECT s.*, d.name as department, c.name as curriculum, CONCAT(lastname, ', ', firstname, ' ', middlename) as fullname FROM student_list s INNER JOIN department_list d ON s.department_id = d.id INNER JOIN curriculum_list c ON s.curriculum_id = c.id WHERE s.id ='{$_GET['id']}'");
    
    // Verificar si se encontró un estudiante con el ID proporcionado
    if($user_query->num_rows > 0) {
        $user_data = $user_query->fetch_assoc();
        
        // Extraer los datos del estudiante en variables individuales
        foreach($user_data as $k => $v){
            $$k = $v;
        }
    } else {
        // Si no se encuentra un estudiante con el ID proporcionado, redireccionar o mostrar un mensaje de error
        // Ejemplo: header("Location: error.php");
    }
}
?>
<style>
	#uni_modal .modal-footer{
		display:none
	}
	.student-img{
		object-fit:scale-down;
		object-position:center center;
	}
</style>
<div class="container-fluid">
	<div class="col-md-12">
		<div class="row">
			<div class="col-6">
				<center>
					<img src="<?= validate_image($avatar) ?>" alt="Student Image" class="img-fluid student-img bg-gradient-dark border">
				</center>
			</div>
			<div class="col-6">
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
					<dt class="text-navy">Estado de la cuenta:</dt>
					<dd class="pl-4">
						<?php if($status == 1): ?>
							<span class="badge badge-pill badge-success">Verificado</span>
						<?php else: ?>
							<span class="badge badge-pill badge-primary">No Verificado</span>
						<?php endif; ?>
					</dd>
				</dl>
			</div>
		</div>
		<div class="row">
			<div class="col-12 text-right">
				<button class="btn btn-dark btn-flat btn-sm" data-dismiss="modal" type="button"><i class="fa fa-times"></i> Cerrar</button>
			</div>
		</div>
	</div>
</div>
