<?php
    session_start();
    $usuario = $_SESSION["user"];
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");

    if(isset($_REQUEST["contenido"]) and isset($_REQUEST["titulo"]) and isset($_REQUEST["id-album"])){
        $titulo = $_REQUEST["titulo"];
        $contenido = $_REQUEST["contenido"];
        $album = $_REQUEST["id-album"];
        $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');
        $id_user = $conexion->prepare("SELECT id from usuario where usuario = ?");
        $id_user->bind_param('s', $usuario);
        $id_user->bind_result($id_usuario);
        $id_user->execute();
        $id_user->fetch();
        $id_user->close();

        $fecha = date('Y-m-d');
        $insert = $conexion->prepare("INSERT INTO reseña (titulo, contenido, usuario, album, fecha) values (?,?,?,?,?)");
        $insert->bind_param('ssiis', $titulo, $contenido, $id_usuario, $album, $fecha);
        $insert->execute();
        $insert->close();
        $conexion->close();
    }
    
