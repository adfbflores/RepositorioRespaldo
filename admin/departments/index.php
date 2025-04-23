<?php 

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
?>
<style>
    .img-avatar {
        width: 45px;
        height: 45px;
        object-fit: cover;
        object-position: center center;
        border-radius: 100%;
    }
</style>

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Lista de Facultades</h3>
        <div class="card-tools">
            <a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-sm btn-primary">
                <span class="fas fa-plus"></span> Nuevo
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-hover table-striped">
                <colgroup>
                    <col width="5%">
                    <col width="20%">
                    <col width="20%">
                    <col width="30%">
                    <col width="15%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha de creación</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        // Inicializar contador
                        $i = 1;
                        
                        // Realizar la consulta para obtener la lista de departamentos
                        $qry = $conn->query("SELECT * FROM `department_list` ORDER BY `name` ASC");
                        
                        // Recorrer los resultados de la consulta
                        while($row = $qry->fetch_assoc()):
                    ?>
                    <tr>
                        <td class="text-center"><?= $i++; ?></td>
                        <td><?= date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
                        <td><?= ucwords($row['name']) ?></td>
                        <td class="truncate-1"><?= $row['description'] ?></td>
                        <td class="text-center">
                            <?php
                                // Mostrar el estado del departamento
                                echo match($row['status']) {
                                    '1' => "<span class='badge badge-success badge-pill'>Activo</span>",
                                    '0' => "<span class='badge badge-secondary badge-pill'>Inactivo</span>",
                                    default => "<span class='badge badge-warning badge-pill'>Desconocido</span>",
                                };
                            ?>
                        </td>
                        <td align="center">
                            <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                Acción
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?= $row['id'] ?>"><span class="fa fa-eye text-dark"></span> Ver</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?= $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Editar</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?= $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Eliminar</a>
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
    $(document).ready(function() {
        // Botón para crear un nuevo departamento
        $('#create_new').click(function() {
            uni_modal("Detalles del Departamento", "departments/manage_department.php");
        });

        // Botón para editar un departamento existente
        $('.edit_data').click(function() {
            uni_modal("Detalles del Departamento", "departments/manage_department.php?id=" + $(this).attr('data-id'));
        });

        // Botón para eliminar un departamento existente
        $('.delete_data').click(function() {
            _conf("¿Está seguro de eliminar este departamento de forma permanente?", "delete_department", [$(this).attr('data-id')]);
        });

        // Botón para ver detalles de un departamento
        $('.view_data').click(function() {
            uni_modal("Detalles del Departamento", "departments/view_department.php?id=" + $(this).attr('data-id'));
        });

        // Agregar clases de estilo a las celdas de la tabla
        $('.table td, .table th').addClass('py-1 px-2 align-middle');
        
        // Inicializar DataTable con configuración personalizada
        $('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
        });
    });

    // Función para eliminar un departamento
    function delete_department(id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_department",
            method: "POST",
            data: { id: id },
            dataType: "json",
            error: function(err) {
                console.log(err);
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
