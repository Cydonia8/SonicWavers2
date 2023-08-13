<?php
    require_once "../php_functions/login_register_functions.php";
    session_start();
    header("Access-Control-Allow-Origin");
    $con = new mysqli('localhost','root','','sonicwaves');

    $decoded = decodeToken($_SESSION["token"]);
    $decoded = json_decode(json_encode($decoded), true);
    $user = $decoded["data"]["user"];

    if(isset($_FILES["foto"]["type"])){
        $foto_type = $_FILES["foto"]["type"];
            $nuevo_nombre;
            switch($foto_type){
                case "image/jpeg":
                    $nuevo_nombre = $user.'avatar.jpeg';
                    break;
                case "image/webp":
                    $nuevo_nombre = $user.'avatar.webp';
                    break;
                case "image/png":
                    $nuevo_nombre = $user.'avatar.png';
                    break;
            }
            if(!file_exists('../media/img_users/'.$user)){
                mkdir('../media/img_users/'.$user);
            }
            $nueva_ruta = '../media/img_users/'.$user.'/'.$nuevo_nombre;
            move_uploaded_file($_FILES["foto"]["tmp_name"], $nueva_ruta);

        $update = $con->prepare("UPDATE usuario set foto_avatar = ? where usuario = ?");
        $update->bind_param('ss', $nueva_ruta, $user);
        $update->execute();
        $update->close();
    }
    $con->close();
