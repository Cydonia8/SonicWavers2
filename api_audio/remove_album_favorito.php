<?php
    require_once "../php_functions/login_register_functions.php";
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');

    $decoded = decodeToken($_SESSION["token"]);
    $decoded = json_decode(json_encode($decoded), true);
    $user = $decoded["data"]["user"];

    $id_album = $_GET["id"];

    $usuario_consulta = $conexion->prepare("SELECT id from usuario where usuario = ?");
    $usuario_consulta->bind_param('s', $user);
    $usuario_consulta->bind_result($user_id);
    $usuario_consulta->execute();
    $usuario_consulta->fetch();
    $usuario_consulta->close();

    $delete = $conexion->prepare("DELETE FROM favorito where album = ? and usuario = ?");
    $delete->bind_param('ii', $id_album, $user_id);
    $delete->execute();
    $delete->close();
    
    $conexion->close();