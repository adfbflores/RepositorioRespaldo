<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Repositoriotesis/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Repositoriotesis/admin/inc/header.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Repositoriotesis/admin/inc/navigation.php');
?>

<style>
    .img-avatar{
        width:45px;
        height:45px;
        object-fit:cover;
        object-position:center center;
        border-radius:100%;
    }
</style>

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Lista de Carreras</h3>
        <div class="card-tools">
            <a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-sm btn-primary"><span class="fas fa-plus"></span>  Nuevo</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-hover table-striped">
                <colgroup>
                    <col width="5%">
                    <col width="20%">
                    <col width="25%">
                    <col width="25%">
                    <col width="15%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha de creación</th>
                        <th>Facultad</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT c.*, d.name as department from `curriculum_list` c inner join `department_list` d on c.department_id = d.id order by c.`name` asc");
                        while($row = $qry->fetch_assoc()):
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td class=""><?php echo date("Y-m-d H:i", strtotime($row['date_created'])); ?></td>
                            <td class=""><?php echo $row['department']; ?></td>
                            <td><?php echo ucwords($row['name']); ?></td>
                            <td class="text-center">
                                <?php
                                    switch($row['status']){
                                        case '1':
                                            echo "<span class='badge badge-success badge-pill'>Activo</span>";
                                            break;
                                        case '0':
                                            echo "<span class='badge badge-secondary badge-pill'>Inactivo</span>";
                                            break;
                                    }
                                ?>
                            </td>
                            <td align="center">
                                <div class="dropdown">
                                    <button class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Acción
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>"><span class="fa fa-eye text-dark"></span> Ver</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>"><span class="fa fa-edit text-primary"></span> Editar</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>"><span class="fa fa-trash text-danger"></span> Eliminar</a>
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

<script>
    $(document).ready(function(){
        // Evento para crear una nueva materia
        $('#create_new').click(function(){
            uni_modal("Detalles de la materia","curriculum/manage_curriculum.php")
        });

        // Evento para editar una materia existente
        $('.edit_data').click(function(){
            uni_modal("Detalles de la materia","curriculum/manage_curriculum.php?id="+$(this).attr('data-id'))
        });

        // Evento para eliminar una materia
        $('.delete_data').click(function(){
            _conf("¿Estás seguro de eliminar la materia de forma permanente?","delete_curriculum",[$(this).attr('data-id')])
        });

        // Evento para ver los detalles de una materia
        $('.view_data').click(function(){
            uni_modal("Detalles de la materia","curriculum/view_curriculum.php?id="+$(this).attr('data-id'))
        });

        // Agregar clases CSS a las celdas de la tabla
        $('.table td,.table th').addClass('py-1 px-2 align-middle');

        // Inicializar el plugin DataTables
        $('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
        });
    });

    // Función para eliminar una materia
    function delete_curriculum($id){
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_curriculum",
            method: "POST",
            data: {id: $id},
            dataType: "json",
            error: function(err){
                console.log(err);
                alert_toast("Ocurrió un error.",'error');
                end_loader();
            },
            success: function(resp){
                if(typeof resp == 'object' && resp.status == 'success'){
                    location.reload();
                }else{
                    alert_toast("Ocurrió un error.",'error');
                    end_loader();
                }
            }
        });
    }
</script>

<?php include('../inc/footer.php'); ?>

