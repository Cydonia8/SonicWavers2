<?php
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $usuario = $_SESSION["user"];
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');
    $id_user = $conexion->prepare("SELECT id from usuario where usuario = ?");
    $id_user->bind_param('s', $usuario);
    $id_user->bind_result($id);
    $id_user->execute();
    $id_user->fetch();
    $id_user->close();

    $datos_lista = [];

    $consulta_listas = $conexion->prepare("SELECT l.id id, l.nombre nombre, foto, u.usuario usuario from lista l, usuario u where l.usuario = u.id and l.usuario = ?");
    $consulta_listas->bind_param('i', $id);
    $consulta_listas->execute();
    $resultado=$consulta_listas->get_result();

    while($fila = $resultado->fetch_assoc()){
        $datos_lista[] = $fila;
    }

    $datos["listas"] = $datos_lista;
    $consulta_listas->close();
    $conexion->close();
    echo json_encode($datos);