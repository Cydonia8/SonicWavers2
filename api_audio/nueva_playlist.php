<?php
    session_start();
    require_once "../php_functions/general.php";
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $fecha = date('Y-m-d');
    $usuario = $_SESSION["user"];
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');
    $id_user = $conexion->prepare("SELECT id from usuario where usuario = ?");
    $id_user->bind_param('s', $usuario);
    $id_user->bind_result($id);
    $id_user->execute();
    $id_user->fetch();
    $id_user->close();
    $nuevo_id = getAutoID("lista");

    $consulta_num_lista = $conexion->prepare("SELECT count(*) total from lista l, usuario u where u.id = l.usuario and u.usuario = ?");
    $consulta_num_lista->bind_param('s', $usuario);
    $consulta_num_lista->bind_result($numero_lista);
    $consulta_num_lista->execute();
    $consulta_num_lista->fetch();
    $consulta_num_lista->close();

    $numero_lista = ++$numero_lista;

        $nombre = $_POST["nombre"] != "" ? $_POST["nombre"] : "Lista".$numero_lista;
        if(isset($_FILES["foto"]["type"])){
            $foto_type = $_FILES["foto"]["type"];
            $nuevo_nombre;
            switch($foto_type){
                case "image/jpeg":
                    $nuevo_nombre = $usuario.'lista'.$numero_lista.'.jpeg';
                    break;
                case "image/webp":
                    $nuevo_nombre = $usuario.'lista'.$numero_lista.'.webp';
                    break;
                case "image/png":
                    $nuevo_nombre = $usuario.'lista'.$numero_lista.'.png';
                    break;
            }
            if(!file_exists('../media/img_users/'.$usuario)){
                mkdir('../media/img_users/'.$usuario);
            }
            $nueva_ruta = '../media/img_users/'.$usuario.'/'.$nuevo_nombre;
            move_uploaded_file($_FILES["foto"]["tmp_name"], $nueva_ruta);
        }else{
            $ruta_default = '../media/assets/no_cover.jpg';
            if(!file_exists('../media/img_users/'.$usuario)){
                mkdir('../media/img_users/'.$usuario);
            }
            copy($ruta_default, '../media/img_users/'.$usuario.'/no_cover.jpg');
            rename('../media/img_users/'.$usuario.'/no_cover.jpg', '../media/img_users/'.$usuario.'/'.$usuario.'lista'.$numero_lista.'.jpg');
            $nueva_ruta = '../media/img_users/'.$usuario.'/'.$usuario.'lista'.$numero_lista.'.jpg';
        }  
        

        $crear = $conexion->prepare("INSERT INTO lista (nombre, foto, fecha_creacion, usuario) values (?,?,?,?)");
        $crear->bind_param('sssi', $nombre, $nueva_ruta, $fecha, $id);
        $crear->execute();