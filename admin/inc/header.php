<?php
// Incluir el archivo de autenticación de sesión
require_once('sess_auth.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Definición de estilos CSS para variables globales -->
    <style>
        :root {
            --base_url: <?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $_settings->info('title') !== false ? htmlspecialchars($_settings->info('title') . ' | ', ENT_QUOTES, 'UTF-8') : '' ?>
        <?= htmlspecialchars($_settings->info('name'), ENT_QUOTES, 'UTF-8') ?>
    </title>
    <link rel="icon" href="<?= htmlspecialchars(validate_image($_settings->info('logo')), ENT_QUOTES, 'UTF-8') ?>" />

    <!-- Google Font: Source Sans Pro -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback"> -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>dist/css/adminlte.css">
    <link rel="stylesheet" href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>dist/css/custom.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>plugins/summernote/summernote-bs4.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Estilos adicionales -->
    <style type="text/css">
        /* Chart.js */
        @keyframes chartjs-render-animation {
            from {opacity: .99}
            to {opacity: 1}
        }
        .chartjs-render-monitor {
            animation: chartjs-render-animation 1ms;
        }
        .chartjs-size-monitor, .chartjs-size-monitor-expand, .chartjs-size-monitor-shrink {
            position: absolute;
            direction: ltr;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
            pointer-events: none;
            visibility: hidden;
            z-index: -1;
        }
        .chartjs-size-monitor-expand > div {
            position: absolute;
            width: 1000000px;
            height: 1000000px;
            left: 0;
            top: 0;
        }
        .chartjs-size-monitor-shrink > div {
            position: absolute;
            width: 200%;
            height: 200%;
            left: 0;
            top: 0;
        }
    </style>

    <!-- jQuery -->
    <script src="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>plugins/toastr/toastr.min.js"></script>
    <script>
        // Definir la URL base para su uso en scripts
        var _base_url_ = '<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>';
    </script>
    <!-- Script principal -->
    <script src="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>dist/js/script.js"></script>
</head>
<body>
    <!-- Aquí el contenido del cuerpo -->
</body>
</html>
