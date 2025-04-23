<h1><?php echo htmlspecialchars($_settings->info('name'), ENT_QUOTES, 'UTF-8'); ?></h1>
<hr class="border-info">
<div class="row">
    <?php
    // Lista de cajas de información
    $info_boxes = [
        [
            'icon_class' => 'fas fa-th-list',
            'query' => "SELECT * FROM `department_list` WHERE status = 1",
            'text' => 'Lista de facultades'
        ],
        [
            'icon_class' => 'fas fa-scroll',
            'query' => "SELECT * FROM `curriculum_list` WHERE `status` = 1",
            'text' => 'Lista de Carreras'
        ],
        [
            'icon_class' => 'fas fa-users',
            'query' => "SELECT * FROM `student_list` WHERE `status` = 1",
            'text' => 'Estudiantes verificados'
        ],
        [
            'icon_class' => 'fas fa-users',
            'query' => "SELECT * FROM `student_list` WHERE `status` = 0",
            'text' => 'Estudiantes no verificados'
        ],
        [
            'icon_class' => 'fas fa-archive',
            'query' => "SELECT * FROM `archive_list` WHERE `status` = 1",
            'text' => 'Archivos verificados'
        ],
        [
            'icon_class' => 'fas fa-archive',
            'query' => "SELECT * FROM `archive_list` WHERE `status` = 0",
            'text' => 'Archivos no verificados'
        ]
    ];

    foreach ($info_boxes as $box) :
        $result = $conn->query($box['query']);
        ?>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="info-box bg-light shadow">
                <span class="info-box-icon bg-info elevation-1"><i class="<?php echo $box['icon_class']; ?>"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"><?php echo htmlspecialchars($box['text'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <span class="info-box-number text-right"><?php echo $result->num_rows; ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    <?php endforeach; ?>
</div>
