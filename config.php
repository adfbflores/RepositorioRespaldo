<?php
ob_start();
date_default_timezone_set('America/Lima'); // Establece la zona horaria
session_start();

// Incluir archivos de inicialización y clases necesarias
require_once('initialize.php');
require_once('classes/DBConnection.php');
require_once('classes/SystemSettings.php');

// Crear instancia de la base de datos
$db = new DBConnection;
$conn = $db->conn;

/**
 * Redirige a la URL especificada.
 *
 * @param string $url URL a la que redirigir.
 */
function redirect($url = ''){
    if (!empty($url)) {
        // Usar header en lugar de JavaScript para redirigir
        $redirect = base_url.$url;
        // @header('Location: '.base_url.$url);
        echo "<script>window.location.href='{$redirect}';</script>";
        exit;
    }
}

/**
 * Valida si la imagen existe y retorna su URL completa.
 *
 * @param string $file Ruta de la imagen a validar.
 * @return string URL completa de la imagen válida.
 */
function validate_image($file){
    if (!empty($file)) {
        $ex = explode('?', $file);
        $filePath = $ex[0];
        $param = isset($ex[1]) ? '?' . $ex[1] : '';
        
        // Comprobar si el archivo existe en la ruta base
        if (is_file(base_app . $filePath)) {
            return base_url . $filePath . $param;
        } else {
            return base_url . 'dist/img/no-image-available.png';
        }
    } else {
        return base_url . 'dist/img/no-image-available.png';
    }
}

/**
 * Detecta si el usuario está usando un dispositivo móvil.
 *
 * @return bool True si es un dispositivo móvil, de lo contrario false.
 */
function isMobileDevice(){
    $aMobileUA = array(
        '/iphone/i' => 'iPhone', 
        '/ipod/i' => 'iPod', 
        '/ipad/i' => 'iPad', 
        '/android/i' => 'Android', 
        '/blackberry/i' => 'BlackBerry', 
        '/webos/i' => 'Mobile'
    );

    // Retornar true si se detecta un User Agent móvil
    foreach ($aMobileUA as $sMobileKey => $sMobileOS) {
        if (preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])) {
            return true;
        }
    }
    // De lo contrario, retornar false
    return false;
}

ob_end_flush();
?>
