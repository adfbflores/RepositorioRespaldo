<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once('../config.php');

?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('inc/header.php'); ?>

<body class="sidebar-mini layout-fixed control-sidebar-slide-open layout-navbar-fixed" style="height: auto;">
    <div class="wrapper">
        <?php require_once('inc/topBarNav.php'); ?>
        <?php require_once('inc/navigation.php'); ?>
        <?php if($_settings->chk_flashdata('success')): ?>
            <script>
                alert_toast("<?php echo htmlspecialchars($_settings->flashdata('success'), ENT_QUOTES, 'UTF-8'); ?>",'success');
            </script>
        <?php endif; ?>    
        <?php 
            $page = isset($_GET['page']) ? $_GET['page'] : 'home';  
            $page_path = $page . '.php';
            if (!file_exists($page_path) && !is_dir($page)) {
                include '404.html';
            } else {
                include (is_dir($page) ? $page . '/index.php' : $page . '.php');
            }
        ?>
        <?php require_once('inc/footer.php');?>
    </div>
    <div class="modal fade" id="confirm_modal" role='dialog'>
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmación</h5>
                </div>
                <div class="modal-body">
                    <div id="delete_content"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-flat" id='confirm' onclick="">Continuar</button>
                    <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="uni_modal" role='dialog'>
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-flat" id='submit' onclick="$('#uni_modal form').submit()">Guardar</button>
                    <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="uni_modal_right" role='dialog'>
        <div class="modal-dialog modal-full-height modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="fa fa-arrow-right"></span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="viewer_modal" role='dialog'>
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
                <img src="" alt="">
            </div>
        </div>
    </div>
</body>
</html>

