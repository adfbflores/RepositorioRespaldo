<?php
require_once('../../config.php');
require_once('../inc/header.php');
require_once('../inc/navigation.php');
?>

<?php
// Verifica si hay un mensaje flash de éxito y muestra una notificación
if ($_settings->chk_flashdata('success')): ?>
    <script>
        alert_toast("<?= $_settings->flashdata('success') ?>", 'success');
    </script>
<?php endif; ?>

<style>
    /* Estilos para las imágenes */
    img#cimg {
        height: 15vh;
        width: 15vh;
        object-fit: scale-down;
        border-radius: 100%;
    }
    img#cimg2 {
        height: 50vh;
        width: 100%;
        object-fit: contain;
    }
</style>

<div class="col-lg-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h5 class="card-title">Información del Sistema</h5>
        </div>
        <div class="card-body">
            <form action="" id="system-frm">
                <div id="msg" class="form-group"></div>
                
                <!-- Campo para el nombre del sistema -->
                <div class="form-group">
                    <label for="name" class="control-label">Nombre del Sistema</label>
                    <input type="text" class="form-control form-control-sm" name="name" id="name" value="<?= $_settings->info('name') ?>">
                </div>
                
                <!-- Campo para el nombre abreviado del sistema -->
                <div class="form-group">
                    <label for="short_name" class="control-label">Nombre abreviado del Sistema</label>
                    <input type="text" class="form-control form-control-sm" name="short_name" id="short_name" value="<?= $_settings->info('short_name') ?>">
                </div>
                
                <!-- Campo para el contenido de bienvenida -->
                <div class="form-group">
                    <label for="content[welcome]" class="control-label">Contenido de Bienvenida</label>
                    <textarea type="text" class="form-control form-control-sm summernote" name="content[welcome]" id="welcome"><?= is_file(base_app . 'welcome.html') ? file_get_contents(base_app . 'welcome.html') : '' ?></textarea>
                </div>
                
                <!-- Campo para el contenido de sobre nosotros -->
                <div class="form-group">
                    <label for="content[about_us]" class="control-label">Sobre Nosotros</label>
                    <textarea type="text" class="form-control form-control-sm summernote" name="content[about_us]" id="about_us"><?= is_file(base_app . 'about_us.html') ? file_get_contents(base_app . 'about_us.html') : '' ?></textarea>
                </div>
                
                <!-- Campo para subir el logo del sistema -->
                <div class="form-group">
                    <label for="" class="control-label">Logo del Sistema</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this)">
                        <label class="custom-file-label" for="customFile">Elija el archivo</label>
                    </div>
                </div>
                
                <!-- Vista previa del logo del sistema -->
                <div class="form-group d-flex justify-content-center">
                    <img src="<?= validate_image($_settings->info('logo')) ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
                </div>
                
                <!-- Campo para subir la imagen de portada -->
                <div class="form-group">
                    <label for="" class="control-label">Cover</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input rounded-circle" id="customFile2" name="cover" onchange="displayImg2(this)">
                        <label class="custom-file-label" for="customFile2">Elija el archivo</label>
                    </div>
                </div>
                
                <!-- Vista previa de la imagen de portada -->
                <div class="form-group d-flex justify-content-center">
                    <img src="<?= validate_image($_settings->info('cover')) ?>" alt="" id="cimg2" class="img-fluid img-thumbnail bg-gradient-dark border-dark">
                </div>
                
                <!-- Información de la escuela -->
                <fieldset>
                    <legend>Información de la Escuela</legend>
                    <div class="form-group">
                        <label for="email" class="control-label">Correo</label>
                        <input type="email" class="form-control form-control-sm" name="email" id="email" value="<?= $_settings->info('email') ?>">
                    </div>
                    <div class="form-group">
                        <label for="contact" class="control-label">N° Contacto</label>
                        <input type="text" class="form-control form-control-sm" name="contact" id="contact" value="<?= $_settings->info('contact') ?>">
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label">Dirección</label>
                        <textarea rows="3" class="form-control form-control-sm" name="address" id="address" style="resize:none"><?= $_settings->info('address') ?></textarea>
                    </div>
                </fieldset>
            </form>
        </div>
        
        <!-- Botón para actualizar la información del sistema -->
        <div class="card-footer">
            <div class="col-md-12">
                <div class="row">
                    <button class="btn btn-sm btn-primary" form="system-frm">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Función para mostrar la imagen seleccionada para el logo del sistema
    function displayImg(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('cimg').src = e.target.result;
                input.nextElementSibling.innerHTML = input.files[0].name;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    // Función para mostrar la imagen seleccionada para la portada del sistema
    function displayImg2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('cimg2').src = e.target.result;
                input.nextElementSibling.innerHTML = input.files[0].name;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Inicialización de Summernote para campos de texto enriquecido
    document.addEventListener('DOMContentLoaded', function() {
        $('.summernote').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ol', 'ul', 'paragraph', 'height']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
