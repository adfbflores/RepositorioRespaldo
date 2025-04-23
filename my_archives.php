<?php
// Sección de PHP para obtener los proyectos enviados por el estudiante
$i = 1;
$curriculum = $conn->query("SELECT * FROM curriculum_list where id in (SELECT curriculum_id from `archive_list` where student_id = '{$_settings->userdata('id')}' )");
$cur_arr = array_column($curriculum->fetch_all(MYSQLI_ASSOC),'name','id');
$qry = $conn->query("SELECT * from `archive_list` where student_id = '{$_settings->userdata('id')}' order by unix_timestamp(`date_created`) asc ");
?>

<div class="content py-3">
    <div class="container-fluid">
        <div class="card card-outline card-primary shadow rounded-0">
            <div class="card-header rounded-0">
                <h4 class="card-title">Mis proyectos enviados</h4>
            </div>
            <div class="card-body rounded-0">
                <div class="container-fluid">
                    <table class="table table-hover table-striped">
                        <colgroup>
                            <col width="5%">
                            <col width="15%">
                            <col width="15%">
                            <col width="20%">
                            <col width="20%">
                            <col width="10%">
                            <col width="10%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fecha de creación</th>
                                <th>Código de archivo</th>
                                <th>Título del Proyecto</th>
                                <th>Carrera</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $qry->fetch_assoc()): ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++; ?></td>
                                    <td class=""><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
                                    <td><?php echo ($row['archive_code']) ?></td>
                                    <td><?php echo ucwords($row['title']) ?></td>
                                    <td><?php echo $cur_arr[$row['curriculum_id']] ?></td>
                                    <td class="text-center">
                                        <?php
                                        // Mostrar el estado del proyecto
                                        switch($row['status']){
                                            case '1':
                                                echo "<span class='badge badge-success badge-pill'>Publicado</span>";
                                                break;
                                            case '0':
                                                echo "<span class='badge badge-secondary badge-pill'>No Publicado</span>";
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td align="center">
                                        <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            Acción
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a class="dropdown-item" href="<?= base_url ?>/?page=view_archive&id=<?php echo $row['id'] ?>" target="_blank"><span class="fa fa-external-link-alt text-gray"></span> Ver</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Eliminar</a>
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
</div>

<script>
    $(function(){
        // Función para manejar clics en el enlace de eliminación de datos
        $('.delete_data').click(function(){
            _conf("¿Estás seguro de eliminar este proyecto de forma permanente?","delete_archive",[$(this).attr('data-id')])
        })
        
        // Añadir clases de estilo a las celdas de la tabla
        $('.table td,.table th').addClass('py-1 px-2 align-middle')
        
        // Inicializar la tabla DataTable
        $('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
        });
    })

    // Función para eliminar un archivo
    function delete_archive($id){
        start_loader();
        $.ajax({
            url:_base_url_+"classes/Master.php?f=delete_archive",
            method:"POST",
            data:{id: $id},
            dataType:"json",
            error:err=>{
                console.log(err)
                alert_toast("Ocurrió un error.",'error');
                end_loader();
            },
            success:function(resp){
                if(typeof resp== 'object' && resp.status == 'success'){
                    location.reload();
                }else{
                    alert_toast("Ocurrió un error.",'error');
                    end_loader();
                }
            }
        })
    }
</script>
