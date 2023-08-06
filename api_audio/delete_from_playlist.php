<?php
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');

    $id_cancion = $_GET["id_cancion"];
    $id_lista = $_GET["id_lista"];

    $delete = $conexion->prepare("DELETE FROM contiene where lista = ? and cancion = ?");
    $delete->bind_param('ii', $id_lista, $id_cancion);
    $delete->execute();
    $delete->close();
    $conexion->close();