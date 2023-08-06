<?php
    session_start();
    header("Access-Control-Allow-Origin");
    $con = new mysqli('localhost','root','','sonicwaves');

    if(isset($_FILES["foto"]["type"])){
        $foto_type = $_FILES["foto"]["type"];
            $nuevo_nombre;
            switch($foto_type){
                case "image/jpeg":
                    $nuevo_nombre = $_SESSION["user"].'avatar.jpeg';
                    break;
                case "image/webp":
                    $nuevo_nombre = $_SESSION["user"].'avatar.webp';
                    break;
                case "image/png":
                    $nuevo_nombre = $_SESSION["user"].'avatar.png';
                    break;
            }
            if(!file_exists('../media/img_users/'.$_SESSION["user"])){
                mkdir('../media/img_users/'.$_SESSION["user"]);
            }
            $nueva_ruta = '../media/img_users/'.$_SESSION["user"].'/'.$nuevo_nombre;
            move_uploaded_file($_FILES["foto"]["tmp_name"], $nueva_ruta);

        $update = $con->prepare("UPDATE usuario set foto_avatar = ? where usuario = ?");
        $update->bind_param('ss', $nueva_ruta, $_SESSION["user"]);
        $update->execute();
        $update->close();
    }
    $con->close();
