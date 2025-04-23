<?php 

require_once('./config.php'); 

?>
<!DOCTYPE html>
<html lang="es" style="height: auto;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <style>
        #header {
            height: 70vh;
            width: 100%;
            position: relative;
            top: -1em;
        }
        #header:before {
            content: "";
            position: absolute;
            height: 100%;
            width: 100%;
            background-image: url(<? echo validate_image($_settings->info("cover")); ?>);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }
        #header > div {
            position: absolute;
            height: 100%;
            width: 100%;
            z-index: 2;
        }

        #top-Nav a.nav-link.active {
            color: #001f3f;
            font-weight: 900;
            position: relative;
        }
        #top-Nav a.nav-link.active:before {
            content: "";
            position: absolute;
            border-bottom: 2px solid #001f3f;
            width: 33.33%;
            left: 33.33%;
            bottom: 0;
        }
    </style>
    <?php require_once('inc/header.php') ?>
</head>
<body class="layout-top-nav layout-fixed layout-navbar-fixed" style="height: auto;">
    <div class="wrapper">
        <?php 
        $page = isset($_GET['page']) ? $_GET['page'] : 'home'; 
        require_once('inc/topBarNav.php'); 
        if ($_settings->chk_flashdata('success')): ?>
            <script>
                alert_toast("<?= htmlspecialchars($_settings->flashdata('success'), ENT_QUOTES, 'UTF-8') ?>", 'success');
            </script>
        <?php endif; ?>
        <div class="content-wrapper pt-5" style="background-color: white;">
            <?php if ($page == "home" || $page == "about_us"): ?>
                <div id="header" class="shadow mb-4">
                    <div class="d-flex justify-content-center h-100 w-100 align-items-center flex-column px-3">
                        <h1 class="w-100 text-center site-title"><?= htmlspecialchars($_settings->info('name'), ENT_QUOTES, 'UTF-8') ?></h1>
                        <a href="./?page=projects" class="btn btn-lg btn-light rounded-pill w-25" id="enrollment"><b>Explorar Proyectos</b></a>
                    </div>
                </div>
            <?php endif; ?>
            <section class="content">
                <div class="container">
                    <?php 
                    if (!file_exists($page . ".php") && !is_dir($page)) {
                        include '404.html';
                    } else {
                        if (is_dir($page)) {
                            include $page . '/index.php';
                        } else {
                            include $page . '.php';
                        }
                    }
                    ?>
                </div>
            </section>
        </div>
        <div class="modal fade" id="confirm_modal" role="dialog">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmación</h5>
                    </div>
                    <div class="modal-body">
                        <div id="delete_content"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="confirm">Continuar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="uni_modal" role="dialog">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="submit" onclick="document.querySelector('#uni_modal form').submit()">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="uni_modal_right" role="dialog">
            <div class="modal-dialog modal-full-height modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="fa fa-arrow-right"></span>
                        </button>
                    </div>
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="viewer_modal" role="dialog">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
                    <img src="" alt="">
                </div>
            </div>
        </div>
    </div>
    <?php require_once('inc/footer.php') ?>
</body>
</html>
