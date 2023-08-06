<?php
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');
    sleep(1);
    $sentencia = $conexion->query("select c.titulo titulo, archivo, g.nombre grupo, a.foto caratula from cancion c, album a, grupo g, incluye i where c.id = i.cancion and a.id = i.album and g.id = a.grupo order by rand() limit 1");
    $datos = [];
    
    while($fila = $sentencia->fetch_array(MYSQLI_ASSOC)){
        $datos[] = $fila;
    }
    $info['datos'] = $datos;
    

    echo json_encode($info);
    $conexion->close();