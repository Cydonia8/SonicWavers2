<?php
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");

    $id = $_GET["id"];
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');

    $delete = $conexion->prepare("DELETE FROM contiene where lista = ?");
    $delete->bind_param('i', $id);
    $delete->execute();
    $delete->close();

    $consulta_foto = $conexion->prepare("SELECT foto from lista where id = ?");
    $consulta_foto->bind_param('i', $id);
    $consulta_foto->bind_result($foto);
    $consulta_foto->execute();
    $consulta_foto->fetch();
    $consulta_foto->close();

    unlink($foto);

    $delete_lista = $conexion->prepare("DELETE FROM lista where id = ?");
    $delete_lista->bind_param('i', $id);
    $delete_lista->execute();
    $delete_lista->close();

    $conexion->close();
