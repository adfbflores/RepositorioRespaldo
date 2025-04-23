<?php
// Verificar si se proporciona un ID en la URL y recuperar los detalles del alumno
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT e.*,CONCAT(lastname, ', ', firstname,' ',middlename) as fullname,p.name,p.description,p.training_duration from `enrollee_list` e inner join package_list p on e.package_id = p.id where e.id = '{$_GET['id']}'");
    if ($qry->num_rows > 0) {
        $res = $qry->fetch_assoc();
        // Asignar los valores a las variables correspondientes
        foreach ($res as $k => $v) {
            if (!is_numeric($k)) {
                $$k = $v;
            }
        }
    }
}

// Calcular el saldo del alumno
$balance = isset($cost) ? $cost : 0;
?>

<div class="container-fluid">
    <div class="card card-outline card-navy rounded-0 shadow">
        <div class="card-header rounded-0">
            <h5 class="card-title">Detalles del alumno</h5>
        </div>
        <div class="card-body rounded-0">
            <div id="outprint">
                <div class="row">
                    <div class="col-md-6">
                        <dl>
                            <!-- Detalles personales del alumno -->
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl>
                            <!-- Detalles del paquete de entrenamiento -->
                        </dl>
                    </div>
                </div>
                <?php if (in_array($status, range(1, 3))): ?>
                    <!-- Historial de pagos del alumno -->
                <?php endif; ?>
            </div>
        </div>
        <div class="card-footer rounded-0 text-center">
            <!-- Botones de acción -->
        </div>
    </div>
</div>

<script>
    $(function(){
        // Evento al hacer clic en el botón "Update Status"
        $('#update_status').click(function(){
            uni_modal("Actualizar detalles","enrollees/update_status.php?id=<?= $id ?>&status=<?= $status ?>")
        });

        // Evento al hacer clic en el botón "Payment"
        $('#payment').click(function(){
            uni_modal("Nuevo pago","enrollees/payment.php?id=<?= $id ?>&balance=<?= $balance ?>")
        });

        // Evento al hacer clic en el botón "Delete Payment"
        $('.delete_payment').click(function(){
            _conf("¿Seguro que deseas eliminar este pago permanentemente?","delete_payment",[$(this).attr('data-id')])
        });

        // Evento al hacer clic en el botón "Print"
        $('#print').click(function(){
            // Lógica para imprimir los detalles del alumno
        });
    });

    // Función para eliminar un pago
    function delete_payment($id){
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_payment",
            method: "POST",
            data: {id: $id},
            dataType: "json",
            error: function(err){
                console.log(err);
                alert_toast("Ocurrió un error.",'error');
                end_loader();
            },
            success: function(resp){
                if (typeof resp == 'object' && resp.status == 'success'){
                    location.reload();
                } else {
                    alert_toast("Ocurrió un error.",'error');
                    end_loader();
                }
            }
        });
    }
</script>
