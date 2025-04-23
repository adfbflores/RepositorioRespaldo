
<?php
header('Content-Type: text/html; charset=utf8');
?>
<h3 class="text-center">Sobre Nosotros</h3>
    <hr>
    <div class="content">
        <?php
        $aboutUsFile = "about_us.html";

        if (file_exists($aboutUsFile) && is_readable($aboutUsFile)) {
            include($aboutUsFile);
        } else {
            echo "<p>No se pudo cargar la información sobre nosotros en este momento. Por favor, inténtelo de nuevo más tarde.</p>";
        }
        ?>
    </div>