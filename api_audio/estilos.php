<?php
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');

    $estilos = $conexion->query("SELECT id, nombre from estilo where id <> 0");
    $datos_estilos = [];

    while($fila = $estilos->fetch_array(MYSQLI_ASSOC)){
        $datos_estilos[] = $fila;
    }

    $datos["estilos"] = $datos_estilos;

    echo json_encode($datos);
    $conexion->close();