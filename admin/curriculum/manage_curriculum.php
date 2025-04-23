<?php
// Incluye el archivo de configuración
require_once('../../config.php');

// Verifica si se proporcionó un ID y recupera los datos del currículo correspondiente
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `curriculum_list` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
?>

<div class="container-fluid">
    <form action="" id="curriculum-form">
        <!-- Campo oculto para almacenar el ID -->
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">

        <!-- Selector de departamento -->
        <div class="form-group">
            <label for="department_id" class="control-label">Departamento</label>
            <select name="department_id" id="department_id" class="form-control form-control-border" required data-placeholder="Seleccionar departamento">
                <!-- Opción predeterminada vacía -->
                <option <?= !isset($department_id) == 1 ? "selected" : "" ?>></option>
                <?php 
                // Consulta para obtener la lista de departamentos activos
                $department = $conn->query("SELECT * FROM `department_list` where `status` = 1 ".(isset($department_id) ? "OR id = '{$department_id}'" : "")." order by `name` asc");
                while($row = $department->fetch_assoc()):
                ?>
                <!-- Opciones del selector de departamento -->
                <option value="<?= $row['id'] ?>" <?= isset($department_id) && $department_id == $row['id'] ? "selected" : "" ?>><?= ucwords($row['name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Campo de nombre -->
        <div class="form-group">
            <label for="name" class="control-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control form-control-border" placeholder="Nombre de la materia" value ="<?php echo isset($name) ? $name : '' ?>" required>
        </div>

        <!-- Campo de descripción -->
        <div class="form-group">
            <label for="description" class="control-label">Descripción</label>
            <textarea rows="3" name="description" id="description" class="form-control form-control-border" placeholder="Escriba la descripción" required><?php echo isset($description) ? $description : '' ?></textarea>
        </div>

        <!-- Selector de estado -->
        <div class="form-group">
            <label for="" class="control-label">Estado</label>
            <select name="status" id="status" class="form-control form-control-border" required>
                <option value="1" <?= isset($status) && $status == 1 ? "selected" : "" ?>>Activo</option>
                <option value="0" <?= isset($status) && $status == 0 ? "selected" : "" ?>>Inactivo</option>
            </select>
        </div>
    </form>
</div>

<script>
    $(function(){
        // Inicializa el plugin Select2 para el selector de departamento
        $('#department_id').select2({
            width: "100%",
            dropdownParent: $("#uni_modal")
        })

        // Evento de envío del formulario
        $('#uni_modal #curriculum-form').submit(function(e){
            e.preventDefault();
            var _this = $(this)
            $('.pop-msg').remove()
            var el = $('<div>')
                el.addClass("pop-msg alert")
                el.hide()
            start_loader();
            $.ajax({
                url: _base_url_+"classes/Master.php?f=save_curriculum",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: function(err){
                    console.log(err)
                    alert_toast("Ocurrió un error.", 'error');
                    end_loader();
                },
                success: function(resp){
                    if(resp.status == 'success'){
                        location.reload();
                    }else if(!!resp.msg){
                        el.addClass("alert-danger")
                        el.text(resp.msg)
                        _this.prepend(el)
                    }else{
                        el.addClass("alert-danger")
                        el.text("Ocurrió un error debido a una razón desconocida.")
                        _this.prepend(el)
                   
                    } 
                    el.show('slow')
                    end_loader();
                }
            })
        })
    })
</script>
