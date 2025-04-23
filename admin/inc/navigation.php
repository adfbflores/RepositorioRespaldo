<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-no-expand bg-dark">
    <!-- Brand Logo -->
    <a href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>admin" class="brand-link bg-transparent text-sm shadow-sm">
        <img src="<?= htmlspecialchars(validate_image($_settings->info('logo')), ENT_QUOTES, 'UTF-8') ?>" alt="Store Logo" class="brand-image img-circle elevation-3 bg-black" style="width: 1.8rem; height: 1.8rem; max-height: unset; object-fit: scale-down; object-position: center center">
        <span class="brand-text font-weight-light"><?= htmlspecialchars($_settings->info('short_name'), ENT_QUOTES, 'UTF-8') ?></span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">
        <div class="os-resize-observer-host observed">
            <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
        </div>
        <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
            <div class="os-resize-observer"></div>
        </div>
        <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 646px;"></div>
        <div class="os-padding">
            <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
                <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
                    <!-- Sidebar user panel (optional) -->
                    <div class="clearfix"></div>
                    <!-- Sidebar Menu -->
                    <nav class="mt-4">
                        <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item dropdown">
                                <a href="./" class="nav-link nav-home">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>admin/?page=archives" class="nav-link nav-archives">
                                    <i class="nav-icon fas fa-archive"></i>
                                    <p>
                                        Archivos
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>admin/?page=students" class="nav-link nav-students">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Estudiantes
                                    </p>
                                </a>
                            </li>
                            <?php if ($_settings->userdata('type') == 1): ?>
                                <li class="nav-header">MANTENIMIENTO</li>
                                <li class="nav-item dropdown">
                                    <a href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>admin/?page=departments" class="nav-link nav-departments">
                                        <i class="nav-icon fas fa-th-list"></i>
                                        <p>
                                            Facultades
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>admin/?page=curriculum" class="nav-link nav-curriculum">
                                        <i class="nav-icon fas fa-scroll"></i>
                                        <p>
                                            Carreras
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>admin/?page=user/list" class="nav-link nav-user_list">
                                        <i class="nav-icon fas fa-users-cog"></i>
                                        <p>
                                            Usuarios
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>admin/?page=system_info" class="nav-link nav-system_info">
                                        <i class="nav-icon fas fa-cogs"></i>
                                        <p>
                                            Ajustes
                                        </p>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
            </div>
        </div>
        <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
                <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
            </div>
        </div>
        <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
                <div class="os-scrollbar-handle" style="height: 55.017%; transform: translate(0px, 0px);"></div>
            </div>
        </div>
        <div class="os-scrollbar-corner"></div>
    </div>
    <!-- /.sidebar -->
</aside>

<!-- JavaScript -->
<script>
    var page;
    $(document).ready(function() {
        // Obtener la página actual de la URL
        page = '<?= htmlspecialchars(isset($_GET['page']) ? $_GET['page'] : 'home', ENT_QUOTES, 'UTF-8') ?>';
        page = page.replace(/\//gi, '_');

        // Resaltar la página activa en el menú
        if ($('.nav-link.nav-' + page).length > 0) {
            $('.nav-link.nav-' + page).addClass('active');
            if ($('.nav-link.nav-' + page).hasClass('tree-item') == true) {
                $('.nav-link.nav-' + page).closest('.nav-treeview').siblings('a').addClass('active');
                $('.nav-link.nav-' + page).closest('.nav-treeview').parent().addClass('menu-open');
            }
            if ($('.nav-link.nav-' + page).hasClass('nav-is-tree') == true) {
                $('.nav-link.nav-' + page).parent().addClass('menu-open');
            }
        }

        // Evento para el botón de recibir navegación
        $('#receive-nav').click(function() {
            $('#uni_modal').on('shown.bs.modal', function() {
                $('#find-transaction [name="tracking_code"]').focus();
            });
            uni_modal("Enter Tracking Number", "transaction/find_transaction.php");
        });
    });
</script>
