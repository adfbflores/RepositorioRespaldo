<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de estudiantes</title>
    <style>
        /* Estilos para los avatares de los usuarios */
        .img-avatar {
            width: 45px;
            height: 45px;
            object-fit: cover;
            object-position: center center;
            border-radius: 100%;
        }
    </style>
</head>
<body>
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Lista de estudiantes</h3>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Avatar</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            // Inicializa el contador de filas
                            $i = 1;

                            // Realiza la consulta a la base de datos
                            $qry = $conn->query("SELECT *, CONCAT(lastname, ', ', firstname, ' ', middlename) as name FROM `student_list` ORDER BY CONCAT(lastname, ', ', firstname, ' ', middlename) ASC");

                            // Recorre los resultados de la consulta
                            while($row = $qry->fetch_assoc()):
                        ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td class="text-center"><img src="<?= validate_image($row['avatar']) ?>" class="img-avatar img-thumbnail p-0 border-2" alt="user_avatar"></td>
                                <td><?= ucwords($row['name']) ?></td>
                                <td><p class="m-0 truncate-1"><?= $row['email'] ?></p></td>
                                <td class="text-center">
                                    <?php if($row['status'] == 1): ?>
                                        <span class="badge badge-pill badge-success">Verificado</span>
                                    <?php else: ?>
                                        <span class="badge badge-pill badge-primary">No Verificado</span>
                                    <?php endif; ?>
                                </td>
                                <td align="center">
                                    <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                        Acción
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item view_details" href="javascript:void(0)" data-id="<?= $row['id'] ?>"><span class="fa fa-eye text-dark"></span> Ver</a>
                                        <div class="dropdown-divider"></div>
                                        <?php if($row['status'] != 1): ?>
                                            <a class="dropdown-item verify_user" href="javascript:void(0)" data-id="<?= $row['id'] ?>" data-name="<?= $row['email'] ?>"><span class="fa fa-check text-primary"></span> Verificar</a>
                                            <div class="dropdown-divider"></div>
                                        <?php endif; ?>
                                        <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?= $row['id'] ?>" data-name="<?= $row['email'] ?>"><span class="fa fa-trash text-danger"></span> Eliminar</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts para manejar las acciones de los botones -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Maneja la acción de eliminar un estudiante
            document.querySelectorAll('.delete_data').forEach(function(button) {
                button.addEventListener('click', function() {
                    const name = this.getAttribute('data-name');
                    const id = this.getAttribute('data-id');
                    _conf(`¿Estás seguro de eliminar <b>${name}</b> de la lista de estudiantes de forma permanente?`, "delete_user", [id]);
                });
            });

            // Maneja la acción de verificar un estudiante
            document.querySelectorAll('.verify_user').forEach(function(button) {
                button.addEventListener('click', function() {
                    const name = this.getAttribute('data-name');
                    const id = this.getAttribute('data-id');
                    _conf(`¿Estás seguro de verificar <b>${name}</b>?`, "verify_user", [id]);
                });
            });

            // Maneja la acción de ver detalles de un estudiante
            document.querySelectorAll('.view_details').forEach(function(button) {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    uni_modal('Detalles del estudiante', `students/view_details.php?id=${id}`, 'mid-large');
                });
            });

            // Inicializa DataTables para la tabla
            $('.table').dataTable();
        });

        // Función para eliminar un estudiante
        function delete_user(id) {
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Users.php?f=delete_student",
                method: "POST",
                data: { id },
                dataType: "json",
                error: function(err) {
                    console.error(err);
                    alert_toast("Ocurrió un error.", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp === 'object' && resp.status === 'success') {
                        location.reload();
                    } else {
                        alert_toast("Ocurrió un error.", 'error');
                        end_loader();
                    }
                }
            });
        }

        // Función para verificar un estudiante
        function verify_user(id) {
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Users.php?f=verify_student",
                method: "POST",
                data: { id },
                dataType: "json",
                error: function(err) {
                    console.error(err);
                    alert_toast("Ocurrió un error.", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp === 'object' && resp.status === 'success') {
                        location.reload();
                    } else {
                        alert_toast("Ocurrió un error.", 'error');
                        end_loader();
                    }
                }
            });
        }
    </script>
</body>
</html>

