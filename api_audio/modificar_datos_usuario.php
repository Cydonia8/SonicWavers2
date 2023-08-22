<?php
    require_once "../php_functions/login_register_functions.php";

    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin:*");

    $decoded = decodeToken($_SESSION["token"]);
    $decoded = json_decode(json_encode($decoded), true);
    $user = $decoded["data"]["user"];

    $con = new mysqli('localhost', 'root', '', 'sonicwaves');
    $query_current_mail = $con->prepare("SELECT mail from user where username = ?");
    $query_current_mail->bind_param('s', $user);
    $query_current_mail->bind_result($current_mail);
    $query_current_mail->execute();
    $query_current_mail->fetch();
    $query_current_mail->close();

    if(isset($_REQUEST["nombre"]) and isset($_REQUEST["apellidos"]) and isset($_REQUEST["correo"]) and isset($_REQUEST["pass"]) and isset($_REQUEST["estilo"])){
        $name = $_REQUEST["nombre"];
        $surname = $_REQUEST["apellidos"];
        $mail = $_REQUEST["correo"];
        $pass = $_REQUEST["pass"];
        $style = $_REQUEST["estilo"];

        $mail_repeated = $con->prepare("SELECT count(*) from user where mail = ? and ?<>?");
        $mail_repeated->bind_param('sss', $mail, $current_mail, $mail);
        $mail_repeated->bind_result($is_repeated);
        $mail_repeated->execute();
        $mail_repeated->fetch();
        $mail_repeated->close();

        if($is_repeated == 0){
            $update = $con->prepare("UPDATE user set name = ?, surname = ?, mail = ?, pass = ?, style = ? where username = ?");
            $update->bind_param('ssssis', $name, $surname, $mail, $pass, $style, $user);
            $update->execute();
            $update->close();
        }else{
            http_response_code(409);
        }
        $con->close();
        
    }