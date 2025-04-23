<?php if($_settings->chk_flashdata('success')): ?>
    <script>
        // Muestra una notificación de éxito si existe un mensaje flash
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success');
    </script>
<?php endif; ?>

<style>
    /* Estilos para la imagen del avatar */
    .img-avatar{
        width: 45px;
        height: 45px;
        object-fit: cover;
        object-position: center center;
        border-radius: 100%;
    }
</style>

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Lista de Usuarios</h3>
        <div class="card-tools">
            <a href="?page=user/manage_user" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>Nuevo</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Avatar</th>
                        <th>Nombre</th>
                        <th>Nombre de usuario</th>
                        <th>Tipo de usuario</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT *, concat(firstname,' ',lastname) as name FROM `users` WHERE id != '1' ORDER BY concat(firstname,' ',lastname) ASC");
                        while($row = $qry->fetch_assoc()):
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td class="text-center"><img src="<?php echo validate_image($row['avatar']) ?>" class="img-avatar img-thumbnail p-0 border-2" alt="user_avatar"></td>
                            <td><?php echo ucwords($row['name']) ?></td>
                            <td><p class="m-0 truncate-1"><?php echo $row['username'] ?></p></td>
                            <td><p class="m-0"><?php echo ($row['type'] == 1) ? "Administrator" : "Staff" ?></p></td>
                            <td align="center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                        Acción
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item" href="?page=user/manage_user&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Editar</a>
                                        <div class="dropdown-divider"></div>
                                        <?php if($row['status'] != 1): ?>
                                            <a class="dropdown-item verify_user" href="javascript:void(0)" data-id="<?= $row['id'] ?>"  data-name="<?= $row['username'] ?>"><span class="fa fa-check text-primary"></span> Verificar</a>
                                            <div class="dropdown-divider"></div>
                                        <?php endif; ?>
                                        <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Eliminar</a>
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
        // Confirmar la eliminación de un usuario
        $('.delete_data').click(function(){
            _conf("¿Está seguro de eliminar este usuario de forma permanente?", "delete_user", [$(this).attr('data-id')]);
        });

        // Agregar clases de estilo a las celdas de la tabla
        $('.table td, .table th').addClass('py-1 px-2 align-middle');

        // Inicializar el plugin DataTable
        $('.table').dataTable();

        // Confirmar la verificación de un usuario
        $('.verify_user').click(function(){
            _conf("¿Estás seguro de verificar "+$(this).attr('data-name'), "verify_user", [$(this).attr('data-id')]);
        });
    });

    // Función para eliminar un usuario
    function delete_user($id){
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Users.php?f=delete",
            method: "POST",
            data: {id: $id},
            dataType: "json",
            error: function(err){
                console.log(err);
                alert_toast("Ocurrió un error.", 'error');
                end_loader();
            },
            success: function(resp){
                if(typeof resp == 'object' && resp.status == 'success'){
                    location.reload();
                } else {
                    alert_toast("Ocurrió un error.", 'error');
                    end_loader();
                }
            }
        });
    }

    // Función para verificar un usuario
    function verify_user($id){
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Users.php?f=verify_user",
            method: "POST",
            data: {id: $id},
            dataType: "json",
            error: function(err){
                console.log(err);
                alert_toast("Ocurrió un error.", 'error');
                end_loader();
            },
            success: function(resp){
                if(typeof resp == 'object' && resp.status == 'success'){
                    location.reload();
                } else {
                    alert_toast("Ocurrió un error.", 'error');
                    end_loader();
                }
            }
        });
    }
</script>
