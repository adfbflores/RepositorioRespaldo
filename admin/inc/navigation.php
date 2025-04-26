<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-no-expand bg-dark">
    <!-- Brand Logo -->
    <a href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>admin" class="brand-link bg-transparent text-sm shadow-sm">
        <img src="<?= htmlspecialchars(validate_image($_settings->info('logo')), ENT_QUOTES, 'UTF-8') ?>" alt="Store Logo" class="brand-image img-circle elevation-3 bg-black" style="width: 1.8rem; height: 1.8rem; max-height: unset; object-fit: scale-down; object-position: center center">
        <span class="brand-text font-weight-light"><?= htmlspecialchars($_settings->info('short_name'), ENT_QUOTES, 'UTF-8') ?></span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-4">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item dropdown">
                    <a href="./" class="nav-link nav-home">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>admin/archives/index.php" class="nav-link nav-archives">
                        <i class="nav-icon fas fa-archive"></i>
                        <p>Archivos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>admin/students/index.php" class="nav-link nav-students">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Estudiantes</p>
                    </a>
                </li>
                <?php if ($_settings->userdata('type') == 1): ?>
                    <li class="nav-header">MANTENIMIENTO</li>
                    <li class="nav-item dropdown">
                        <a href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>admin/departments/index.php" class="nav-link nav-departments">
                            <i class="nav-icon fas fa-th-list"></i>
                            <p>Facultades</p>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>admin/curriculum/index.php" class="nav-link nav-curriculum">
                            <i class="nav-icon fas fa-scroll"></i>
                            <p>Carreras</p>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>admin/user/list.php" class="nav-link nav-user_list">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Usuarios</p>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>admin/transparency_manage.php" class="nav-link nav-transparency_manage">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Transparencia</p>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="<?= htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>admin/system_info/index.php" class="nav-link nav-system_info">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>Ajustes</p>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</aside>

<script>
    var page;
    $(document).ready(function() {
        page = '<?= htmlspecialchars(isset($_GET['page']) ? $_GET['page'] : 'home', ENT_QUOTES, 'UTF-8') ?>';
        page = page.replace(/\//gi, '_');
        if ($('.nav-link.nav-' + page).length > 0) {
            $('.nav-link.nav-' + page).addClass('active');
            if ($('.nav-link.nav-' + page).hasClass('tree-item')) {
                $('.nav-link.nav-' + page).closest('.nav-treeview').siblings('a').addClass('active');
                $('.nav-link.nav-' + page).closest('.nav-treeview').parent().addClass('menu-open');
            }
            if ($('.nav-link.nav-' + page).hasClass('nav-is-tree')) {
                $('.nav-link.nav-' + page).parent().addClass('menu-open');
            }
        }
    });
</script>

