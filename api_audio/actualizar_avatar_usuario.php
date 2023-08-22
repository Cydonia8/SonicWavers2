<?php
    require_once "../php_functions/login_register_functions.php";
    session_start();
    header("Access-Control-Allow-Origin");
    $con = createConnection();

    $decoded = decodeToken($_SESSION["token"]);
    $decoded = json_decode(json_encode($decoded), true);
    $user = $decoded["data"]["user"];

    if(isset($_FILES["foto"]["type"])){
        $foto_type = $_FILES["foto"]["type"];
            $new_name;
            switch($foto_type){
                case "image/jpeg":
                    $new_name = $user.'avatar.jpeg';
                    break;
                case "image/webp":
                    $new_name = $user.'avatar.webp';
                    break;
                case "image/png":
                    $new_name = $user.'avatar.png';
                    break;
            }
            if(!file_exists('../media/img_users/'.$user)){
                mkdir('../media/img_users/'.$user);
            }
            $new_path = '../media/img_users/'.$user.'/'.$new_name;
            move_uploaded_file($_FILES["foto"]["tmp_name"], $new_path);

        $update = $con->prepare("UPDATE user set avatar = ? where username = ?");
        $update->bind_param('ss', $nueva_ruta, $user);
        $update->execute();
        $update->close();
    }
    $con->close();
