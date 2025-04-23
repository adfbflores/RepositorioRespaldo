<?php
// Consulta los datos del usuario actual
$user = $conn->query("SELECT * FROM users where id ='".$_settings->userdata('id')."'");

// Inicializa un array para almacenar los metadatos del usuario
$meta = [];

// Itera sobre los resultados de la consulta y asigna los valores al array de metadatos
foreach ($user->fetch_array() as $k => $v) {
    $meta[$k] = $v;
}
?>

<?php if ($_settings->chk_flashdata('success')): ?>
    <script>
        // Muestra una notificación si hay un mensaje de éxito
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success');
    </script>
<?php endif; ?>

<div class="card card-outline card-primary">
    <div class="card-body">
        <div class="container-fluid">
            <div id="msg"></div>
            <form action="" id="manage-user" enctype="multipart/form-data"> <!-- Agrega enctype para admitir la carga de archivos -->
                <input type="hidden" name="id" value="<?php echo $_settings->userdata('id') ?>">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname']: '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="name">Apellido</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname']: '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="username">Nombre de Usuario</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
                    <small><i>Deje esto en blanco si no desea cambiar la contraseña.</i></small>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Avatar</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this)">
                        <label class="custom-file-label" for="customFile">Elija el archivo</label>
                    </div>
                </div>
                <div class="form-group d-flex justify-content-center">
                    <img src="<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] :'') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
                </div>
            </form>
        </div>
    </div>
    <div class="card-footer">
        <div class="col-md-12">
            <div class="row">
                <button class="btn btn-sm btn-primary" form="manage-user">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos para la imagen de avatar */
    img#cimg {
        height: 15vh;
        width: 15vh;
        object-fit: cover;
        border-radius: 100% 100%;
    }
</style>

<script>
    function displayImg(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#cimg').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#manage-user').submit(function(e) {
        e.preventDefault();
        var _this = $(this);
        start_loader();
        $.ajax({
            url: _base_url_ + 'classes/Users.php?f=save',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                if (resp == 1) {
                    location.reload();
                } else {
                    $('#msg').html('<div class="alert alert-danger">El nombre de usuario ya existe</div>');
                    end_loader();
                }
            }
        });
    });
</script>
