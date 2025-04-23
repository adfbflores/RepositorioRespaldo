<?php
// Incluye el archivo de configuración
require_once '../config.php';

class Login extends DBConnection {
    private $settings;

    // Constructor de la clase
    public function __construct(){
        global $_settings;
        $this->settings = $_settings;

        // Llama al constructor de la clase padre
        parent::__construct();

        // Configura la visualización de errores
        ini_set('display_error', 1);
    }

    // Destructor de la clase
    public function __destruct(){
        // Llama al destructor de la clase padre
        parent::__destruct();
    }

    // Método para mostrar un mensaje de acceso denegado
    public function index(){
        echo "<h1>Acceso denegado</h1> <a href='".base_url."'>Volver.</a>";
    }

    // Método para iniciar sesión de usuario
    public function login(){
        // Extrae los datos del formulario de inicio de sesión
        extract($_POST);

        // Consulta a la base de datos para verificar las credenciales del usuario
        $qry = $this->conn->query("SELECT * FROM users WHERE username = '$username' AND password = md5('$password')");

        // Verifica si se encontró al menos un usuario con las credenciales proporcionadas
        if($qry->num_rows > 0){
            $res = $qry->fetch_array();

            // Verifica si el estado del usuario es activo
            if($res['status'] != 1){
                return json_encode(array('status'=>'notverified'));
            }

            // Almacena los datos del usuario en la sesión
            foreach($res as $k => $v){
                if(!is_numeric($k) && $k != 'password'){
                    $this->settings->set_userdata($k,$v);
                }
            }

            // Establece el tipo de inicio de sesión
            $this->settings->set_userdata('login_type',1);

            return json_encode(array('status'=>'success'));
        } else {
            // Si las credenciales son incorrectas, devuelve un mensaje de error
            return json_encode(array('status'=>'incorrect','last_qry'=>"SELECT * FROM users WHERE username = '$username' AND password = md5('$password')"));
        }
    }

    // Método para cerrar sesión de usuario
    public function logout(){
        // Cierra la sesión y redirige al usuario a la página de inicio de sesión
        if($this->settings->sess_des()){
            redirect('admin/login.php');
        }
    }

    // Método para iniciar sesión de estudiante
    public function student_login(){
        // Extrae los datos del formulario de inicio de sesión de estudiante
        extract($_POST);

        // Consulta a la base de datos para verificar las credenciales del estudiante
        $qry = $this->conn->query("SELECT *, CONCAT(lastname,', ',firstname,' ',middlename) AS fullname FROM student_list WHERE email = '$email' AND `password` = md5('$password') ");

        // Verifica si se encontró al menos un estudiante con las credenciales proporcionadas
        if($qry->num_rows > 0){
            $res = $qry->fetch_array();

            // Verifica si la cuenta del estudiante está verificada
            if($res['status'] == 1){
                foreach($res as $k => $v){
                    $this->settings->set_userdata($k,$v);
                }
                // Establece el tipo de inicio de sesión
                $this->settings->set_userdata('login_type',2);
                $resp['status'] = 'success';
            } else {
                // Devuelve un mensaje de error si la cuenta del estudiante no está verificada
                $resp['status'] = 'failed';
                $resp['msg'] = "Tu cuenta no se ha verificado aún.";
            }
        } else {
            // Devuelve un mensaje de error si las credenciales son incorrectas
            $resp['status'] = 'failed';
            $resp['msg'] = "Correo electrónico o contraseña no válidos.";
        }

        return json_encode($resp);
    }

    // Método para cerrar sesión de estudiante
    public function student_logout(){
        // Cierra la sesión del estudiante y redirige a la página principal
        if($this->settings->sess_des()){
            redirect('./');
        }
    }
}

// Crea una instancia de la clase Login
$auth = new Login();

// Determina la acción a realizar según el parámetro 'f' en la URL
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);

// Ejecuta la acción correspondiente
switch ($action) {
    case 'login':
        echo $auth->login();
        break;
    case 'logout':
        echo $auth->logout();
        break;
    case 'student_login':
        echo $auth->student_login();
        break;
    case 'student_logout':
        echo $auth->student_logout();
        break;
    default:
        echo $auth->index();
        break;
}
?>
