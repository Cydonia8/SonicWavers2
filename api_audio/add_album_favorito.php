<?php
    require_once "../php_functions/login_register_functions.php";
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");

    $decoded = decodeToken($_SESSION["token"]);
    $decoded = json_decode(json_encode($decoded), true);
    $user = $decoded["data"]["user"];

    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');

    $id_album = $_GET["id"];

    $usuario_consulta = $conexion->prepare("SELECT id from usuario where usuario = ?");
    $usuario_consulta->bind_param('s', $user);
    $usuario_consulta->bind_result($usuario);
    $usuario_consulta->execute();
    $usuario_consulta->fetch();
    $usuario_consulta->close();

    $insert = $conexion->prepare("INSERT INTO favorito (usuario, album) values (?,?)");
    $insert->bind_param('ii', $usuario, $id_album);
    $insert->execute();
    $insert->close();
    
    $conexion->close();