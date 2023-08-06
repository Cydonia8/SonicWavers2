<?php
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root','','sonicwaves');

    $lista = $_GET["lista"];
    $cancion = $_GET["cancion"];

    $sentencia_comprobar = $conexion->prepare("SELECT count(*) from contiene where lista = ? and cancion = ?");
    $sentencia_comprobar->bind_param('ii', $lista, $cancion);
    $sentencia_comprobar->bind_result($comprobante);
    $sentencia_comprobar->execute();
    $sentencia_comprobar->fetch();
    $sentencia_comprobar->close();

    $ultima_cancion = $conexion->prepare("SELECT orden from contiene where lista = ? order by orden desc limit 1");
    $ultima_cancion->bind_param('i', $lista);
    $ultima_cancion->bind_result($ultima);
    $ultima_cancion->execute();
    $ultima_cancion->fetch();
    $ultima_cancion->close();

    $orden = $ultima != '' ? ++$ultima : 1;


    if($comprobante == 0){
        $insert = $conexion->prepare("INSERT INTO contiene (lista, cancion, orden) values (?,?,?)");
        $insert->bind_param('iii', $lista, $cancion, $orden);
        $insert->execute();
        $insert->close();
        http_response_code(200);
    }else{
        http_response_code(400);
    }
    
    $conexion->close();