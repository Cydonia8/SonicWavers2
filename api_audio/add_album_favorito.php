<?php
    require_once "../php_functions/login_register_functions.php";
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");

    $decoded = decodeToken($_SESSION["token"]);
    $decoded = json_decode(json_encode($decoded), true);
    $user = $decoded["data"]["user"];

    $con = createConnection();

    $id_album = $_GET["id"];

    $usuario_consulta = $con->prepare("SELECT id from user where username = ?");
    $usuario_consulta->bind_param('s', $user);
    $usuario_consulta->bind_result($user_id);
    $usuario_consulta->execute();
    $usuario_consulta->fetch();
    $usuario_consulta->close();

    $insert = $con->prepare("INSERT INTO favorite (user, album) values (?,?)");
    $insert->bind_param('ii', $user_id, $id_album);
    $insert->execute();
    $insert->close();
    
    $con->close();