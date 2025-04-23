<?php
// Verifica si la clase DBConnection ya está definida, de lo contrario, incluye los archivos necesarios
if (!class_exists('DBConnection')) {
    require_once('../config.php');
    require_once('DBConnection.php');
}

class SystemSettings extends DBConnection
{
    public function __construct()
    {
        parent::__construct();
    }

    // Función para verificar la conexión a la base de datos
    public function check_connection()
    {
        return ($this->conn);
    }

    // Función para cargar la información del sistema en la sesión
    public function load_system_info()
    {
        // Verifica si la información del sistema ya está cargada en la sesión
        // if (!isset($_SESSION['system_info'])) {
        $sql = "SELECT * FROM system_info";
        $qry = $this->conn->query($sql);
        while ($row = $qry->fetch_assoc()) {
            $_SESSION['system_info'][$row['meta_field']] = $row['meta_value'];
        }
        // }
    }

    // Función para actualizar la información del sistema en la sesión
    public function update_system_info()
    {
        $sql = "SELECT * FROM system_info";
        $qry = $this->conn->query($sql);
        while ($row = $qry->fetch_assoc()) {
            if (isset($_SESSION['system_info'][$row['meta_field']])) unset($_SESSION['system_info'][$row['meta_field']]);
            $_SESSION['system_info'][$row['meta_field']] = $row['meta_value'];
        }
        return true;
    }

    // Función para actualizar la información de configuración del sistema
    public function update_settings_info()
    {
        // Actualizar valores en la base de datos según los datos enviados por el formulario
        // Opcional: Guardar contenido HTML en archivos

        // Actualizar logo si se envía un archivo
        // Actualizar portada si se envía un archivo

        $update = $this->update_system_info();
        $flash = $this->set_flashdata('success', 'Información del sistema actualizada con éxito.');

        if ($update && $flash) {
            return true;
        }
    }

    // Función para establecer datos de usuario en la sesión
    public function set_userdata($field = '', $value = '')
    {
        if (!empty($field) && !empty($value)) {
            $_SESSION['userdata'][$field] = $value;
        }
    }

    // Función para obtener datos de usuario de la sesión
    public function userdata($field = '')
    {
        if (!empty($field)) {
            if (isset($_SESSION['userdata'][$field]))
                return $_SESSION['userdata'][$field];
            else
                return null;
        } else {
            return false;
        }
    }

    // Función para establecer un mensaje flash en la sesión
    public function set_flashdata($flash = '', $value = '')
    {
        if (!empty($flash) && !empty($value)) {
            $_SESSION['flashdata'][$flash] = $value;
            return true;
        }
    }

    // Función para verificar si existe un mensaje flash en la sesión
    public function chk_flashdata($flash = '')
    {
        if (isset($_SESSION['flashdata'][$flash])) {
            return true;
        } else {
            return false;
        }
    }

    // Función para obtener y eliminar un mensaje flash de la sesión
    public function flashdata($flash = '')
    {
        if (!empty($flash)) {
            $_tmp = $_SESSION['flashdata'][$flash];
            unset($_SESSION['flashdata']);
            return $_tmp;
        } else {
            return false;
        }
    }

    // Función para destruir los datos de usuario de la sesión
    public function sess_des()
    {
        if (isset($_SESSION['userdata'])) {
            unset($_SESSION['userdata']);
            return true;
        }
        return true;
    }

    // Función para obtener información del sistema
    public function info($field = '')
    {
        if (!empty($field)) {
            if (isset($_SESSION['system_info'][$field]))
                return $_SESSION['system_info'][$field];
            else
                return false;
        } else {
            return false;
        }
    }

    // Función para establecer información del sistema
    public function set_info($field = '', $value = '')
    {
        if (!empty($field) && !empty($value)) {
            $_SESSION['system_info'][$field] = $value;
        }
    }
}

// Crear una instancia de la clase SystemSettings
$_settings = new SystemSettings();
$_settings->load_system_info();

// Verificar la acción solicitada y llamar a la función correspondiente
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();

switch ($action) {
    case 'update_settings':
        echo $sysset->update_settings_info();
        break;
    default:
        // Manejar el caso predeterminado aquí, si es necesario
        break;
}
?>
