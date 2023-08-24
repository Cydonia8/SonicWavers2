<?php
    require_once "../php_functions/login_register_functions.php";
    require_once "../php_functions/general.php";
    session_start();
    
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");

    $decoded = decodeToken($_SESSION["token"]);
    $decoded = json_decode(json_encode($decoded), true);
    $user = $decoded["data"]["user"];

    if(isset($_POST["f_nac"]) && isset($_POST["estilo"])){
        $con = createConnection();
        $birth_date = $_REQUEST["f_nac"];
        $style = $_REQUEST["estilo"];
        $avatar_type = $_FILES["foto_avatar"]["type"];
        $new_name;
        switch($avatar_type){
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
        move_uploaded_file($_FILES["foto_avatar"]["tmp_name"], $new_path);

        $update = $con->prepare("UPDATE user set birth_date = ?, style = ?, avatar = ? where username = ?");
        $update->bind_param('siss', $birth_date, $style, $new_path, $user);
        $update->execute();
        $update->close();
        $con->close();
    }

