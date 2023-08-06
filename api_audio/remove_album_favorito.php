<?php
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');

    $id_album = $_GET["id"];

    $usuario_consulta = $conexion->prepare("SELECT id from usuario where usuario = ?");
    $usuario_consulta->bind_param('s', $_SESSION["user"]);
    $usuario_consulta->bind_result($usuario);
    $usuario_consulta->execute();
    $usuario_consulta->fetch();
    $usuario_consulta->close();

    $delete = $conexion->prepare("DELETE FROM favorito where album = ? and usuario = ?");
    $delete->bind_param('ii', $id_album, $usuario);
    $delete->execute();
    $delete->close();
    
    $conexion->close();