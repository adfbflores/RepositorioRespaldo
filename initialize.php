<?php
// Datos de desarrollo
$dev_data = array(
    'id' => '-1',
    'firstname' => 'Jhoel',
    'lastname' => '',
    'username' => 'Jhoel',
    'password' => '5da283a2d990e8d8512cf967df5bc0d0',
    'last_login' => '',
    'date_updated' => '',
    'date_added' => ''
);

$server = $_SERVER['SERVER_NAME'];
$url = $_SERVER['REQUEST_URI'];

if (str_contains($server, 'tecnologicopacifico') || str_contains($url, 'tecnologicopacifico')) { 
    $server = 'https://repositorio.tecnologicopacifico.edu.ec';
}
else{
    $server = 'http://localhost/repositoriotesis';
}
 
// Definiciones de constantes
if (!defined('base_url')) define('base_url', $server.'/');
if (!defined('base_url')) define('base_url', $server.'/');
if (!defined('BASE_APP')) define('BASE_APP', str_replace('\\', '/', __DIR__) . '/');
if (!defined('base_app')) define('base_app', str_replace('\\', '/', __DIR__) . '/');
if (!defined('DEV_DATA')) define('DEV_DATA', $dev_data);
if (!defined('DB_SERVER')) define('DB_SERVER', "localhost");
if (!defined('DB_USERNAME')) define('DB_USERNAME', "root");
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', "");
if (!defined('DB_NAME')) define('DB_NAME', "repositoriotesis");

//$base_app = str_replace('\\', '/', __DIR__) . '/';

// Cargar las variables de entorno si existen
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

$base_url = getenv('BASE_URL') ?: $server.'/';
$base_app = getenv('BASE_APP') ?: str_replace('\\', '/', __DIR__) . '/';
$db_server = getenv('DB_SERVER') ?: 'localhost';
$db_username = getenv('DB_USERNAME') ?: 'root';
$db_password = getenv('DB_PASSWORD') ?: '';
$db_name = getenv('DB_NAME') ?: 'repositoriotesis';
?>
