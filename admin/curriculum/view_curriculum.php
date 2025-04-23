<?php
// Verificar si se ha proporcionado un ID en la URL
if(isset($_GET['id'])){
    // Realizar la consulta para obtener los datos del plan de estudios y su departamento correspondiente
    $qry = $conn->query("SELECT c.*, d.name as department FROM `curriculum_list` c INNER JOIN `department_list` d ON c.department_id = d.id WHERE c.id = '{$_GET['id']}'");
    // Verificar si se encontraron resultados en la consulta
    if($qry->num_rows > 0){
        // Recorrer los resultados y asignar cada valor a una variable con el mismo nombre de la columna
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
?>
<style>
    /* Ocultar el pie de página del modal */
    #uni_modal .modal-footer{
        display:none !important;
    }
</style>
<div class="container-fluid">
    <!-- Mostrar los detalles del plan de estudios -->
    <dl>
        <dt class="text-muted">Facultad</dt>
        <dd class='pl-4 fs-4 fw-bold'><?= isset($department) ? $department : '' ?></dd>
        <dt class="text-muted">Nombre</dt>
        <dd class='pl-4 fs-4 fw-bold'><?= isset($name) ? $name : '' ?></dd>
        <dt class="text-muted">Descripción</dt>
        <dd class='pl-4'>
            <p class=""><small><?= isset($description) ? $description : '' ?></small></p>
        </dd>
        <dt class="text-muted">Estado</dt>
        <dd class='pl-4'>
            <?php
            // Mostrar el estado del plan de estudios como una etiqueta de distintivo
            if(isset($status)){
                switch($status){
                    case '1':
                        echo "<span class='badge badge-success badge-pill'>Activo</span>";
                        break;
                    case '0':
                        echo "<span class='badge badge-secondary badge-pill'>Inactivo</span>";
                        break;
                }
            }
            ?>
        </dd>
    </dl>
    <!-- Botón para cerrar el modal -->
    <div class="col-12 text-right">
        <button class="btn btn-flat btn-sm btn-dark" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
    </div>
</div>
