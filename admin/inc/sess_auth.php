<?php
// Iniciar la sesión si aún no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Construir el enlace actual considerando si es HTTPS o HTTP
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$link = "$protocol://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

// Verificar si el usuario no está autenticado y redirigir a la página de login si es necesario
if (!isset($_SESSION['userdata']) && !str_contains($link, 'login.php') && !str_contains($link, 'register.php')) {
    redirect('admin/login.php');
    exit; // Asegurar que el script se detenga después de redirigir
}

// Verificar si el usuario ya está autenticado y redirigir a la página principal si intenta acceder a la página de login
if (isset($_SESSION['userdata']) && str_contains($link, 'login.php')) {
    redirect('admin/index.php');
    exit; // Asegurar que el script se detenga después de redirigir
}

// Definir los módulos de acuerdo al tipo de usuario
$module = array('', 'admin', 'faculty', 'student');

// Verificar el tipo de usuario y redirigir si no tiene permisos para acceder a la página actual
if (isset($_SESSION['userdata']) && (str_contains($link, 'index.php') || str_contains($link, 'admin/')) && $_SESSION['userdata']['login_type'] != 1) {
    echo "<script>alert('Acceso Denegado!'); location.replace('" . base_url . $module[$_SESSION['userdata']['login_type']] . "');</script>";
    exit; // Asegurar que el script se detenga después de redirigir
}

?>

