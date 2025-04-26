<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
// Incluye el archivo de configuración
require_once('../config.php');

class Master extends DBConnection {
    private $settings;

    // Constructor de la clase
    public function __construct(){
        global $_settings;
        $this->settings = $_settings;
        parent::__construct();
    }

    // Destructor de la clase
    public function __destruct(){
        parent::__destruct();
    }

    // Método para capturar errores de la conexión
    function capture_err(){
        if(!$this->conn->error)
            return false;
        else{
            $resp['status'] = 'failed';
            $resp['error'] = $this->conn->error;
            return json_encode($resp);
            exit;
        }
    }

    // Método para guardar un departamento
    function save_department(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k => $v){
            if(!in_array($k, array('id'))){
                if(!is_numeric($v))
                    $v = $this->conn->real_escape_string($v);
                if(!empty($data)) $data .=",";
                $data .= " `{$k}`='{$v}' ";
            }
        }
        if(empty($id)){
            $sql = "INSERT INTO `department_list` SET {$data} ";
        }else{
            $sql = "UPDATE `department_list` SET {$data} WHERE id = '{$id}' ";
        }
        $check = $this->conn->query("SELECT * FROM `department_list` WHERE `name`='{$name}' ".($id > 0 ? " AND id != '{$id}'" : ""))->num_rows;
        if($check > 0){
            $resp['status'] = 'failed';
            $resp['msg'] = "El nombre del departamento ya existe.";
        }else{
            $save = $this->conn->query($sql);
            if($save){
                $rid = !empty($id) ? $id : $this->conn->insert_id;
                $resp['status'] = 'success';
                if(empty($id))
                    $resp['msg'] = "Detalles del departamento agregados con éxito.";
                else
                    $resp['msg'] = "Los detalles del departamento se han actualizado con éxito.";
            }else{
                $resp['status'] = 'failed';
                $resp['msg'] = "Ocurrió un error.";
                $resp['err'] = $this->conn->error."[{$sql}]";
            }
        }
        if($resp['status'] =='success')
            $this->settings->set_flashdata('success',$resp['msg']);
        return json_encode($resp);
    }

    // Método para eliminar un departamento
    function delete_department(){
        extract($_POST);
        $del = $this->conn->query("DELETE FROM `department_list` WHERE id = '{$id}'");
        if($del){
            $resp['status'] = 'success';
            $this->settings->set_flashdata('success',"El departamento ha sido eliminado con éxito.");
        }else{
            $resp['status'] = 'failed';
            $resp['error'] = $this->conn->error;
        }
        return json_encode($resp);
    }

    // Método para guardar un plan de estudios
    function save_curriculum(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k => $v){
            if(!in_array($k, array('id'))){
                if(!is_numeric($v))
                    $v = $this->conn->real_escape_string($v);
                if(!empty($data)) $data .=",";
                $data .= " `{$k}`='{$v}' ";
            }
        }
        if(empty($id)){
            $sql = "INSERT INTO `curriculum_list` SET {$data} ";
        }else{
            $sql = "UPDATE `curriculum_list` SET {$data} WHERE id = '{$id}' ";
        }
        $check = $this->conn->query("SELECT * FROM `curriculum_list` WHERE `name`='{$name}' AND `department_id` = '{department_id}' ".($id > 0 ? " AND id != '{$id}'" : ""))->num_rows;
        if($check > 0){
            $resp['status'] = 'failed';
            $resp['msg'] = "El nombre de la materia ya existe.";
        }else{
            $save = $this->conn->query($sql);
            if($save){
                $rid = !empty($id) ? $id : $this->conn->insert_id;
                $resp['status'] = 'success';
                if(empty($id))
                    $resp['msg'] = "Detalles de la materia agregados con éxito.";
                else
                    $resp['msg'] = "Los detalles de la materia se han actualizado con éxito.";
            }else{
                $resp['status'] = 'failed';
                $resp['msg'] = "Ocurrió un error.";
                $resp['err'] = $this->conn->error."[{$sql}]";
            }
        }
        if($resp['status'] =='success')
            $this->settings->set_flashdata('success',$resp['msg']);
        return json_encode($resp);
    }

    // Método para eliminar un plan de estudios
    function delete_curriculum(){
        extract($_POST);
        $del = $this->conn->query("DELETE FROM `curriculum_list` WHERE id = '{$id}'");
        if($del){
            $resp['status'] = 'success';
            $this->settings->set_flashdata('success',"La materia se ha eliminado correctamente.");
        }else{
            $resp['status'] = 'failed';
            $resp['error'] = $this->conn->error;
        }
        return json_encode($resp);
    }

    // Método para guardar un archivo
    function save_archive(){
        if(empty($_POST['id'])){
            $pref= date("Ym");
            $code = sprintf("%'.04d",1);
            while(true){
                $check = $this->conn->query("SELECT * FROM `archive_list` WHERE archive_code = '{$pref}{$code}'")->num_rows;
                if($check > 0){
                    $code = sprintf("%'.04d",abs($code)+1);
                }else{
                    break;
                }
            }
            $_POST['archive_code'] = $pref.$code;
            $_POST['student_id'] = $this->settings->userdata('id');
            $_POST['curriculum_id'] = $this->settings->userdata('curriculum_id');
        }
        if(isset($_POST['abstract']))
            $_POST['abstract'] = htmlentities($_POST['abstract']);
        if(isset($_POST['members']))
            $_POST['members'] = htmlentities($_POST['members']);
        extract($_POST);
        $data = "";
        if(isset($_FILES['pdf']) && !empty($_FILES['pdf']['tmp_name'])){
            $type = mime_content_type($_FILES['pdf']['tmp_name']);
            if($type != "application/pdf"){
                $resp['status'] = "failed";
                $resp['msg'] = "Tipo de archivo de documento";
                $resp['msg'] = "Tipo de archivo de documento no válido.";
                return json_encode($resp);
            } 
        }
        foreach($_POST as $k => $v){
            if(!in_array($k, array('id')) && !is_array($_POST[$k])){
                if(!is_numeric($v))
                    $v = $this->conn->real_escape_string($v);
                if(!empty($data)) $data .=",";
                $data .= " `{$k}`='{$v}' ";
            }
        }
        if(empty($id)){
            $sql = "INSERT INTO `archive_list` SET {$data} ";
        }else{
            $sql = "UPDATE `archive_list` SET {$data} WHERE id = '{$id}' ";
        }
        $save = $this->conn->query($sql);
        if($save){
            $aid = !empty($id) ? $id : $this->conn->insert_id;
            $resp['status'] = 'success';
            $resp['id'] = $aid;
            if(empty($id))
                $resp['msg'] = "El archivo se envió con éxito";
            else
                $resp['msg'] = "Los detalles del archivo se actualizaron correctamente.";

            if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
                $fname = 'uploads/banners/archive-'.$aid.'.png';
                $dir_path = base_app . $fname;
                $upload = $_FILES['img']['tmp_name'];
                $type = mime_content_type($upload);
                $allowed = array('image/png','image/jpeg');
                if(!in_array($type,$allowed)){
                    $resp['msg'].=" Pero la imagen no se pudo cargar debido a un tipo de archivo no válido.";
                }else{
                    $new_height = 720; 
                    $new_width = 1280;  

                    list($width, $height) = getimagesize($upload);
                    $t_image = imagecreatetruecolor($new_width, $new_height);
                    imagealphablending($t_image, false);
                    imagesavealpha($t_image, true);
                    $gdImg = ($type == 'image/png')? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
                    imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                    if($gdImg){
                        if(is_file($dir_path))
                            unlink($dir_path);
                        $uploaded_img = imagepng($t_image,$dir_path);
                        imagedestroy($gdImg);
                        imagedestroy($t_image);
                    }else{
                        $resp['msg'].=" Pero la imagen no se pudo cargar debido a un motivo desconocido.";
                    }
                }
                if(isset($uploaded_img)){
                    $this->conn->query("UPDATE archive_list SET `banner_path` = CONCAT('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) WHERE id = '{$aid}' ");
                }
            }
            if(isset($_FILES['pdf']) && $_FILES['pdf']['tmp_name'] != ''){
                $fname = 'uploads/pdf/archive-'.$aid.'.pdf';
                $dir_path = base_app . $fname;
                $upload = $_FILES['pdf']['tmp_name'];
                $type = mime_content_type($upload);
                $allowed = array('application/pdf');
                if(!in_array($type,$allowed)){
                    $resp['msg'].=" Pero el archivo del documento no se pudo cargar debido a un tipo de archivo no válido.";
                }else{
                    $uploaded = move_uploaded_file($_FILES['pdf']['tmp_name'],$dir_path);
                }
                if(isset($uploaded)){
                    $this->conn->query("UPDATE archive_list SET `document_path` = CONCAT('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) WHERE id = '{$aid}' ");
                }
            }
        }else{
            $resp['status'] = 'failed';
            $resp['msg'] = "Ocurrió un error.";
            $resp['err'] = $this->conn->error."[{$sql}]";
        }
        if($resp['status'] =='success')
            $this->settings->set_flashdata('success',$resp['msg']);
        return json_encode($resp);
    }

    // Método para eliminar un archivo
    function delete_archive(){
        extract($_POST);
        $get = $this->conn->query("SELECT * FROM `archive_list` WHERE id = '{$id}'");
        $sql = "DELETE FROM `archive_list` WHERE id = '{$id}'";
        //echo "<br/>sql: ".$sql."<br/>";
        $del = $this->conn->query($sql);
        //echo '<br/>error1: '.$this->conn->error."<br/>";
        //echo "<br/>num_rows: ".$get->num_rows."<br/>";
        if($del){
            $resp['status'] = 'success';
            $this->settings->set_flashdata('success',"El archivo de registros se eliminó con éxito.");
            if($get->num_rows > 0){
                $res = $get->fetch_array();
                $banner_path = explode("?",$res['banner_path'])[0];
                $document_path = explode("?",$res['document_path'])[0];
                if(is_file(base_app.$banner_path))
                    unlink(base_app.$banner_path);
                if(is_file(base_app.$document_path))
                    unlink(base_app.$document_path);
            }
        }else{
            $resp['status'] = 'failed';
            $resp['error'] = $this->conn->error;
        }
        return json_encode($resp);
    }

    public function save_archive_admin(){
        extract($_POST);
        $upload_path = '';
        $old_file = '';
    
        if (!empty($id)) {
            $qry = $this->conn->query("SELECT file_path FROM archive_list WHERE id = '{$id}'");
            if($qry->num_rows > 0){
                $old_file = $qry->fetch_assoc()['file_path'];
            }
        }
    
        if (!empty($_FILES['file']['tmp_name'])) {
            $filename = time() . "_" . $_FILES['file']['name'];
            $upload_path = "uploads/tesis/" . $filename;
    
            if (!move_uploaded_file($_FILES['file']['tmp_name'], base_app . $upload_path)) {
                return json_encode(['status' => 'failed', 'msg' => 'No se pudo subir el archivo nuevo.']);
            }
    
            if (!empty($old_file) && file_exists(base_app . $old_file)) {
                unlink(base_app . $old_file);
            }
        }
    
        if (empty($upload_path) && !empty($old_file)) {
            $upload_path = $old_file;
        }
    
        if (empty($id)) {
            $sql = "INSERT INTO archive_list (archive_code, title, members, curriculum_id, year, abstract, file_path, status) VALUES (?, ?, ?, ?, ?, ?, ?, 1)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sssisss", $archive_code, $title, $members, $curriculum_id, $year, $abstract, $upload_path);
        } else {
            $sql = "UPDATE archive_list SET archive_code=?, title=?, members=?, curriculum_id=?, year=?, abstract=?, file_path=? WHERE id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sssisssi", $archive_code, $title, $members, $curriculum_id, $year, $abstract, $upload_path, $id);
        }
    
        if($stmt->execute()) {
            return json_encode(['status' => 'success']);
        } else {
            return json_encode(['status' => 'failed', 'msg' => 'Error al guardar en base de datos.']);
        }
    }        
    
    // Método para actualizar el estado de un archivo
    function update_status(){
        extract($_POST);
        $sql = "UPDATE `archive_list` SET status  = '{$status}' WHERE id = '{$id}'";
        $update = $this->conn->query($sql);
        if($update){
            $resp['status'] = 'success';
            $resp['msg'] = "El estado del archivo se ha actualizado correctamente.";
        }else{
            $resp['status'] = 'failed';
            $resp['msg'] = "Ocurrió un error. Error: " .$this->conn->error;
        }
        
        if($resp['status'] =='success')
            $this->settings->set_flashdata('success',$resp['msg']);
        return json_encode($resp);
    }
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
    case 'save_department':
        echo $Master->save_department();
    break;
    case 'delete_department':
        echo $Master->delete_department();
    break;
    case 'save_curriculum':
        echo $Master->save_curriculum();
    break;
    case 'delete_curriculum':
        echo $Master->delete_curriculum();
    break;
    case 'save_archive':
        echo $Master->save_archive();
    break;
    case 'delete_archive':
        echo $Master->delete_archive();
    case 'update_status':
        echo $Master->update_status();
    break;
}
