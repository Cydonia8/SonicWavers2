<?php
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $con = new mysqli('localhost', 'root', '', 'sonicwaves');

    $consulta = $con->prepare("SELECT low_eq, midlows_eq, mids_eq, midhighs_eq, high_eq from usuario where usuario = ?");
    $consulta->bind_param('s', $_SESSION["user"]);
    $consulta->execute();
    $resultado = $consulta->get_result();
    $datos_eq = [];

    while($fila = $resultado->fetch_assoc()){
        $datos_eq[] = $fila;
    }   

    $datos["valores_eq"] = $datos_eq;
    $consulta->close();
    $con->close();
    echo json_encode($datos);

