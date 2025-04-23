<?php
// Establecer estilos CSS en línea para ocultar el pie de página del modal
?>
<style>
    #uni_modal .modal-footer {
        display: none;
    }
</style>

<?php
// Contenido del mensaje de alerta de registro
?>
<div class="container">
    <p>
        Su inscripción en la Facultad se ha enviado con éxito y le confirmaremos tan pronto como veamos su solicitud.
        <?php if(isset($_GET['reg_no'])): ?>
            <!-- Mostrar el número de registro si está disponible -->
            Su número de registro es <b><?= $_GET['reg_no'] ?></b>.
        <?php endif; ?>
        Gracias!
    </p>
    <div class="text-right">
        <!-- Botón para cerrar el modal -->
        <button class="btn btn-sm btn-flat btn-dark" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
    </div>
</div>
