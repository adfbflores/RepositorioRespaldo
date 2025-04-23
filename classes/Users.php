<?php
require_once('../config.php');

class Users extends DBConnection {
    private $settings;

    public function __construct(){
        global $_settings;
        $this->settings = $_settings;
        parent::__construct();
    }

    public function __destruct(){
        parent::__destruct();
    }

    public function save_users(){
        if(!isset($_POST['status']) && $this->settings->userdata('login_type') == 1){
            $_POST['status'] = 1;
        }

        extract($_POST);
        $oid = $id;
        $data = '';

        if(isset($oldpassword)){
            if(md5($oldpassword) != $this->settings->userdata('password')){
                return 4;
            }
        }

        $chk = $this->conn->query("SELECT * FROM `users` where username ='{$username}' ".($id>0? " and id!= '{$id}' " : ""))->num_rows;

        if($chk > 0){
            return 3;
            exit;
        }

        foreach($_POST as $k => $v){
            if(in_array($k,array('firstname','middlename','lastname','username','type'))){
                if(!empty($data)) $data .=" , ";
                $data .= " {$k} = '{$v}' ";
            }
        }

        if(!empty($password)){
            $password = md5($password);
            if(!empty($data)) $data .=" , ";
            $data .= " `password` = MD5('{$password}') ";
        }

        if(empty($id)){
            $qry = $this->conn->query("INSERT INTO users set {$data}");
            if($qry){
                $id = $this->conn->insert_id;
                $this->settings->set_flashdata('success','Detalles del usuario guardados con éxito.');
                $resp['status'] = 1;
            }else{
                $resp['status'] = 2;
            }
        }else{
            $qry = $this->conn->query("UPDATE users set $data where id = {$id}");
            if($qry){
                $this->settings->set_flashdata('success','Detalles del usuario actualizados con éxito.');
                if($id == $this->settings->userdata('id')){
                    foreach($_POST as $k => $v){
                        if($k != 'id'){
                            if(!empty($data)) $data .=" , ";
                            $this->settings->set_userdata($k,$v);
                        }
                    }
                }
                $resp['status'] = 1;
            }else{
                $resp['status'] = 2;
            }
        }
        
        if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
            $fname = 'uploads/avatar-'.$id.'.png';
            $dir_path =base_app. $fname;
            $upload = $_FILES['img']['tmp_name'];
            $type = mime_content_type($upload);
            $allowed = array('image/png','image/jpeg');
            if(!in_array($type,$allowed)){
                $resp['msg'].=" Pero la imagen no se pudo cargar debido a un tipo de archivo no válido.";
            }else{
                $new_height = 200; 
                $new_width = 200; 
        
                list($width, $height) = getimagesize($upload);
                $t_image = imagecreatetruecolor($new_width, $new_height);
                imagealphablending( $t_image, false );
                imagesavealpha( $t_image, true );
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
                $this->conn->query("UPDATE users set `avatar` = CONCAT('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$id}' ");
                if($id == $this->settings->userdata('id')){
                        $this->settings->set_userdata('avatar',$fname);
                }
            }
        }
        if(isset($resp['msg']))
        $this->settings->set_flashdata('success',$resp['msg']);
        return  $resp['status'];
    }

    public function delete_users(){
        extract($_POST);
        $avatar = $this->conn->query("SELECT avatar FROM users where id = '{$id}'")->fetch_array()['avatar'];
        $qry = $this->conn->query("DELETE FROM users where id = $id");
        if($qry){
            $avatar = explode("?",$avatar)[0];
            $this->settings->set_flashdata('success','Detalles de usuario eliminados con éxito.');
            if(is_file(base_app.$avatar))
                unlink(base_app.$avatar);
            $resp['status'] = 'success';
        }else{
            $resp['status'] = 'failed';
        }
        return json_encode($resp);
    }

    public function save_student(){
        extract($_POST);
        $data = '';

        if(isset($oldpassword)){
            if(md5($oldpassword) != $this->settings->userdata('password')){
                return json_encode(array("status"=>'failed', "msg"=>'Antigua contraseña es incorrecta'));
            }
        }

        $chk = $this->conn->query("SELECT * FROM `student_list` where email ='{$email}' ".($id>0? " and id!= '{$id}' " : ""))->num_rows;

        if($chk > 0){
            return 3;
            exit;
        }

        foreach($_POST as $k => $v){
            if(!in_array($k,array('id','oldpassword','cpassword','password'))){
                if(!empty($data)) $data .=" , ";
                $data .= " {$k} = '{$v}' ";
            }
        }

        if(!empty($password)){
            $password = md5($password);
            if(!empty($data)) $data .=" , ";
            $data .= " `password` = '{$password}' ";
        }

        if(empty($id)){
            $qry = $this->conn->query("INSERT INTO student_list set {$data}");
            if($qry){
                $id = $this->conn->insert_id;
                $this->settings->set_flashdata('success','Los detalles del usuario del estudiante se guardaron con éxito.');
                $resp['status'] = "success";
            }else{
                $resp['status'] = "failed";
                $resp['msg'] = "Ocurrió un error al guardar los datos. Error: ". $this->conn->error;
            }

        }else{
            $qry = $this->conn->query("UPDATE student_list set $data where id = {$id}");
            if($qry){
                $this->settings->set_flashdata('success','Detalles de usuario del estudiante actualizados con éxito.');

                if($id == $this->settings->userdata('id')){
                    foreach($_POST as $k => $v){
                        if($k != 'id'){
                            if(!empty($data)) $data .=" , ";
                            $this->settings->set_userdata($k,$v);
                        }
                    }
                    
                }
                $resp['status'] = "success";
            }else{
                $resp['status'] = "failed";
                $resp['msg'] = "Ocurrió un error al guardar los datos. Error: ". $this->conn->error;
            }
            
        }
        
        if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
            $fname = 'uploads/student-'.$id.'.png';
            $dir_path =base_app. $fname;
            $upload = $_FILES['img']['tmp_name'];
            $type = mime_content_type($upload);
            $allowed = array('image/png','image/jpeg');
            if(!in_array($type,$allowed)){
                $resp['msg'].=" Pero la imagen no se pudo cargar debido a un tipo de archivo no válido.";
            }else{
                $new_height = 200; 
                $new_width = 200; 
        
                list($width, $height) = getimagesize($upload);
                $t_image = imagecreatetruecolor($new_width, $new_height);
                imagealphablending( $t_image, false );
                imagesavealpha( $t_image, true );
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
                $this->conn->query("UPDATE student_list set `avatar` = CONCAT('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$id}' ");
                if($id == $this->settings->userdata('id')){
                        $this->settings->set_userdata('avatar',$fname);
                }
            }
        }
        
        return  json_encode($resp);
    }

    public function delete_student(){
        extract($_POST);
        $avatar = $this->conn->query("SELECT avatar FROM student_list where id = '{$id}'")->fetch_array()['avatar'];
        $qry = $this->conn->query("DELETE FROM student_list where id = $id");
        if($qry){
            $avatar = explode("?",$avatar)[0];
            $this->settings->set_flashdata('success','Detalles de usuario del estudiante eliminados con éxito.');
            if(is_file(base_app.$avatar))
                unlink(base_app.$avatar);
            $resp['status'] = 'success';
        }else{
            $resp['status'] = 'failed';
        }
        return json_encode($resp);
    }

    public function verify_student(){
        extract($_POST);
        $update = $this->conn->query("UPDATE `student_list` set `status` = 1 where id = $id");
        if($update){
            $this->settings->set_flashdata('success','La cuenta de estudiante se ha verificado con éxito.');
            $resp['status'] = 'success';
        }else{
            $resp['status'] = 'failed';
        }
        return json_encode($resp);
    }
}

$users = new Users();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
    case 'save':
        echo $users->save_users();
    break;
    case 'delete':
        echo $users->delete_users();
    break;
    case 'save_student':
        echo $users->save_student();
    break;
    case 'delete_student':
        echo $users->delete_student();
    break;
    case 'verify_student':
        echo $users->verify_student();
    break;
    default:
        // echo $sysset->index();
    break;
}
?>
