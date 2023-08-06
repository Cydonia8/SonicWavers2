<?php
    session_start();
    $usuario = $_SESSION["user"];
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    if(isset($_POST["f_nac"]) && isset($_POST["estilo"])){
        $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');
        $f_nac = $_REQUEST["f_nac"];
        $estilo = $_REQUEST["estilo"];
        $foto_avatar_type = $_FILES["foto_avatar"]["type"];
        $nuevo_nombre;
        switch($foto_avatar_type){
            case "image/jpeg":
                $nuevo_nombre = $usuario.'avatar.jpeg';
                break;
            case "image/webp":
                $nuevo_nombre = $usuario.'avatar.webp';
                break;
            case "image/png":
                $nuevo_nombre = $usuario.'avatar.png';
                break;
        }
        if(!file_exists('../media/img_users/'.$usuario)){
            mkdir('../media/img_users/'.$usuario);
        }
        $nueva_ruta = '../media/img_users/'.$usuario.'/'.$nuevo_nombre;
        move_uploaded_file($_FILES["foto_avatar"]["tmp_name"], $nueva_ruta);

        $update = $conexion->prepare("UPDATE usuario set f_nac = ?, estilo = ?, foto_avatar = ? where usuario = ?");
        $update->bind_param('siss', $f_nac, $estilo, $nueva_ruta, $usuario);
        $update->execute();
        $update->close();
        $conexion->close();
    }

