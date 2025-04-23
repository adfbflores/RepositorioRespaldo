<script>
    $(document).ready(function() {
    // Función para mostrar un modal con un visor de imágenes o videos
    window.viewer_modal = function($src = '') {
        start_loader(); // Iniciar el loader

        let extension = $src.split('.').pop().toLowerCase();
        let view;

        // Comprobar si el archivo es un video o una imagen
        if (extension === 'mp4') {
            view = $("<video src='" + $src + "' controls autoplay></video>");
        } else {
            view = $("<img src='" + $src + "' />");
        }

        // Eliminar cualquier video o imagen existente en el modal
        $('#viewer_modal .modal-content video, #viewer_modal .modal-content img').remove();
        // Añadir la nueva vista al modal
        $('#viewer_modal .modal-content').append(view);
        // Mostrar el modal
        $('#viewer_modal').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,
            focus: true
        });

        end_loader(); // Finalizar el loader
    }

    // Función para mostrar un modal con contenido cargado desde una URL
    window.uni_modal = function($title = '', $url = '', $size = '') {
        start_loader(); // Iniciar el loader

        $.ajax({
            url: $url,
            error: function(err) {
                console.error(err); // Mostrar el error en la consola
                alert("Ocurrió un error"); // Mostrar un mensaje de error al usuario
            },
            success: function(resp) {
                if (resp) {
                    // Configurar el título y contenido del modal
                    $('#uni_modal .modal-title').html($title);
                    $('#uni_modal .modal-body').html(resp);
                    
                    // Ajustar el tamaño del modal si se proporciona
                    if ($size !== '') {
                        $('#uni_modal .modal-dialog').addClass($size + ' modal-dialog-centered');
                    } else {
                        $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md modal-dialog-centered");
                    }

                    // Mostrar el modal
                    $('#uni_modal').modal({
                        show: true,
                        backdrop: 'static',
                        keyboard: false,
                        focus: true
                    });

                    end_loader(); // Finalizar el loader
                }
            }
        });
    }

    // Función para mostrar un modal de confirmación
    window._conf = function($msg = '', $func = '', $params = []) {
        $('#confirm_modal #confirm').attr('onclick', $func + "(" + $params.join(',') + ")");
        $('#confirm_modal .modal-body').html($msg);
        $('#confirm_modal').modal('show');
    }
    
});
</script>

<footer class="main-footer text-sm">
    <strong>Alejandro Flores</strong>
    <div class="float-right d-none d-sm-inline-block">
        Versión 1.0
    </div>
</footer>
</div>
<!-- ./wrapper -->

<div id="libraries">
    <!-- Resolver conflicto entre jQuery UI tooltip y Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="<?= base_url ?>plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="<?= base_url ?>plugins/sparklines/sparkline.js"></script>
    <!-- Select2 -->
    <script src="<?= base_url ?>plugins/select2/js/select2.full.min.js"></script>
    <!-- JQVMap -->
    <script src="<?= base_url ?>plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="<?= base_url ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?= base_url ?>plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="<?= base_url ?>plugins/moment/moment.min.js"></script>
    <script src="<?= base_url ?>plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?= base_url ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="<?= base_url ?>plugins/summernote/summernote-bs4.min.js"></script>
    <!-- DataTables -->
    <script src="<?= base_url ?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url ?>dist/js/adminlte.js"></script>
</div>
