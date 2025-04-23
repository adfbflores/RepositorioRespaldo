<?php
$email = $_settings->info('email') ?? 'Correo no disponible';
$contact = $_settings->info('contact') ?? 'Número de contacto no disponible';
$address = $_settings->info('address') ?? 'Dirección no disponible';
$aboutUsContent = file_exists("about_us.html") ? file_get_contents("about_us.html") : 'Información sobre nosotros no disponible';
?>

<div class="col-12">
    <div class="row my-5">
        <div class="col-md-5">
            <div class="card card-outline card-navy rounded-0 shadow">
                <div class="card-header">
                    <h4 class="card-title">Contacto</h4>
                </div>
                <div class="card-body rounded-0">
                    <dl>
                        <dt class="text-muted"><i class="fa fa-envelope"></i> Correo electrónico</dt>
                        <dd class="pr-4"><?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?></dd>
                        <dt class="text-muted"><i class="fa fa-phone"></i> N° Contacto</dt>
                        <dd class="pr-4"><?= htmlspecialchars($contact, ENT_QUOTES, 'UTF-8') ?></dd>
                        <dt class="text-muted"><i class="fa fa-map-marked-alt"></i> Ubicación</dt>
                        <dd class="pr-4"><?= htmlspecialchars($address, ENT_QUOTES, 'UTF-8') ?></dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card rounded-0 card-outline card-navy shadow">
                <div class="card-body rounded-0">
                    <h2 class="text-center">Sobre Nosotros</h2>
                    <center><hr class="bg-navy border-navy w-25 border-2"></center>
                    <div>
                        <?= $aboutUsContent ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
