<?php
// Verifica si la constante DB_SERVER está definida
if (!defined('DB_SERVER')) {
    // Si no está definida, incluye el archivo "initialize.php" que debería definirla
    require_once("../initialize.php");
}

class DBConnection {
    // Define las propiedades para la conexión a la base de datos
    //private string $host = "localhost";
    /*private string $username = "skiol5ax@localhost";
    private string $password = "admin123";
    private string $database = "skiol5ax_repositooriotesis";*/

    private $host = DB_SERVER;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $database = DB_NAME;

    public $conn; // Variable para la conexión

    // Constructor de la clase
    public function __construct() {
        // Verifica si la conexión no está establecida
        if (!isset($this->conn)) {
            // Intenta establecer la conexión
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            
            // Verifica si la conexión no pudo establecerse
            if ($this->conn->connect_error) {
                // Muestra un mensaje de error y termina el script
                echo 'No se puede conectar al servidor de la base de datos';
                exit;
            }
        }
    }

    // Destructor de la clase, se encarga de cerrar la conexión
    public function __destruct() {
        // Cierra la conexión a la base de datos
        $this->conn->close();
    }
}
?>
