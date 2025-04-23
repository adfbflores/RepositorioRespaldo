<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Verificar si se ha proporcionado un ID válido en la URL
if(isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT) !== false){
    // Consultar la información del archivo con el ID proporcionado
    $qry = $conn->query("SELECT a.* FROM `archive_list` a where a.id = '{$_GET['id']}'");
    // Verificar si se encontraron resultados
    if($qry->num_rows){
        // Iterar sobre los resultados y asignarlos a variables
        foreach($qry->fetch_array() as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
    // Inicializar la variable "submitted" como "N/A"
    $submitted = "N/A";
    // Verificar si se ha proporcionado un ID de estudiante y obtener su correo electrónico
    if(isset($student_id)){
        $student = $conn->query("SELECT * FROM student_list where id = '{$student_id}'");
        // Verificar si se encontraron resultados
        if($student->num_rows > 0){
            $res = $student->fetch_array();
            $submitted = $res['email'];
        }
    }
}
?>
<style>
    #document_field{
        min-height:80vh
    }
</style>
<div class="content py-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Archivo - <?= isset($archive_code) ? $archive_code : "" ?>
                </h3>
            </div>
            <div class="card-body rounded-0">
                <div class="container-fluid">
                    <h2><b><?= isset($title) ? $title : "" ?></b></h2>
                    <small class="text-muted">Enviado por <b class="text-info"><?= $submitted ?></b> on  <?= date("F d, Y h:i A",strtotime($date_created)) ?></small>
                    <?php if(isset($student_id) && $_settings->userdata('login_type') == "2" && $student_id == $_settings->userdata('id')): ?>
                        <div class="form-group">
                            <a href="./?page=submit-archive&id=<?= isset($id) ? $id : "" ?>" class="btn btn-flat btn-default bg-navy btn-sm"><i class="fa fa-edit"></i> Editar</a>
                            <button type="button" data-id = "<?= isset($id) ? $id : "" ?>" class="btn btn-flat btn-danger btn-sm delete-data"><i class="fa fa-trash"></i> Eliminar</button>
                        </div>
                    <?php endif; ?>
                    <hr>
                    <center>
                        <img src="<?= validate_image(isset($banner_path) ? $banner_path : "") ?>" alt="Banner Image" id="banner-img" class="img-fluid border ">
                    </center>
                    <fieldset>
                        <legend class="text-navy">Año del proyecto de tesis:</legend>
                        <div class="pl-4"><large><?= isset($year) ? $year : "----" ?></large></div>
                    </fieldset>
                    <fieldset>
                        <legend class="text-navy">Resumen:</legend>
                        <div class="pl-4"><large><?= isset($abstract) ? html_entity_decode($abstract) : "" ?></large></div>
                    </fieldset>
                    <fieldset>
                        <legend class="text-navy">Integrantes:</legend>
                        <div class="pl-4"><large><?= isset($members) ? html_entity_decode($members) : "" ?></large></div>
                    </fieldset>
                    <fieldset>
                        <legend class="text-navy">Documento de Proyecto:</legend>
                        <div class="pl-4">
                            <iframe src="<?= isset($document_path) ? base_url.$document_path : "" ?>" frameborder="0" id="document_field" class="text-center w-100">Cargando documento ...</iframe>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Función para mostrar un cuadro de diálogo de confirmación antes de eliminar el archivo
    $(function(){
        $('.delete-data').click(function(){
            _conf("¿Estás seguro de eliminar <b> archivo?-<?= isset($archive_code) ? $archive_code : "" ?></b>","delete_archive")
        })
    })
    // Función para eliminar el archivo
    function delete_archive(){
        start_loader();
        $.ajax({
            url:_base_url_+"classes/Master.php?f=delete_archive",
            method:"POST",
            data:{id: "<?= isset($id) ? $id : "" ?>"},
            dataType:"json",
            timeout: 15000,
            cache: false,
            error:err=>{
                console.log(err)
                alert_toast("Ocurrió un error.",'error');
                end_loader();
            },
            success:function(resp){
                if(typeof resp== 'object' && resp.status == 'success'){
                    location.replace("./");
                }else{
                    alert_toast("Ocurrió un error.",'error');
                    end_loader();
                }
            }
        })
    }
</script>
